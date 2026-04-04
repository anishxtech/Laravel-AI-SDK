# Reranking

## Overview

**Reranking** reorders a list of candidate text snippets by relevance to a **query** using a reranking-capable provider (**Cohere, Jina** per typical docs). Use after coarse retrieval (vector or keyword) to improve **precision**.

## Facade API

```php
use Laravel\Ai\Reranking;

$response = Reranking::of([
    'Django is a Python web framework.',
    'Laravel is a PHP web application framework.',
    'React is a JavaScript library for building user interfaces.',
])->rerank('PHP frameworks');

$response->first()->document;
$response->first()->score;
$response->first()->index; // original position
```

## Limit

```php
$response = Reranking::of($documents)
    ->limit(5)
    ->rerank('search query');
```

## Collections macro

```php
// Single field
$posts = Post::all()->rerank('body', 'Laravel tutorials');

// Multiple fields (JSON)
$reranked = $posts->rerank(['title', 'body'], 'Laravel tutorials');

// Closure builds document text
$reranked = $posts->rerank(
    fn ($post) => $post->title.': '.$post->body,
    'Laravel tutorials'
);
```

Named arguments (per docs):

```php
use Laravel\Ai\Enums\Lab;

$reranked = $posts->rerank(
    by: 'content',
    query: 'Laravel tutorials',
    limit: 10,
    provider: Lab::Cohere
);
```

## Pitfalls

- Adds **latency** — rerank tens of candidates, not thousands without prefiltering.
- Configure **`default_for_reranking`** (or explicit provider) in `config/ai.php`.

## In this repository

**`/ai/embeddings`** (alongside embedding demos)

## See also

- [28-embeddings](28-embeddings.md)
- [35-testing-fakes](35-testing-fakes.md)
