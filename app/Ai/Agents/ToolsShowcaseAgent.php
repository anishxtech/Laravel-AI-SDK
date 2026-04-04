<?php

namespace App\Ai\Agents;

use App\Ai\Tools\LaravelVersion;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Providers\Tools\ProviderTool;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Promptable;
use Laravel\Ai\Providers\Tools\WebFetch;
use Laravel\Ai\Providers\Tools\WebSearch;
use Stringable;

class ToolsShowcaseAgent implements Agent, HasTools
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return <<<'PROMPT'
You are a helpful assistant. When the user asks for the Laravel version running in this app, call the Laravel version tool.
For current events or documentation, you may use web search or fetch tools if available.
Keep answers concise.
PROMPT;
    }

    /**
     * @return iterable<Tool|ProviderTool>
     */
    public function tools(): iterable
    {
        $tools = [
            app(LaravelVersion::class),
            (new WebSearch)->max(3)->allow(['laravel.com', 'php.net', 'github.com']),
            (new WebFetch)->max(2)->allow(['laravel.com', 'docs.laravel.com']),
        ];

        return $tools;
    }
}
