# Files with providers

## Overview

Upload files to the **provider’s file storage** so models can reference them by **ID** without re-uploading each request. Use **`Laravel\Ai\Files\Document`** and **`Laravel\Ai\Files\Image`** (or the umbrella `Files` helpers).

## Upload

```php
use Laravel\Ai\Files\Document;
use Laravel\Ai\Files\Image;

$response = Document::fromPath('/home/laravel/document.pdf')->put();
$response = Image::fromPath('/home/laravel/photo.jpg')->put();

$response = Document::fromStorage('document.pdf', disk: 'local')->put();
$response = Image::fromStorage('photo.jpg', disk: 'local')->put();

$response = Document::fromUrl('https://example.com/document.pdf')->put();
$response = Image::fromUrl('https://example.com/photo.jpg')->put();

return $response->id;
```

## Raw content and uploads

```php
use Laravel\Ai\Files\Document;

$stored = Document::fromString('Hello, World!', 'text/plain')->put();
$stored = Document::fromUpload($request->file('document'))->put();
```

## Use stored IDs in prompts

```php
use App\Ai\Agents\LaravelAssistant;
use Laravel\Ai\Files;

$response = (new LaravelAssistant)->prompt(
    'Analyze the attached sales transcript...',
    attachments: [
        Files\Document::fromId('file-id'),
    ]
);
```

Note: separate arguments with **commas** in real PHP — the official docs illustrate multiple attachment styles.

## Retrieve and delete

```php
$file = Document::fromId('file-id')->get();

$file->id;
$file->mimeType();

Document::fromId('file-id')->delete();
```

## Provider selection

Default comes from **`config/ai.php`**. Override per call:

```php
use Laravel\Ai\Enums\Lab;

$response = Document::fromPath('/home/laravel/document.pdf')
    ->put(provider: Lab::Anthropic);
```

## When to use provider files

- Large PDFs used in **many** prompts.
- Preparing corpora for **vector stores** ([33](33-vector-stores.md)).

## Pitfalls

- Provider-side files may **expire** — track lifecycle in your database.
- **Multi-tenant** apps: never leak another tenant’s `file-id`.

## In this repository

**`/ai/files`**

## See also

- [10-attachments](10-attachments.md)
- [33-vector-stores](33-vector-stores.md)
