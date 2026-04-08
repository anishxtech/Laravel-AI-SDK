<?php

namespace App\Ai\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Promptable;
use Stringable;

class ResumeParserAgent implements Agent, HasStructuredOutput
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return 'Extract resume data into the schema. Keep fields concise. skills_csv must be a comma-separated list of hard skills only. If data is missing, return an empty string or 0.';
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'candidate_name' => $schema->string()->required(),
            'headline' => $schema->string()->required(),
            'experience_years' => $schema->integer()->min(0)->required(),
            'skills_csv' => $schema->string()->required(),
            'education_summary' => $schema->string()->required(),
            'projects_summary' => $schema->string()->required(),
        ];
    }
}
