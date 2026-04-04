# Providers and the `Lab` enum

## Overview

`Laravel\Ai\Enums\Lab` is the **typed** way to refer to AI labs (OpenAI, Anthropic, Gemini, …) instead of scattering magic strings. Use it for `provider:` arguments, **failover** arrays, and **`providerOptions()`** switches ([23-provider-options](23-provider-options.md)).

```php
use Laravel\Ai\Enums\Lab;

Lab::Anthropic;
Lab::OpenAI;
Lab::Gemini;
// ...
```

## Provider support by feature (official summary)

Not every provider implements every capability. Typical matrix:

| Feature | Providers |
| --- | --- |
| **Text** | OpenAI, Anthropic, Gemini, Azure, Groq, xAI, DeepSeek, Mistral, Ollama |
| **Images** | OpenAI, Gemini, xAI |
| **TTS** | OpenAI, ElevenLabs |
| **STT** | OpenAI, ElevenLabs, Mistral |
| **Embeddings** | OpenAI, Gemini, Azure, Cohere, Mistral, Jina, VoyageAI |
| **Reranking** | Cohere, Jina |
| **Files** | OpenAI, Anthropic, Gemini |

Always confirm the **exact** model + capability pair in the upstream Laravel AI docs for your installed package version.

## When to use `Lab`

- Passing **`provider:`** to `prompt()`, `stream()`, `generate()`, etc.
- Building **failover** chains ([24-failover](24-failover.md)).
- **`match ($provider)`** in `HasProviderOptions` ([23-provider-options](23-provider-options.md)).

## Example

```php
use Laravel\Ai\Enums\Lab;

$response = $agent->prompt(
    'Hello',
    provider: Lab::Anthropic,
    model: 'claude-haiku-4-5-20251001',
);
```

## Pitfalls

- Choosing a provider that **does not support** the operation (e.g. image generation on a text-only driver) fails at runtime.
- In **failover** arrays, **order matters**: first is primary, remainder are fallbacks ([24-failover](24-failover.md)).

## See also

- [24-failover](24-failover.md)
- [22-agent-attributes](22-agent-attributes.md)
