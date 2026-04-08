<?php

namespace App\Services;

use App\Ai\Agents\JobDescriptionParserAgent;
use App\Ai\Agents\MatchGapExplainerAgent;
use App\Ai\Agents\ResumeParserAgent;
use App\Models\JobProfile;
use App\Models\ResumeJobMatch;
use App\Models\ResumeProfile;
use Illuminate\Support\Collection;
use Laravel\Ai\Embeddings;
use Laravel\Ai\Reranking;

class ResumeJobMatchingEngine
{
    public function parseResume(string $resumeText): array
    {
        $response = (new ResumeParserAgent)->prompt($resumeText);

        return $this->normalizeProfileArray((array) $response);
    }

    public function parseJob(string $jobText): array
    {
        $response = (new JobDescriptionParserAgent)->prompt($jobText);

        return $this->normalizeProfileArray((array) $response);
    }

    /**
     * @param  Collection<int, JobProfile>  $jobs
     * @return Collection<int, array<string, mixed>>
     */
    public function scoreAndPersistMatches(ResumeProfile $resume, Collection $jobs): Collection
    {
        if ($jobs->isEmpty()) {
            return collect();
        }

        $rerankResults = [];
        try {
            $reranked = Reranking::of($jobs->pluck('raw_text')->all())
                ->limit($jobs->count())
                ->rerank($resume->raw_text);

            $rerankResults = $reranked->collect()
                ->mapWithKeys(fn ($row) => [(int) $row->index => (float) $row->score])
                ->all();
        } catch (\Throwable) {
            // Reranking may not be configured; keep cosine-only scoring.
        }

        return $jobs->values()->map(function (JobProfile $job, int $index) use ($resume, $rerankResults) {
            $resumeEmbedding = $this->asVector($resume->embedding ?? []);
            $jobEmbedding = $this->asVector($job->embedding ?? []);

            $cosine = $this->cosineSimilarity($resumeEmbedding, $jobEmbedding);
            $rerank = $rerankResults[$index] ?? null;
            $score = $this->blendScores($cosine, $rerank);

            $resumeSkills = $this->skillListFromParsed($resume->parsed_json ?? []);
            $jobSkills = $this->skillListFromParsed($job->parsed_json ?? []);

            $missing = array_values(array_diff($jobSkills, $resumeSkills));
            $strengths = array_values(array_intersect($jobSkills, $resumeSkills));

            $match = ResumeJobMatch::query()->create([
                'resume_profile_id' => $resume->id,
                'job_profile_id' => $job->id,
                'cosine_similarity' => $cosine,
                'rerank_score' => $rerank,
                'match_score' => $score,
                'strengths' => array_slice($strengths, 0, 8),
                'missing_skills' => array_slice($missing, 0, 8),
                'gap_summary' => $this->buildGapExplanation($resume, $job, $strengths, $missing),
            ]);

            return [
                'job_id' => $job->id,
                'job_title' => $job->title ?: 'Untitled job',
                'match_id' => $match->id,
                'cosine_similarity' => round($cosine * 100, 2),
                'rerank_score' => $rerank === null ? null : round($rerank * 100, 2),
                'match_score' => round($score * 100, 2),
                'strengths' => $match->strengths ?? [],
                'missing_skills' => $match->missing_skills ?? [],
                'gap_summary' => $match->gap_summary,
            ];
        })->sortByDesc('match_score')->values();
    }

    /**
     * @param  list<string>  $jobTexts
     * @return array{resume: ResumeProfile, jobs: Collection<int, JobProfile>, results: Collection<int, array<string, mixed>>}
     */
    public function run(?int $userId, string $resumeText, array $jobTexts, ?string $sourceLabel = null): array
    {
        $parsedResume = $this->parseResume($resumeText);

        $parsedJobs = collect($jobTexts)
            ->map(fn (string $text) => ['raw_text' => trim($text), 'parsed' => $this->parseJob($text)])
            ->filter(fn (array $job) => $job['raw_text'] !== '')
            ->values();

        $embeddingInputs = array_merge(
            [$this->embeddingPayloadForResume($resumeText, $parsedResume)],
            $parsedJobs->map(fn (array $job) => $this->embeddingPayloadForJob($job['raw_text'], $job['parsed']))->all(),
        );

        $vectors = Embeddings::for($embeddingInputs)->generate()->embeddings;

        $resume = ResumeProfile::query()->create([
            'user_id' => $userId,
            'source_label' => $sourceLabel,
            'raw_text' => $resumeText,
            'parsed_json' => $parsedResume,
            'embedding' => $vectors[0] ?? [],
        ]);

        $jobs = $parsedJobs->values()->map(function (array $job, int $i) use ($vectors, $userId) {
            $parsed = $job['parsed'];
            $title = (string) ($parsed['role_title'] ?? '');

            return JobProfile::query()->create([
                'user_id' => $userId,
                'title' => $title !== '' ? $title : 'Untitled role',
                'raw_text' => $job['raw_text'],
                'parsed_json' => $parsed,
                'embedding' => $vectors[$i + 1] ?? [],
            ]);
        });

        $results = $this->scoreAndPersistMatches($resume, $jobs);

        return [
            'resume' => $resume,
            'jobs' => $jobs,
            'results' => $results,
        ];
    }

