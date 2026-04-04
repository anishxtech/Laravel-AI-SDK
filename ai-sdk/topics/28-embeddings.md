# Embeddings

## Overview

**Embeddings** are dense vectors representing text for semantic search, clustering, and reranking pipelines.

## String helper

```php
use Illuminate\Support\Str;

$embeddings = Str::of('Napa Valley has great wine.')->toEmbeddings();
```

## Multiple inputs

```php
use Laravel\Ai\Embeddings;
use Laravel\Ai\Enums\Lab;

$response = Embeddings::for([
    'Napa Valley has great wine.',
    'Laravel is a PHP framework.',
])->generate();

$response->embeddings; // [[...], [...]]
```

## Dimensions and provider

```php
$response = Embeddings::for(['Napa Valley has great wine.'])
    ->dimensions(1536)
    ->generate(Lab::OpenAI, 'text-embedding-3-small');
```

## When to use embeddings

- Build **vector indexes** in PostgreSQL ([29](29-pgvector-and-queries.md)).
- Feed **reranking** or **SimilaritySearch** ([31](31-reranking.md), [16](16-similarity-search.md)).

## Pitfalls

- **Dimension** must match your DB column and migrations — changing models without re-embedding breaks search.
- Providers enforce **batch size** limits — chunk large imports.

## In this repository

**`/ai/embeddings`**

## See also

- [29-pgvector-and-queries](29-pgvector-and-queries.md)
- [30-embedding-caching](30-embedding-caching.md)
- [31-reranking](31-reranking.md)
