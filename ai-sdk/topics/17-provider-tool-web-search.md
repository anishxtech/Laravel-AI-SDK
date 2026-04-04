# Provider tool: WebSearch

## Overview

**Provider tools** are executed **by the AI provider** (not your PHP `handle` method). **`WebSearch`** lets the model obtain **fresh web search results** — useful for news, prices, sports, or anything after the training cutoff.

**Supported providers (typical):** Anthropic, OpenAI, Gemini — confirm for your model and package version.

```php
use Laravel\Ai\Providers\Tools\WebSearch;

public function tools(): iterable
{
    return [
        new WebSearch,
    ];
}
```

## Configuration

**Limit** how many searches and **restrict** domains:

```php
(new WebSearch)->max(5)->allow(['laravel.com', 'php.net']),
```

**Geographic bias** for localized results:

```php
(new WebSearch)->location(
    city: 'New York',
    region: 'NY',
    country: 'US'
);
```

## When to use WebSearch

- Questions that need **current** facts from the public web.
- When you **do not** have a crawl of those pages in your own DB.

## Pitfalls

- Adds **latency and cost** compared to plain completion.
- Not every **model + provider** exposes web search — test your configuration.
- **Policy**: restrict domains when the task should stay on trusted sites.

## See also

- [18-provider-tool-web-fetch](18-provider-tool-web-fetch.md)
