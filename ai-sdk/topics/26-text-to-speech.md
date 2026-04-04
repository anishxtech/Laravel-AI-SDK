# Text to speech (audio generation)

## Overview

**`Laravel\Ai\Audio`** synthesizes speech from text. Typical providers: **OpenAI, ElevenLabs** (per driver configuration in `config/ai.php`).

## Basic

```php
use Laravel\Ai\Audio;

$audio = Audio::of('I love coding with Laravel.')->generate();

$rawContent = (string) $audio;
```

## Voice selection

```php
$audio = Audio::of('I love coding with Laravel.')
    ->female()
    ->generate();

$audio = Audio::of('I love coding with Laravel.')
    ->voice('voice-id-or-name')
    ->generate();
```

## Style instructions

```php
$audio = Audio::of('I love coding with Laravel.')
    ->female()
    ->instructions('Said like a pirate')
    ->generate();
```

## Persist to disk

```php
$audio = Audio::of('I love coding with Laravel.')->generate();

$path = $audio->store();
$path = $audio->storeAs('audio.mp3');
$path = $audio->storePublicly();
$path = $audio->storePubliclyAs('audio.mp3');
```

## Queue

```php
use Laravel\Ai\Audio;
use Laravel\Ai\Responses\AudioResponse;

Audio::of('I love coding with Laravel.')
    ->queue()
    ->then(function (AudioResponse $audio) {
        $path = $audio->store();
    });
```

## Pitfalls

- **Voice IDs** differ by provider — store them in config, not hard-coded in many places.
- Very long inputs may need **chunking** per provider limits.

## In this repository

**`/ai/speech`**

## See also

- [35-testing-fakes](35-testing-fakes.md)
