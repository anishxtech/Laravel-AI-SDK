# Testing with fakes

## Overview

In tests, **replace real network calls** with deterministic fakes. The SDK provides fake APIs for **agents**, **Image**, **Audio**, **Transcription**, **Embeddings**, **Reranking**, **Files**, and **Stores**, plus **assertions** on what would have been sent.

Use **`preventStray*`** helpers to fail tests if an unexpected real call path remains.

---

## Agents

Replace the class name with **your** agent (examples in this repo include `App\Ai\Agents\ToolsShowcaseAgent`, `StructuredAnalyzer`, etc.).

```php
use App\Ai\Agents\ToolsShowcaseAgent;
use Laravel\Ai\Prompts\AgentPrompt;

ToolsShowcaseAgent::fake();
ToolsShowcaseAgent::fake(['First response', 'Second response']);
ToolsShowcaseAgent::fake(function (AgentPrompt $prompt) {
    return 'Response for: '.$prompt->prompt;
});
```

**Structured output:** `fake()` can auto-generate data matching the agent schema.

**Assertions:**

```php
ToolsShowcaseAgent::assertPrompted('Analyze this...');
ToolsShowcaseAgent::assertPrompted(fn (AgentPrompt $prompt) => $prompt->contains('Analyze'));
ToolsShowcaseAgent::assertNotPrompted('Missing prompt');
ToolsShowcaseAgent::assertNeverPrompted();
```

**Queued:**

```php
use Laravel\Ai\QueuedAgentPrompt;

ToolsShowcaseAgent::assertQueued('Analyze this...');
ToolsShowcaseAgent::assertQueued(fn (QueuedAgentPrompt $prompt) => $prompt->contains('Analyze'));
ToolsShowcaseAgent::assertNotQueued('Missing prompt');
ToolsShowcaseAgent::assertNeverQueued();
```

**Guard:**

```php
ToolsShowcaseAgent::fake()->preventStrayPrompts();
```

---

## Image

```php
use Laravel\Ai\Image;
use Laravel\Ai\Prompts\ImagePrompt;
use Laravel\Ai\Prompts\QueuedImagePrompt;

Image::fake();
Image::fake([base64_encode($firstImage), base64_encode($secondImage)]);
Image::fake(fn (ImagePrompt $prompt) => base64_encode('...'));

Image::assertGenerated(fn (ImagePrompt $prompt) => $prompt->contains('sunset') && $prompt->isLandscape());
Image::assertNotGenerated('Missing prompt');
Image::assertNothingGenerated();

Image::assertQueued(fn (QueuedImagePrompt $prompt) => $prompt->contains('sunset'));
Image::assertNothingQueued();

Image::fake()->preventStrayImages();
```

---

## Audio

```php
use Laravel\Ai\Audio;
use Laravel\Ai\Prompts\AudioPrompt;
use Laravel\Ai\Prompts\QueuedAudioPrompt;

Audio::fake();
Audio::assertGenerated(fn (AudioPrompt $prompt) => $prompt->contains('Hello') && $prompt->isFemale());
Audio::assertQueued(fn (QueuedAudioPrompt $prompt) => $prompt->contains('Hello'));
Audio::fake()->preventStrayAudio();
```

---

## Transcription

```php
use Laravel\Ai\Transcription;
use Laravel\Ai\Prompts\TranscriptionPrompt;
use Laravel\Ai\Prompts\QueuedTranscriptionPrompt;

Transcription::fake();
Transcription::assertGenerated(fn (TranscriptionPrompt $prompt) => $prompt->language === 'en' && $prompt->isDiarized());
Transcription::assertQueued(fn (QueuedTranscriptionPrompt $prompt) => $prompt->isDiarized());
Transcription::fake()->preventStrayTranscriptions();
```

---

## Embeddings

```php
use Laravel\Ai\Embeddings;
use Laravel\Ai\Prompts\EmbeddingsPrompt;
use Laravel\Ai\Prompts\QueuedEmbeddingsPrompt;

Embeddings::fake();
Embeddings::fake(function (EmbeddingsPrompt $prompt) {
    return array_map(
        fn () => Embeddings::fakeEmbedding($prompt->dimensions),
        $prompt->inputs
    );
});

Embeddings::assertGenerated(fn (EmbeddingsPrompt $prompt) => $prompt->contains('Laravel') && $prompt->dimensions === 1536);
Embeddings::assertQueued(fn (QueuedEmbeddingsPrompt $prompt) => $prompt->contains('Laravel'));
Embeddings::fake()->preventStrayEmbeddings();
```

---

## Reranking

```php
use Laravel\Ai\Reranking;
use Laravel\Ai\Prompts\RerankingPrompt;
use Laravel\Ai\Responses\Data\RankedDocument;

Reranking::fake();
Reranking::fake([
    [
        new RankedDocument(index: 0, document: 'First', score: 0.95),
        new RankedDocument(index: 1, document: 'Second', score: 0.80),
    ],
]);

Reranking::assertReranked(fn (RerankingPrompt $prompt) => $prompt->contains('Laravel') && $prompt->limit === 5);
Reranking::assertNothingReranked();
```

---

## Files

```php
use Laravel\Ai\Files;
use Laravel\Ai\Contracts\Files\StorableFile;
use Laravel\Ai\Files\Document;

Files::fake();

Document::fromString('Hello, Laravel!', mimeType: 'text/plain')->as('hello.txt')->put();

Files::assertStored(fn (StorableFile $file) =>
    (string) $file === 'Hello, Laravel!' && $file->mimeType() === 'text/plain'
);
Files::assertDeleted('file-id');
Files::assertNothingDeleted();
```

---

## Vector stores

```php
use Laravel\Ai\Stores;

Stores::fake(); // also fakes file operations

$store = Stores::create('Knowledge Base');
Stores::assertCreated('Knowledge Base');
Stores::assertDeleted('store_id');

$store = Stores::get('store_id');
$store->add('added_id');
$store->assertAdded('added_id');
$store->assertAdded(fn ($file) => $file->name() === 'hello.txt');
```

---

## Pitfalls

- **Queue** tests need **queued** assertion variants where applicable.
- **Structured** agents: ensure fakes return **shape-compatible** data when not using the auto generator.
- **`preventStray*`** is strict — update fakes when adding new code paths.

## See also

- [05-agents-core](05-agents-core.md)
- [14-queueing-agents](14-queueing-agents.md)
