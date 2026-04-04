# Streaming with the Vercel AI SDK protocol

## Overview

Chain **`->usingVercelDataProtocol()`** on the streamable response so event framing matches the **Vercel AI SDK** stream protocol. Use this when your frontend uses **`@ai-sdk/react`**, **`useChat`**, or other parsers that expect that wire format.

## Example

```php
use App\Ai\Agents\SalesCoach;

Route::get('/coach', function () {
    return (new SalesCoach)
        ->stream('Analyze this sales transcript...')
        ->usingVercelDataProtocol();
});
```

## When to use it

- You already built a UI against **Vercel AI** streaming conventions.
- You want **interoperable** clients or shared parsing libraries between Node and Laravel.

## When not to use it

- Simple **EventSource** or custom SSE consumers — default streaming may be simpler ([11](11-streaming-sse.md)).

## Pitfalls

- **CORS** and **authentication** for browser clients — protect the route like any API.
- Only enable when the **client** expects this protocol; mismatched formats break parsers.

## See also

- [11-streaming-sse](11-streaming-sse.md)
