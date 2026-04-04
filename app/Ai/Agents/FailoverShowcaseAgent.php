<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasProviderOptions;
use Laravel\Ai\Enums\Lab;
use Laravel\Ai\Promptable;
use Stringable;

class FailoverShowcaseAgent implements Agent, HasProviderOptions
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return 'You answer in one or two sentences.';
    }

    /**
     * Per-provider API options when using failover (see ai-sdk topic 23). Return [] until you need
     * vendor-specific keys (e.g. OpenAI penalties, Anthropic thinking budgets).
     *
     * @return array<string, mixed>
     */
    public function providerOptions(Lab|string $provider): array
    {
        return match ($provider) {
            Lab::Gemini => [],
            Lab::OpenAI => [],
            default => [],
        };
    }
}
