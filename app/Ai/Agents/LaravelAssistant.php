<?php

namespace App\Ai\Agents;

use Laravel\Ai\Concerns\RemembersConversations;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\Conversational;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Messages\Message;
use Laravel\Ai\Promptable;
use Stringable;

class LaravelAssistant implements Agent, Conversational, HasTools
{
    use Promptable, RemembersConversations;

    /**
     * Get the instructions that the agent should follow.
     */
    public function instructions(): Stringable|string
    {
        return <<<PROMPT
        You are an expert Laravel coding assistant with deep knowledge of the Laravel 12 ecosystem.

        Your role:
        - Answer questions about Laravel, PHP, Livewire, Filament, Inertia.js, Eloquent, queues, events, and related packages
        - Provide clean, modern code examples using the latest Laravel 12 syntax and best practices
        - Explain not just what to do, but why — help developers understand the reasoning
        - When showing code, always use the newest approach (e.g. #[Scope] attribute syntax, Attribute::make() for mutators)
        - Suggest community packages like Spatie when they are the right tool for the job
        - Keep answers focused and practical — avoid unnecessary theory

        Boundaries:
        - If asked about topics unrelated to Laravel or PHP web development, politely redirect to Laravel topics
        - If you are unsure about something, say so honestly rather than guessing
        - Never suggest outdated or deprecated approaches without explaining that they are outdated

        Tone:
        - Friendly, concise, and developer-focused
        - Talk like a senior developer helping a colleague, not like a formal documentation page
        PROMPT;
    }

    /**
     * Get the list of messages comprising the conversation so far.
     *
     * @return Message[]
     */
    public function messages(): iterable
    {
        return [];
    }

    /**
     * Get the tools available to the agent.
     *
     * @return Tool[]
     */
    public function tools(): iterable
    {
        return [];
    }
}
