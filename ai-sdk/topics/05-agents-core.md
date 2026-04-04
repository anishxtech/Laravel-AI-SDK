# Agents (core concepts)

## Overview

**Agents** are the main abstraction for **text** generation with the SDK. An agent is a PHP class that implements `Laravel\Ai\Contracts\Agent` and typically uses the **`Promptable`** trait. It bundles:

- **Instructions** (system prompt): what the assistant is for.
- Optional **conversation** context (`Conversational` or `RemembersConversations`).
- Optional **tools** (`HasTools`): things the model can call.
- Optional **structured output** (`HasStructuredOutput`): JSON shaped by a schema.
- Optional **middleware** (`HasMiddleware`): cross-cutting prompt/response logic.

Think of an agent as a **reusable specialist** (support bot, document analyzer, coach) you configure once and call from controllers, jobs, or Livewire.

## Create an agent

```bash
php artisan make:agent SalesCoach
php artisan make:agent SalesCoach --structured   # stubs structured output
```

## Minimal shape (conceptual)

```php
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Promptable;
use Stringable;

class SalesCoach implements Agent
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return 'You are a sales coach...';
    }
}
```

Implement additional contracts as needed:

| Contract | Purpose |
| --- | --- |
| `Conversational` | Supply `messages()` for history ([07](07-conversational-messages.md)) |
| `HasTools` | Supply `tools()` ([15](15-custom-tools.md)) |
| `HasStructuredOutput` | Supply `schema()` ([09](09-structured-output.md)) |
| `HasMiddleware` | Supply `middleware()` ([20](20-agent-middleware.md)) |
| `HasProviderOptions` | Supply `providerOptions()` ([23](23-provider-options.md)) |

## When to use agents

- Any repeated LLM interaction with shared behavior across HTTP, queue, and CLI.
- When you want **one place** for instructions, tools, and output shape.

## In this repository

See `app/Ai/Agents/` for concrete agents used by `/ai/*` demos.

## Pitfalls

- **Huge** `messages()` lists without caps increase cost and latency — trim or summarize.
- **Too many unrelated tools** on one agent confuse the model; split into focused agents.
- **Secrets** in instructions — avoid embedding API keys or private URLs in static strings.

## See also

- [06-prompting-and-container](06-prompting-and-container.md)
- [15-custom-tools](15-custom-tools.md)
- [22-agent-attributes](22-agent-attributes.md)
