# Anonymous agents

## Overview

For **one-off** prompts without a dedicated class, use the **`agent()`** function import:

```php
use function Laravel\Ai\agent;
```

Pass **`instructions`**, optional **`messages`**, **`tools`**, and optional **`schema`** for structured output.

## Basic

```php
use function Laravel\Ai\agent;

$response = agent(
    instructions: 'You are an expert at software development.',
    messages: [],
    tools: [],
)->prompt('Tell me about Laravel');
```

## Structured output

```php
use Illuminate\Contracts\JsonSchema\JsonSchema;
use function Laravel\Ai\agent;

$response = agent(
    schema: fn (JsonSchema $schema) => [
        'number' => $schema->integer()->required(),
    ],
)->prompt('Generate a random number less than 100');
```

## When to use anonymous agents

- **Spikes**, internal admin tools, rare one-off tasks.
- Quick scripts in **`php artisan tinker`** or throwaway routes.

## When to prefer a class-based agent

- Production paths needing **tests**, **reuse**, **middleware**, or **clear ownership** in code review.
- Complex **tools** and long **instructions** are easier to maintain as `app/Ai/Agents/*` ([05](05-agents-core.md)).

## Pitfalls

- Anonymous agents **hide** behavior from grep-based navigation — document non-obvious usage.
- Harder to **`::fake()`** by class name — consider a thin wrapper class for critical flows ([35](35-testing-fakes.md)).

## See also

- [09-structured-output](09-structured-output.md)
- [05-agents-core](05-agents-core.md)