    private function normalizeProfileArray(array $data): array
    {
        foreach (['skills_csv', 'domain_keywords_csv'] as $csvKey) {
            if (isset($data[$csvKey]) && is_string($data[$csvKey])) {
                $data[$csvKey] = $this->normalizeCsv($data[$csvKey]);
            }
        }

        return $data;
    }

    /**
     * @param  array<int, float|int|string>  $vector
     * @return list<float>
     */
    private function asVector(array $vector): array
    {
        return array_values(array_map(fn ($n) => (float) $n, $vector));
    }

    /**
     * @param  list<float>  $a
     * @param  list<float>  $b
     */
    private function cosineSimilarity(array $a, array $b): float
    {
        if (count($a) === 0 || count($a) !== count($b)) {
            return 0.0;
        }

        $dot = 0.0;
        $magA = 0.0;
        $magB = 0.0;

        foreach ($a as $i => $value) {
            $dot += $value * $b[$i];
            $magA += $value * $value;
            $magB += $b[$i] * $b[$i];
        }

        if ($magA == 0.0 || $magB == 0.0) {
            return 0.0;
        }

        return max(0.0, min(1.0, $dot / (sqrt($magA) * sqrt($magB))));
    }

    private function blendScores(float $cosine, ?float $rerank): float
    {
        if ($rerank === null) {
            return $cosine;
        }

        return max(0.0, min(1.0, ($cosine * 0.7) + ($rerank * 0.3)));
    }

    /**
     * @param  array<string, mixed>  $parsed
     * @return list<string>
     */
    private function skillListFromParsed(array $parsed): array
    {
        $skills = (string) ($parsed['skills_csv'] ?? '');

        return array_values(array_unique(array_filter(array_map(
            fn (string $skill) => strtolower(trim($skill)),
            explode(',', $skills)
        ))));
    }

    /**
     * @param  list<string>  $strengths
     * @param  list<string>  $missing
     */
    private function buildGapExplanation(ResumeProfile $resume, JobProfile $job, array $strengths, array $missing): string
    {
        $prompt = "Resume profile:\n".json_encode($resume->parsed_json, JSON_PRETTY_PRINT)."\n\n"
            ."Job profile:\n".json_encode($job->parsed_json, JSON_PRETTY_PRINT)."\n\n"
            .'Matching strengths: '.implode(', ', array_slice($strengths, 0, 6))."\n"
            .'Missing skills: '.implode(', ', array_slice($missing, 0, 6));

        try {
            return (string) (new MatchGapExplainerAgent)->prompt($prompt);
        } catch (\Throwable) {
            $strengthText = count($strengths) > 0 ? implode(', ', array_slice($strengths, 0, 4)) : 'No strong overlap detected yet.';
            $missingText = count($missing) > 0 ? implode(', ', array_slice($missing, 0, 4)) : 'No major hard-skill gaps detected.';

            return "Fit summary\nSkill overlap: {$strengthText}\n\nStrengths\n{$strengthText}\n\nGaps to close\n{$missingText}";
        }
    }

    /**
     * @param  array<string, mixed>  $parsed
     */
    private function embeddingPayloadForResume(string $resumeText, array $parsed): string
    {
        return implode("\n", array_filter([
            'Resume',
            (string) ($parsed['headline'] ?? ''),
            'Skills: '.(string) ($parsed['skills_csv'] ?? ''),
            'Experience years: '.(string) ($parsed['experience_years'] ?? ''),
            'Projects: '.(string) ($parsed['projects_summary'] ?? ''),
            mb_substr($resumeText, 0, 2000),
        ]));
    }

    /**
     * @param  array<string, mixed>  $parsed
     */
    private function embeddingPayloadForJob(string $jobText, array $parsed): string
    {
        return implode("\n", array_filter([
            'Job',
            (string) ($parsed['role_title'] ?? ''),
            'Skills: '.(string) ($parsed['skills_csv'] ?? ''),
            'Minimum experience years: '.(string) ($parsed['min_experience_years'] ?? ''),
            'Responsibilities: '.(string) ($parsed['responsibilities_summary'] ?? ''),
            mb_substr($jobText, 0, 2000),
        ]));
    }

    private function normalizeCsv(string $value): string
    {
        return implode(', ', array_values(array_unique(array_filter(array_map(
            fn (string $token) => trim($token),
            explode(',', $value)
        )))));
    }
}
