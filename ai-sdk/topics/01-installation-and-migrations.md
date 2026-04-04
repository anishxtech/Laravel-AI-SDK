# Installation and migrations

## Overview

The **Laravel AI SDK** (`laravel/ai`) is a Composer package that registers a service provider, publishes **`config/ai.php`**, and optionally ships **database migrations** for persisted agent conversations. It gives you a single, Laravel-friendly API for multiple AI providers (OpenAI, Anthropic, Gemini, and others).

## When you need this

Use it in any Laravel app that will call LLM APIs, generate images/audio, embeddings, or store **conversation threads** in the database via the SDK’s built-in persistence.

## Install (official flow)

1. **Require the package**

   ```bash
   composer require laravel/ai
   ```

2. **Publish config and migrations**

   ```bash
   php artisan vendor:publish --provider="Laravel\Ai\AiServiceProvider"
   ```

3. **Run migrations**

   ```bash
   php artisan migrate
   ```

   This creates tables the SDK uses for **conversation storage**, including (per upstream docs) tables such as **`agent_conversations`** and **`agent_conversation_messages`** (exact names match the published migrations for your package version).

## What to do next

- Copy API keys into `.env` and align them with `config/ai.php` (see [02-configuration-and-env](02-configuration-and-env.md)).
- You only **need** the conversation migrations if you use **`RemembersConversations`** or other features that persist threads to these tables ([08-remembers-conversations](08-remembers-conversations.md)).

## In this repository

After install, explore authenticated routes under `/ai/...` and `/chat` (see the parent [README](../README.md)).

## Pitfalls

- Using **`RemembersConversations`** without having run the published migrations causes runtime errors.
- Pin **`laravel/ai`** to a version compatible with your Laravel **major** version.
- Publishing overwrites are one-time; back up customized config before re-publishing.

## See also

- [02-configuration-and-env](02-configuration-and-env.md)
- [08-remembers-conversations](08-remembers-conversations.md)
