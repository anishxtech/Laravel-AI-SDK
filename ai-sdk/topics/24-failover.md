# Failover (providers and models)

## Overview

Pass an **array** of providers (and optionally models, depending on API) so if the **primary** fails (rate limit, outage, invalid response), the SDK tries the **next** entry automatically.

## Agents (text)

```php
use Laravel\Ai\Enums\Lab;

$response = (new SalesCoach)->prompt(
    'Analyze this sales transcript...',
    provider: [Lab::OpenAI, Lab::Anthropic],
);
```

## Other facades (example: images)

```php
use Laravel\Ai\Image;

$image = Image::of('A donut sitting on the kitchen counter')
    ->generate(provider: [Lab::Gemini, Lab::xAI]);
```

Failover applies broadly across generation APIs — always verify the specific facade/method in the version you run.

## Combining with `HasProviderOptions`

**`providerOptions()`** receives whichever provider is **active** for that attempt, so each lab can get compatible flags ([23](23-provider-options.md)).

## When to use failover

- **Production** resilience without hand-written retry loops.
- **Rate limits** during traffic spikes.

## Pitfalls

- **Silent degradation** — log primary failures or you will miss systemic issues.
- **Tooling and attachments** may behave differently per provider — test each path.
- **Cost** may differ sharply between fallbacks — monitor spend.

## See also

- [03-providers-and-lab-enum](03-providers-and-lab-enum.md)
- [23-provider-options](23-provider-options.md)
