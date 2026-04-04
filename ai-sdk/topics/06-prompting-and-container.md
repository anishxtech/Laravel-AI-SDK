# Prompting and the service container

## Overview

You **prompt** an agent with `prompt()`: the SDK sends the user text plus instructions, history, tools, and attachments to the model and returns a response (string-like, structured array access, or streamed events — see [11](11-streaming-sse.md)).

## Basic usage

```php
$response = (new SalesCoach)->prompt('Analyze this sales transcript...');

return (string) $response;
```

## Container resolution with `::make()`

`SalesCoach::make(...)` resolves the agent from Laravel’s container so **constructor dependencies** are injected (e.g. `User`, repositories).

```php
$agent = SalesCoach::make(user: $user);
$response = $agent->prompt('Hello');
```

Use this in controllers and Livewire components when the agent is not a trivial `new`.

## Per-call overrides

Pass extra arguments to **`prompt()`** to override defaults:

```php
use Laravel\Ai\Enums\Lab;

$response = (new SalesCoach)->prompt(
    'Analyze this sales transcript...',
    provider: Lab::Anthropic,
    model: 'claude-haiku-4-5-20251001',
    timeout: 120,
);
```

Defaults can also come from PHP **attributes** on the agent class ([22](22-agent-attributes.md)).

## When to use `prompt()` vs alternatives

| Goal | Method |
| --- | --- |
| Full response in one go | `prompt()` |
| Token-by-token to the browser | `stream()` ([11](11-streaming-sse.md)) |
| Return quickly, finish in a worker | `queue()` ([14](14-queueing-agents.md)) |

## Pitfalls

- Long prompts + **many tool steps** can hit `max_tokens` or step limits — tune `#[MaxSteps]`, `#[MaxTokens]` ([22](22-agent-attributes.md)).
- **Session-only** state: `queue()` callbacks run in the worker — do not rely on web session there ([14](14-queueing-agents.md)).

## See also

- [05-agents-core](05-agents-core.md)
- [14-queueing-agents](14-queueing-agents.md)
- [22-agent-attributes](22-agent-attributes.md)
