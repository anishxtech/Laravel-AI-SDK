# Custom base URLs

## Overview

By default the SDK calls each provider’s **public** HTTP API. Many teams route traffic through a **proxy** (centralized keys, rate limits, logging) or a **gateway** (LiteLLM, Azure OpenAI–compatible endpoints, corporate egress). You do this by adding a **`url`** key to the provider entry in **`config/ai.php`**, usually backed by `.env`.

## Example

```php
'providers' => [
    'openai' => [
        'driver' => 'openai',
        'key' => env('OPENAI_API_KEY'),
        'url' => env('OPENAI_BASE_URL'),
    ],
    'anthropic' => [
        'driver' => 'anthropic',
        'key' => env('ANTHROPIC_API_KEY'),
        'url' => env('ANTHROPIC_BASE_URL'),
    ],
],
```

**Ollama** and similar self-hosted stacks often set a base URL (e.g. `OLLAMA_BASE_URL`) instead of a public cloud endpoint.

## Supported drivers (per upstream docs)

Custom base URLs are supported for several drivers, including **OpenAI, Anthropic, Gemini, Groq, Cohere, DeepSeek, xAI, and OpenRouter**. The proxy must speak an API **compatible** with the chosen `driver`.

## When to use this

- Corporate **forward proxies** or API management layers.
- **LiteLLM** or unified gateways in front of multiple backends.
- **Azure OpenAI** or vendor-specific URLs (often paired with extra options — see [23-provider-options](23-provider-options.md)).

## Pitfalls

- **Mismatched** base URL + `driver` causes auth or schema errors (404, invalid JSON).
- Proxies may require **extra headers** or path prefixes — confirm against your gateway’s documentation.
- Latency and **timeouts**: tune `#[Timeout]` / `timeout:` on calls that traverse extra hops.

## See also

- [02-configuration-and-env](02-configuration-and-env.md)
- [23-provider-options](23-provider-options.md)
