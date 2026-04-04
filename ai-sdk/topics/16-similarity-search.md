# Similarity search (RAG tool)

## Overview

**`Laravel\Ai\Tools\SimilaritySearch`** lets an agent retrieve **your** documents by **vector similarity** — the foundation of **RAG** (retrieval-augmented generation) over data you control.

## Simplest API: `usingModel`

```php
use App\Models\Document;
use Laravel\Ai\Tools\SimilaritySearch;

public function tools(): iterable
{
    return [
        SimilaritySearch::usingModel(Document::class, 'embedding'),
    ];
}
```

- First argument: **Eloquent model** class.
- Second argument: **column** storing the embedding vector.

## Tuning and scoping

```php
SimilaritySearch::usingModel(
    model: Document::class,
    column: 'embedding',
    minSimilarity: 0.7,
    limit: 10,
    query: fn ($query) => $query->where('published', true),
),
```

## Custom closure

Full control over retrieval:

```php
use App\Models\Document;
use Laravel\Ai\Tools\SimilaritySearch;

public function tools(): iterable
{
    return [
        new SimilaritySearch(using: function (string $query) {
            return Document::query()
                ->where('user_id', $this->user->id)
                ->whereVectorSimilarTo('embedding', $query)
                ->limit(10)
                ->get();
        }),
    ];
}
```

## Description

```php
SimilaritySearch::usingModel(Document::class, 'embedding')
    ->withDescription('Search the knowledge base for relevant articles.'),
```

## Database requirement

**PostgreSQL + pgvector** for Laravel’s **`whereVectorSimilarTo`** helpers. These vector query helpers are **not** available on SQLite in this form. See [29](29-pgvector-and-queries.md).

If you cannot run Postgres locally, consider **provider vector stores** instead ([33](33-vector-stores.md), [19](19-provider-tool-file-search.md)).

## Pitfalls

- **Dimension mismatch** between stored vectors and the embedding model breaks search.
- **SQLite** dev DBs cannot use this path — use Postgres for vector work or switch RAG strategy.

## See also

- [28-embeddings](28-embeddings.md)
- [29-pgvector-and-queries](29-pgvector-and-queries.md)
- [33-vector-stores](33-vector-stores.md)
