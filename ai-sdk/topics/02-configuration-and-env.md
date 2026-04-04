# Configuration and environment

## Overview

Provider credentials and **defaults** (which model to use for text, images, audio, transcription, embeddings, reranking, etc.) live in **`config/ai.php`**, with secrets in **`.env`**. The SDK reads these when you omit explicit `provider:` / `model:` arguments on agents and facades (`Image`, `Audio`, `Embeddings`, …).

## Typical `.env` keys (official documentation)

You may define keys such as:

```env
ANTHROPIC_API_KEY=
COHERE_API_KEY=
ELEVENLABS_API_KEY=
GEMINI_API_KEY=
MISTRAL_API_KEY=
OLLAMA_API_KEY=
OPENAI_API_KEY=
JINA_API_KEY=
VOYAGEAI_API_KEY=
XAI_API_KEY=
```

Your app may define **additional** drivers (Azure, Groq, DeepSeek, OpenRouter, etc.) — see the `providers` array in **`config/ai.php`** for the exact `env()` names this project uses.

## What you configure

- **Default provider** for each capability (text vs image vs embeddings, …).
- **Per-provider** `key`, and optionally **`url`** for proxies ([04-custom-base-urls](04-custom-base-urls.md)).
- **Embedding cache** under `config('ai.caching.embeddings')` — see [30-embedding-caching](30-embedding-caching.md).

## Example: defaults

```php
// config/ai.php (illustrative)
'default' => 'gemini',
'default_for_images' => 'gemini',
'default_for_audio' => 'openai',
'default_for_embeddings' => 'openai',
'default_for_reranking' => 'cohere',
```

## In this repository

Open `config/ai.php` and `.env` side by side; demos under `/ai/*` assume at least one configured text provider.

## Pitfalls

- A **wrong default** for a feature (e.g. reranking without Cohere/Jina configured) surfaces as confusing API errors.
- Never commit real API keys; use `.env` and secret managers in production.
- Changing default models affects **cost and behavior** — treat defaults as part of your release process.

## See also

- [03-providers-and-lab-enum](03-providers-and-lab-enum.md)
- [04-custom-base-urls](04-custom-base-urls.md)
- [30-embedding-caching](30-embedding-caching.md)
