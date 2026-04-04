# Events and observability

## Overview

The AI SDK **dispatches events** during generation, tool use, streaming, file operations, and store lifecycle. Listen in **`EventServiceProvider`**, a service provider, or **`Event::listen`** to build **usage logs**, **billing**, **tracing**, and **alerts**.

## Example listener

```php
use Illuminate\Support\Facades\Event;
use Laravel\Ai\Events\AgentPrompted;

Event::listen(AgentPrompted::class, function (AgentPrompted $event) {
    logger()->info('Agent run', ['user_id' => auth()->id()]);
});
```

(Event class names and payloads follow your installed package — import from `Laravel\Ai\Events\...`.)

## Event names (official list)

You may listen for events including:

- `AddingFileToStore`
- `AgentPrompted`
- `AgentStreamed`
- `AudioGenerated`
- `CreatingStore`
- `EmbeddingsGenerated`
- `FileAddedToStore`
- `FileDeleted`
- `FileRemovedFromStore`
- `FileStored`
- `GeneratingAudio`
- `GeneratingEmbeddings`
- `GeneratingImage`
- `GeneratingTranscription`
- `ImageGenerated`
- `InvokingTool`
- `PromptingAgent`
- `RemovingFileFromStore`
- `Reranked`
- `Reranking`
- `StoreCreated`
- `StoringFile`
- `StreamingAgent`
- `ToolInvoked`
- `TranscriptionGenerated`

Use these for **cost accounting**, **audit trails**, and **APM** correlation IDs.

## When to use events vs middleware

| Mechanism | Best for |
| --- | --- |
| **Middleware** ([20](20-agent-middleware.md)) | Per-agent prompt/response hooks in PHP |
| **Events** | Cross-cutting metrics for **all** SDK activity, including non-agent APIs (`Image`, `Embeddings`, …) |

## Pitfalls

- **High-volume streaming** can emit many events — **sample** or aggregate in production.
- Do **not** log **secrets** or full PII without policy and retention controls.

## See also

- [20-agent-middleware](20-agent-middleware.md)
