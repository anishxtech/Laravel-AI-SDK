<?php

namespace App\Livewire\Ai;

use App\Services\ResumeJobMatchingEngine;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Resume matcher')]
class ResumeMatcherDemo extends Component
{
    public string $sourceLabel = 'Imported candidate';

    public string $resumeText = "John Doe\nSenior PHP Developer\nExperience: 5+ years in Laravel, MySQL, REST APIs, Redis, Docker, CI/CD.\nBuilt SaaS products and payment integrations.\nWorked with queues, testing (Pest/PHPUnit), and AWS.";

    public string $jobDescriptions = "Senior Laravel Engineer\nWe need Laravel, PHP, MySQL, Redis, queues, and Docker. Experience building scalable APIs and background workers.\n---\nBackend Engineer (Node)\nLooking for Node.js, TypeScript, MongoDB, Kafka, and AWS Lambda experience.\n---\nFullstack Product Engineer\nStrong in Laravel or Rails, Vue or React, relational DBs, and experience shipping SaaS features.";

    /** @var list<array<string, mixed>> */
    public array $matches = [];

    public ?string $error = null;

    public bool $busy = false;

    public ?int $resumeProfileId = null;

    public function run(): void
    {
        $this->validate([
            'sourceLabel' => 'nullable|string|max:255',
            'resumeText' => 'required|string|min:50|max:50000',
            'jobDescriptions' => 'required|string|min:50|max:100000',
        ]);

        $this->busy = true;
        $this->error = null;
        $this->matches = [];
        $this->resumeProfileId = null;

        try {
            $jobs = $this->splitJobs($this->jobDescriptions);

            $engine = app(ResumeJobMatchingEngine::class);
            $result = $engine->run(
                userId: Auth::id(),
                resumeText: $this->resumeText,
                jobTexts: $jobs,
                sourceLabel: $this->sourceLabel !== '' ? $this->sourceLabel : null,
            );

            $this->resumeProfileId = $result['resume']->id;
            $this->matches = $result['results']->all();
        } catch (\Throwable $e) {
            $this->error = $e->getMessage();
        }

        $this->busy = false;
    }

    /**
     * @return list<string>
     */
    private function splitJobs(string $raw): array
    {
        return array_values(array_filter(array_map(
            fn (string $item) => trim($item),
            preg_split('/\n-{3,}\n/', trim($raw)) ?: []
        )));
    }

    public function render()
    {
        return view('livewire.ai.resume-matcher-demo')
            ->layout('layouts.app', [
                'title' => __('Resume matcher'),
            ]);
    }
}
