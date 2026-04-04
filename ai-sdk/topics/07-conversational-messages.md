# Conversation context (`Conversational`)

## Overview

If your agent implements `Laravel\Ai\Contracts\Conversational`, you implement **`messages(): iterable`** to supply prior turns. Each item should be a `Laravel\Ai\Messages\Message` with **role** and **content** so the model sees a multi-turn thread.

## When to use this

- You store history **yourself** (custom tables, CRM, external store).
- You need full control over **what** is injected (summarization, redaction, per-tenant filtering).

## Example

```php
use App\Models\History;
use Laravel\Ai\Messages\Message;

public function messages(): iterable
{
    return History::where('user_id', $this->user->id)
        ->latest()
        ->limit(50)
        ->get()
        ->reverse()
        ->map(fn ($message) => new Message($message->role, $message->content))
        ->all();
}
```

## Comparison with `RemembersConversations`

| Approach | You implement | Persistence |
| --- | --- | --- |
| **`Conversational`** | `messages()` | Your app |
| **`RemembersConversations`** | Only instructions (typical) | SDK tables ([08](08-remembers-conversations.md)) |

You can choose one strategy per agent design.

## Pitfalls

- **Unbounded** history exceeds context windows — cap rows or summarize old turns.
- Roles must follow **provider rules** (e.g. alternating user/assistant where required).

## See also

- [08-remembers-conversations](08-remembers-conversations.md)
