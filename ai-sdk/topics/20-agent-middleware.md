# Agent middleware

## Overview

Middleware **wraps** prompting: you can log, redact PII, enforce policies, or enrich prompts before they hit the provider, and inspect responses after. Agents implement **`HasMiddleware`** and return middleware instances from **`middleware(): array`**.

## Scaffold

```bash
php artisan make:agent-middleware LogPrompts
```

Files live under `app/Ai/Middleware/` (default stub path).

## Register on an agent

```php
use App\Ai\Middleware\LogPrompts;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasMiddleware;
use Laravel\Ai\Promptable;

class SalesCoach implements Agent, HasMiddleware
{
    use Promptable;

    public function middleware(): array
    {
        return [
            new LogPrompts,
        ];
    }
}
```

## Middleware handler

```php
use Closure;
use Illuminate\Support\Facades\Log;
use Laravel\Ai\Prompts\AgentPrompt;

class LogPrompts
{
    public function handle(AgentPrompt $prompt, Closure $next)
    {
        Log::info('Prompting agent', ['prompt' => $prompt->prompt]);

        return $next($prompt);
    }
}
```

## Post-processing responses

You may use **`then()`** on the **response** returned by `$next($prompt)` so logic runs after the agent finishes — works for **sync** and **streaming** responses (see upstream docs for `AgentResponse` typing in your version).

```php
use Illuminate\Support\Facades\Log;
use Laravel\Ai\Responses\AgentResponse;

public function handle(AgentPrompt $prompt, Closure $next)
{
    return $next($prompt)->then(function (AgentResponse $response) {
        Log::info('Agent responded', ['text' => $response->text]);
    });
}
```

## When to use middleware

- **Audit logs**, rate accounting, tracing.
- **Redaction** of secrets before sending to the model.
- **Guardrails** shared across many agents.

## Pitfalls

- Heavy work in middleware adds **latency** to every call — keep it lean.
- **Order matters**: first in the `middleware()` array runs first.

## See also

- [05-agents-core](05-agents-core.md)
- [34-events-observability](34-events-observability.md)
