<?php

namespace App\Ai\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Laravel\Ai\Prompts\AgentPrompt;

class LogAiPrompt
{
    public function handle(AgentPrompt $prompt, Closure $next): mixed
    {
        Log::channel('single')->info('ai.middleware', [
            'prompt_preview' => mb_substr($prompt->prompt, 0, 200),
        ]);

        return $next($prompt);
    }
}
