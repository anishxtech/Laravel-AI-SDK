# Vector stores

## Overview

**Vector stores** are **hosted collections** of files that providers index for **semantic retrieval**. Use **`Laravel\Ai\Stores`** to create, fetch, and delete stores, and **`$store->add()`** to ingest documents. Pair with **`FileSearch`** so agents query those stores ([19](19-provider-tool-file-search.md)).

## Create

```php
use Laravel\Ai\Stores;

$store = Stores::create('Knowledge Base');

$store = Stores::create(
    name: 'Knowledge Base',
    description: 'Documentation and reference materials.',
    expiresWhenIdleFor: days(30),
);

return $store->id;
```

## Retrieve

```php
use Laravel\Ai\Stores;

$store = Stores::get('store_id');

$store->id;
$store->name;
$store->fileCounts;
$store->ready;
```

## Delete

```php
Stores::delete('store_id');

$store = Stores::get('store_id');
$store->delete();
```

## Add files

```php
use Laravel\Ai\Files\Document;
use Laravel\Ai\Stores;

$store = Stores::get('store_id');

$document = $store->add('file_id');
$document = $store->add(Document::fromId('file_id'));

$document = $store->add(Document::fromPath('/path/to/document.pdf'));
$document = $store->add(Document::fromStorage('manual.pdf'));
$document = $store->add($request->file('document'));

$document->id;
$document->fileId;
```

**Important:** some providers may return a **new document ID** distinct from the original file ID — **persist both** when your app needs stable references (per upstream guidance).

## Metadata (for FileSearch filters)

```php
$store->add(Document::fromPath('/path/to/document.pdf'), metadata: [
    'author' => 'Taylor Otwell',
    'department' => 'Engineering',
    'year' => 2026,
]);
```

## Remove

```php
$store->remove('file_id');
```

Removing from a store **does not** delete the file from provider storage unless you opt in:

```php
$store->remove('file_abc123', deleteFile: true);
```

## When to use vector stores

- **Hosted RAG** without maintaining pgvector yourself.
- Large docs you want searchable via **`FileSearch`**.

## Pitfalls

- Indexing can be **async** — handle “not ready” in UI.
- **Store IDs** are secrets — treat like API keys in config.

## In this repository

**`/ai/stores`**

## See also

- [19-provider-tool-file-search](19-provider-tool-file-search.md)
- [32-files-with-providers](32-files-with-providers.md)
