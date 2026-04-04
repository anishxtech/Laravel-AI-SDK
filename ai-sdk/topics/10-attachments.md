# Attachments (documents and images)

## Overview

When calling **`prompt()`**, pass an **`attachments:`** array so multimodal models can read **documents** and **images** alongside the text prompt. Use:

- **`Laravel\Ai\Files\Document`** — PDFs, text files, etc.
- **`Laravel\Ai\Files\Image`** — photos, screenshots, diagrams.
- **Uploaded files** from the request.
- **Paths** and **storage disks** via `fromPath`, `fromStorage`, etc.

## Documents

```php
use App\Ai\Agents\SalesCoach;
use Laravel\Ai\Files;

$response = (new SalesCoach)->prompt(
    'Analyze the attached sales transcript...',
    attachments: [
        Files\Document::fromStorage('transcript.pdf'),
        Files\Document::fromPath(storage_path('app/notes.md')),
        $request->file('transcript'),
    ],
);
```

(Use **commas** between array elements — each line is a separate attachment.)

## Images

```php
use Laravel\Ai\Files;

$response = (new ImageAnalyzer)->prompt(
    'What is in this image?',
    attachments: [
        Files\Image::fromStorage('photo.jpg'),
        Files\Image::fromPath(storage_path('app/screenshot.png')),
        $request->file('photo'),
    ],
);
```

## When to use attachments

- User-uploaded **files** too large to paste into chat.
- **Screenshots** or diagrams where vision is required.

## Provider vs stored files

- **Ephemeral** attachments: upload with each prompt.
- **Re-upload avoided** after provider storage: use **`Document::fromId` / `Image::fromId`** after `put()` ([32](32-files-with-providers.md)).

## Pitfalls

- Large files increase **latency and cost** — enforce max size and MIME allow lists.
- The provider must support the **modality** (e.g. vision for images).
- **Sensitive data**: delete temp files after prompt in regulated environments.

## See also

- [32-files-with-providers](32-files-with-providers.md)
