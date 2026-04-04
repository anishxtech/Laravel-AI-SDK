# Remembering conversations (`RemembersConversations`)

## Overview

The **`Laravel\Ai\Concerns\RemembersConversations`** trait persists and reloads conversation turns in the SDK’s **database tables** so you do **not** hand-roll `messages()` for standard chat flows. The agent still implements `Conversational`; the trait wires persistence for you.

**Prerequisite:** publish and run AI SDK **migrations** ([01](01-installation-and-migrations.md)).

## Minimal agent

```php
use Laravel\Ai\Concerns\RemembersConversations;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Promptable;

class SalesCoach implements Agent, Conversational
{
    use Promptable, RemembersConversations;

    public function instructions(): string
    {
        return 'You are a sales coach...';
    }
}
```

## Start a new thread for a user

```php
$response = (new SalesCoach)->forUser($user)->prompt('Hello!');

$conversationId = $response->conversationId;
```

Store **`conversationId`** in your UI state, session, or a column on your `users` table so you can resume later. You can also inspect **`agent_conversations`** (and related tables) directly.

## Continue an existing thread

```php
$response = (new SalesCoach)
    ->continue($conversationId, as: $user)
    ->prompt('Tell me more about that.');
```

## Behavior

- Previous messages are **loaded automatically** when you continue.
- New **user** and **assistant** messages are **saved** after each interaction.

## In this repository

Try **`/chat`** for a chat-style flow (see parent [README](../README.md)).

## Pitfalls

- Wrong use of **`forUser`** vs **`continue`** can create **duplicate** threads.
- Clearing chat in the UI should reset the stored **`conversationId`** when you intend a fresh conversation.
- Migrations must exist **before** first use in production.

## See also

- [01-installation-and-migrations](01-installation-and-migrations.md)
- [07-conversational-messages](07-conversational-messages.md)
