# Broadcasting streamed events

## Overview

While iterating a stream, individual events can be **broadcast** to Laravel channels so multiple clients (tabs, dashboards) see chunks in real time. You can also use **`broadcastOnQueue`** to run the agent work and broadcast as events arrive (see upstream API for exact signature on your package version).

## Pattern: broadcast each event

```php
use App\Ai\Agents\SalesCoach;
use Illuminate\Broadcasting\Channel;

$stream = (new SalesCoach)->stream('Analyze this sales transcript...');

foreach ($stream as $event) {
    $event->broadcast(new Channel('channel-name'));
}
```

Use **`broadcastNow()`** when you need synchronous dispatch within the request.

## Pattern: queue + broadcast

**`broadcastOnQueue`** runs the agent on the queue and broadcasts stream events as they arrive. Signature (typical):

`broadcastOnQueue(string $prompt, Channel|array $channels, array $attachments = [], Lab|array|string|null $provider = null, ?string $model = null)`

```php
use Illuminate\Broadcasting\Channel;

(new SalesCoach)->broadcastOnQueue(
    'Analyze this sales transcript...',
    new Channel('channel-name'),
);
```

## Requirements

- Configure a **broadcasting driver** (Pusher, Ably, **Laravel Reverb**, etc.) in `config/broadcasting.php`.
- Use **private channels** or **presence channels** with **authorization** so users only subscribe to their own streams.

## Pitfalls

- **High-frequency** chunks can overwhelm websockets — **batch**, **throttle**, or downsample for UI.
- **AuthZ**: never broadcast internal prompts or PII to public channels.

## See also

- [11-streaming-sse](11-streaming-sse.md)
