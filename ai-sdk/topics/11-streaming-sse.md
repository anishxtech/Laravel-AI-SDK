# Streaming (SSE)

## Overview

Call **`$agent->stream('...')`** to stream the model’s output. The returned **`StreamableAgentResponse`** can be **returned from a route** to send a **streaming HTTP response** (SSE-style) to the client as tokens arrive.

## Basic route

```php
use App\Ai\Agents\SalesCoach;

Route::get('/coach', function () {
    return (new SalesCoach)->stream('Analyze this sales transcript...');
});
```

## Completion hook: `then()`

After the full stream finishes, **`then()`** runs with a **`StreamedAgentResponse`** (text, events, usage, etc.):

```php
use App\Ai\Agents\SalesCoach;
use Laravel\Ai\Responses\StreamedAgentResponse;

Route::get('/coach', function () {
    return (new SalesCoach)
        ->stream('Analyze this sales transcript...')
        ->then(function (StreamedAgentResponse $response) {
            // $response->text, $response->events, $response->usage...
        });
});
```

## Manual iteration

```php
$stream = (new SalesCoach)->stream('Analyze this sales transcript...');

foreach ($stream as $event) {
    // handle each event
}
```

## Frontend notes

- **Livewire** full-page components do not always map cleanly to raw SSE — often a **dedicated route** returns the stream and the browser consumes it via **`EventSource`** or **`fetch`** with a streaming reader.
- Configure reverse proxies (nginx, Apache, cloud load balancers) so responses are **not buffered** end-to-end.

## In this repository

- **`/ai/stream`** — UI demo
- **`/ai/stream/sse`** — closure returning raw stream
- **`/ai/stream/vercel`** — Vercel protocol ([12](12-streaming-vercel-protocol.md))

## Pitfalls

- **Timeouts** on long streams — raise agent `timeout` or server limits.
- **Middleware** can still run around the stream; see [20](20-agent-middleware.md).

## See also

- [12-streaming-vercel-protocol](12-streaming-vercel-protocol.md)
- [13-broadcasting-streams](13-broadcasting-streams.md)
