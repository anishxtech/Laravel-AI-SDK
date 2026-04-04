# Provider-specific options

## Overview

Some knobs are **vendor-specific** (OpenAI reasoning effort, Anthropic “thinking” budgets, penalty parameters). Implement **`Laravel\Ai\Contracts\HasProviderOptions`** and define **`providerOptions(Lab|string $provider): array`**.

The method receives the provider **currently in use** — important during **failover** when each attempt may use a different lab ([24](24-failover.md)).

## Example

```php
use Laravel\Ai\Contracts\HasProviderOptions;
use Laravel\Ai\Enums\Lab;

class SalesCoach implements Agent, HasProviderOptions
{
    use Promptable;

    public function providerOptions(Lab|string $provider): array
    {
        return match ($provider) {
            Lab::OpenAI => [
                'reasoning' => ['effort' => 'low'],
                'frequency_penalty' => 0.5,
                'presence_penalty' => 0.3,
            ],
            Lab::Anthropic => [
                'thinking' => ['budget_tokens' => 1024],
            ],
            default => [],
        };
    }
}
```

## When to use this

- Fine-grained API flags **not** covered by attributes.
- Different options per provider in a **failover** chain.

## Pitfalls

- **Unsupported keys** may be ignored or cause API errors — match each vendor’s current HTTP API.
- Keep options **minimal** and documented — they are easy to break on provider upgrades.

## See also

- [24-failover](24-failover.md)
- [04-custom-base-urls](04-custom-base-urls.md)
