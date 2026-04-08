<?php

namespace App\Ai\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Promptable;
use Stringable;

class JobDescriptionParserAgent implements Agent, HasStructuredOutput
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return 'Extract hiring requirements from the job description. skills_csv must be a comma-separated list of hard skills only. Keep all fields concise. If missing, return empty string or 0.';
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'role_title' => $schema->string()->required(),
            'seniority_level' => $schema->string()->required(),
            'min_experience_years' => $schema->integer()->min(0)->required(),
            'skills_csv' => $schema->string()->required(),
            'responsibilities_summary' => $schema->string()->required(),
            'domain_keywords_csv' => $schema->string()->required(),
        ];
    }
}
