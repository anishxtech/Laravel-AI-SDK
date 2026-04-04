# Agent configuration (PHP attributes)

## Overview

Configure **defaults** for text generation on the agent class with attributes. Per-call `prompt()` arguments still **override** these defaults.

Common attributes (names follow `laravel/ai`):

| Attribute | Purpose |
| --- | --- |
| **`MaxSteps`** | Max tool-use steps when tools are enabled |
| **`MaxTokens`** | Max tokens the model may generate |
| **`Model`** | Model name string |
| **`Provider`** | `Lab` enum or providers for failover ([24](24-failover.md)) |
| **`Temperature`** | Sampling temperature (0.0–1.0) |
| **`Timeout`** | HTTP timeout in **seconds** (default often 60) |
| **`UseCheapestModel`** | Pick cheapest text model for the provider |
| **`UseSmartestModel`** | Pick most capable text model for the provider |

## Example

```php
use Laravel\Ai\Attributes\MaxSteps;
use Laravel\Ai\Attributes\MaxTokens;
use Laravel\Ai\Attributes\Model;
use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\Attributes\Temperature;
use Laravel\Ai\Attributes\Timeout;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Enums\Lab;
use Laravel\Ai\Promptable;

#[Provider(Lab::Anthropic)]
#[Model('claude-haiku-4-5-20251001')]
#[MaxSteps(10)]
#[MaxTokens(4096)]
#[Temperature(0.7)]
#[Timeout(120)]
class SalesCoach implements Agent
{
    use Promptable;
}
```

## Cost vs quality helpers

```php
use Laravel\Ai\Attributes\UseCheapestModel;
use Laravel\Ai\Attributes\UseSmartestModel;

#[UseCheapestModel]
class SimpleSummarizer implements Agent
{
    use Promptable;
}

#[UseSmartestModel]
class ComplexReasoner implements Agent
{
    use Promptable;
}
```

Exact “cheapest/smartest” resolution depends on the SDK version and provider metadata — **re-test** after upgrades.

## Pitfalls

- Attributes are **defaults** — explicit `prompt(..., model:)` wins.
- **`MaxSteps`** must be high enough for multi-hop **tool** workflows ([15](15-custom-tools.md)).

## See also

- [23-provider-options](23-provider-options.md)
- [24-failover](24-failover.md)
