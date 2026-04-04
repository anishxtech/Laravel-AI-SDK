# Provider tool: FileSearch

## Overview

**`FileSearch`** searches **vector stores** hosted by the provider (e.g. OpenAI-style file search) using **store IDs** you created with **`Stores::create`** and populated via **`$store->add()`**. Execution happens on the **provider** side — your app does not run the similarity math for that retrieval step.

**Supported providers (typical):** OpenAI, Gemini — confirm in docs.

```php
use Laravel\Ai\Providers\Tools\FileSearch;

public function tools(): iterable
{
    return [
        new FileSearch(stores: ['store_id']),
    ];
}
```

## Multiple stores

```php
new FileSearch(stores: ['store_1', 'store_2']);
```

## Metadata filters

**Simple equality** `where` array:

```php
new FileSearch(stores: ['store_id'], where: [
    'author' => 'Taylor Otwell',
    'year' => 2026,
]);
```

**Complex** filters with **`FileSearchQuery`**:

```php
use Laravel\Ai\Providers\Tools\FileSearchQuery;

new FileSearch(stores: ['store_id'], where: fn (FileSearchQuery $query) =>
    $query->where('author', 'Taylor Otwell')
        ->whereNot('status', 'draft')
        ->whereIn('category', ['news', 'updates'])
);
```

## When to use FileSearch

- Hosted **RAG** where embeddings and indexing live **with the provider**.
- You already **upload** documents via `Files` / `Stores` ([32](32-files-with-providers.md), [33](33-vector-stores.md)).

## Pitfalls

- **Store IDs** are sensitive configuration — keep in **env**/secrets.
- Indexing can be **async** — handle “not ready” states in UX.
- For **first-party** pgvector search, use **`SimilaritySearch`** instead ([16](16-similarity-search.md)).

## See also

- [33-vector-stores](33-vector-stores.md)
- [32-files-with-providers](32-files-with-providers.md)
