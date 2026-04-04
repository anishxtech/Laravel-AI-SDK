# PostgreSQL pgvector and vector queries

## Overview

After you generate embeddings ([28](28-embeddings.md)), you usually **persist** them in a **vector** column. Laravel supports **`vector(dimensions)`** columns on **PostgreSQL** with the **pgvector** extension.

> **Vector similarity queries are only supported on PostgreSQL with pgvector** — not on SQLite/MySQL for these helpers.

## Migration

```php
Schema::ensureVectorExtensionExists();

Schema::create('documents', function (Blueprint $table) {
    $table->id();
    $table->string('title');
    $table->text('content');
    $table->vector('embedding', dimensions: 1536);
    $table->timestamps();
});
```

## Index (HNSW)

Calling **`->index()`** on the vector column typically creates an **HNSW** index with **cosine** distance (see Laravel database docs for your version).

```php
$table->vector('embedding', dimensions: 1536)->index();
```

## Model cast

```php
protected function casts(): array
{
    return [
        'embedding' => 'array',
    ];
}
```

## Similarity query

**`whereVectorSimilarTo`** filters by minimum **cosine similarity** (0.0–1.0, where 1.0 is identical) and orders by similarity:

```php
use App\Models\Document;

$documents = Document::query()
    ->whereVectorSimilarTo('embedding', $queryEmbedding, minSimilarity: 0.4)
    ->limit(10)
    ->get();
```

**`$queryEmbedding`** may be a float **array** or a **string** — when a string is passed, Laravel can **embed** it automatically.

## Advanced methods

```php
$documents = Document::query()
    ->select('*')
    ->selectVectorDistance('embedding', $queryEmbedding, as: 'distance')
    ->whereVectorDistanceLessThan('embedding', $queryEmbedding, maxDistance: 0.3)
    ->orderByVectorDistance('embedding', $queryEmbedding)
    ->limit(10)
    ->get();
```

## Agent integration

Expose retrieval to agents with **`SimilaritySearch`** ([16](16-similarity-search.md)).

## Local development

If your app uses **SQLite** by default, vector helpers are unavailable — use **Postgres** for feature work or switch to **hosted** vector stores ([33](33-vector-stores.md)).

## Pitfalls

- **Index** and **distance operator** choices affect recall vs speed — tune for your dataset.
- **Dimension** mismatch between stored rows and the active embedding model is a common production bug.

## See also

- [16-similarity-search](16-similarity-search.md)
- [28-embeddings](28-embeddings.md)
