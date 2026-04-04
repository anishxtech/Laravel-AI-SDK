# Provider tool: WebFetch

## Overview

**`WebFetch`** lets the provider **retrieve and read** specific URLs during generation — ideal when the user or workflow points at **known** pages (documentation, specs, internal public URLs).

**Supported providers (typical):** Anthropic, Gemini — verify in current docs.

```php
use Laravel\Ai\Providers\Tools\WebFetch;

public function tools(): iterable
{
    return [
        new WebFetch,
    ];
}
```

## Configuration

```php
(new WebFetch)->max(3)->allow(['docs.laravel.com']),
```

## WebSearch vs WebFetch

| Tool | Best for |
| --- | --- |
| **WebSearch** | Open-ended “what happened recently?” queries ([17](17-provider-tool-web-search.md)) |
| **WebFetch** | “Read **this** URL” or a small set of trusted URLs |

## Security

If URLs come from **users**, you risk **SSRF**. Validate **host allow lists** server-side before exposing broad fetch capabilities.

## Pitfalls

- **Paywalled** or **auth-only** pages may not fetch as expected.
- **Provider support** varies — test failover paths if you rely on this in production ([24](24-failover.md)).

## See also

- [17-provider-tool-web-search](17-provider-tool-web-search.md)
