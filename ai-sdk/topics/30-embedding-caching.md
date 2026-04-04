# Embedding caching

## Overview

Identical embedding requests can be **cached** to avoid redundant API calls. Two layers:

1. **Global** config in `config/ai.php` under **`ai.caching.embeddings`**.
2. **Per-request** chaining `->cache()` on `Embeddings::for(...)`.

## Global configuration (conceptual)

```php
'caching' => [
    'embeddings' => [
        'cache' => true,
        'store' => env('CACHE_STORE', 'database'),
        // ...
    ],
],
```

When enabled, identical inputs typically cache for on the order of **30 days** (per upstream docs) — the cache key includes **provider**, **model**, **dimensions**, and **input content**.

## Per-request caching

Even if global caching is off:

```php
$response = Embeddings::for(['Napa Valley has great wine.'])
    ->cache()
    ->generate();
```

Custom TTL:

```php
$response = Embeddings::for(['Napa Valley has great wine.'])
    ->cache(seconds: 3600)
    ->generate();
```

## String helper

```php
use Illuminate\Support\Str;

Str::of('Napa Valley has great wine.')->toEmbeddings(cache: true);
Str::of('Napa Valley has great wine.')->toEmbeddings(cache: 3600);
```

## When to use caching

- **Static** or slowly changing text embedded repeatedly (navigation labels, legal boilerplate).
- High-traffic paths that re-embed the **same** user queries.

## Pitfalls

- **Debugging** embedding bugs — disable caching or you may see stale vectors.
- Changing **model** or **dimensions** should logically invalidate behavior — old entries expire by TTL but mismatches can confuse operators during migrations.

## See also

- [28-embeddings](28-embeddings.md)
