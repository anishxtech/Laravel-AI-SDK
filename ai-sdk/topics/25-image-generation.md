# Image generation

## Overview

**`Laravel\Ai\Image`** generates images from a text prompt. Providers typically include **OpenAI, Gemini, xAI** — see [03](03-providers-and-lab-enum.md). Configure defaults in `config/ai.php` (`default_for_images`, etc.).

## Basic

```php
use Laravel\Ai\Image;

$image = Image::of('A donut sitting on the kitchen counter')->generate();

$rawContent = (string) $image;
```

## Shape and quality

```php
$image = Image::of('A donut sitting on the kitchen counter')
    ->quality('high')
    ->landscape()
    ->timeout(120)
    ->generate();
```

Common helpers: **`square()`**, **`portrait()`**, **`landscape()`**, **`quality()`**, **`timeout()`**.

## Reference images (image-to-image / style)

```php
use Laravel\Ai\Files;
use Laravel\Ai\Image;

$image = Image::of('Update this photo of me to be in the style of an impressionist painting.')
    ->attachments([
        Files\Image::fromStorage('photo.jpg'),
        // Files\Image::fromPath(...), fromUrl, $request->file(...)
    ])
    ->landscape()
    ->generate();
```

## Persist to disk

Uses your default filesystem disk from **`config/filesystems.php`**:

```php
$image = Image::of('A donut sitting on the kitchen counter');

$path = $image->store();
$path = $image->storeAs('image.jpg');
$path = $image->storePublicly();
$path = $image->storePubliclyAs('image.jpg');
```

## Queue

```php
use Laravel\Ai\Image;
use Laravel\Ai\Responses\ImageResponse;

Image::of('A donut sitting on the kitchen counter')
    ->portrait()
    ->queue()
    ->then(function (ImageResponse $image) {
        $path = $image->store();
    });
```

## Failover

```php
use Laravel\Ai\Enums\Lab;

Image::of('A donut sitting on the kitchen counter')
    ->generate(provider: [Lab::Gemini, Lab::xAI]);
```

## Pitfalls

- Image APIs are **rate-limited** and billed per image — add quotas for end users.
- Respect provider **content policies**.

## In this repository

**`/ai/images`**

## See also

- [24-failover](24-failover.md)
- [35-testing-fakes](35-testing-fakes.md)
