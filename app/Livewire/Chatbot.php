<?php

namespace App\Livewire;

use App\Ai\Agents\LaravelAssistant;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Chatbot')]
class Chatbot extends Component
{
    public string $input = '';

    public bool $thinking = false;

    public array $messages = [];

    public string|null $conversationId = null;

    public function sendMessage(): void
    {
        $userMessage = trim($this->input);

        if (empty($userMessage)) {
            return;
        }

        $this->messages[] = [
            'role'    => 'user',
            'content' => $userMessage,
        ];

        $this->input = '';
        $this->thinking = true;

        $this->dispatch('message-added');
    }

    public function getAiResponse(): void
    {
        $lastUserMessage = collect($this->messages)
            ->where('role', 'user')
            ->last();

        if (! $lastUserMessage) {
            $this->thinking = false;
            return;
        }

        try {
            $agent = new LaravelAssistant;

            if (is_null($this->conversationId)) {
                $response = $agent
                    ->forUser(auth()->user())
                    ->prompt($lastUserMessage['content']);

                $this->conversationId = $response->conversationId;
            } else {
                $response = $agent
                    ->continue($this->conversationId, as: auth()->user())
                    ->prompt($lastUserMessage['content']);
            }

            $this->messages[] = [
                'role'    => 'assistant',
                'content' => (string) $response,
            ];

        } catch (\Exception $e) {
            $this->messages[] = [
                'role'    => 'assistant',
                'content' => 'Sorry, I encountered an error. Please try again.',
            ];
        }

        $this->thinking = false;
        $this->dispatch('message-added');
    }

    public function clearConversation(): void
    {
        $this->messages = [];
        $this->conversationId = null;
    }

    public function render()
    {
        return view('livewire.chatbot');
    }
}