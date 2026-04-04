<?php

namespace App\Ai\Agents;

use App\Ai\Middleware\LogAiPrompt;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasMiddleware;
use Laravel\Ai\Promptable;
use Stringable;

class MiddlewareShowcaseAgent implements Agent, HasMiddleware
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return 'You help developers learn Laravel. Be concise.';
    }

    public function middleware(): array
    {
        return [
            new LogAiPrompt,
        ];
    }
}
