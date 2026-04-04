# Queueing agents

## Overview

**`$agent->queue(...)`** dispatches the LLM call to Laravel’s **queue** so the HTTP request can return immediately. Register **`->then()`** for success (receives `AgentResponse`) and **`->catch()`** for failures.

```php
use Illuminate\Http\Request;
use Laravel\Ai\Responses\AgentResponse;
use Throwable;

Route::post('/coach', function (Request $request) {
    (new SalesCoach)
        ->queue($request->input('transcript'))
        ->then(function (AgentResponse $response) {
            // Persist, notify, dispatch events...
        })
        ->catch(function (Throwable $e) {
            report($e);
        });

    return back();
});
```

## When to use it

- Prompts that take **many seconds** or involve **heavy tool loops**.
- You want **retries** and **worker scaling** via the queue subsystem.

## Configuration

- Set **`QUEUE_CONNECTION`** to a real backend (redis, database, SQS) in production — **`sync`** runs inline and defeats the purpose.

## Testing

Use `SalesCoach::fake([...])` and **queued** assertions such as **`assertQueued`** ([35](35-testing-fakes.md)).

## Pitfalls

- Callbacks run in the **queue worker** context — **no HTTP session** unless you pass IDs explicitly.
- **Idempotency**: if the user double-submits, you may enqueue duplicate jobs — dedupe at the application layer.
- **User feedback**: return a job ID or poll a status endpoint if the UI must show completion.

## See also

- [06-prompting-and-container](06-prompting-and-container.md)
- [35-testing-fakes](35-testing-fakes.md)
