# Transcription (speech to text)

## Overview

**`Laravel\Ai\Transcription`** converts audio files into text. Sources: **path**, **storage disk**, or **uploaded file**.

```php
use Laravel\Ai\Transcription;

$transcript = Transcription::fromPath('/home/laravel/audio.mp3')->generate();
$transcript = Transcription::fromStorage('audio.mp3')->generate();
$transcript = Transcription::fromUpload($request->file('audio'))->generate();

return (string) $transcript;
```

## Diarization

```php
$transcript = Transcription::fromStorage('audio.mp3')
    ->diarize()
    ->generate();
```

Use when you need **speaker segments** in addition to plain text (provider-dependent).

## Queue

```php
use Laravel\Ai\Transcription;
use Laravel\Ai\Responses\TranscriptionResponse;

Transcription::fromStorage('audio.mp3')
    ->queue()
    ->then(function (TranscriptionResponse $transcript) {
        // ...
    });
```

## Pitfalls

- Watch PHP **`upload_max_filesize`** / **`post_max_size`** for user uploads.
- **Disk space** for temp files on busy workers.
- Set **language** explicitly when the provider supports it for better accuracy.

## In this repository

**`/ai/transcribe`**

## See also

- [35-testing-fakes](35-testing-fakes.md)
