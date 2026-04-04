<?php

namespace App\Ai\Agents;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasStructuredOutput;
use Laravel\Ai\Promptable;
use Stringable;

class StructuredAnalyzer implements Agent, HasStructuredOutput
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return 'You analyze short text. Respond only via the structured schema: concise summary, sentiment label, and a confidence score.';
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'summary' => $schema->string()->required(),
            'sentiment' => $schema->string()->required(),
            'confidence' => $schema->number()->min(0)->max(1)->required(),
        ];
    }
}
