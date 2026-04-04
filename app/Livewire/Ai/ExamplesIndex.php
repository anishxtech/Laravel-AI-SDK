<?php

namespace App\Livewire\Ai;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Laravel AI SDK examples')]
class ExamplesIndex extends Component
{
    /**
     * @return list<array{title: string, description: string, route: string, path: string, keys: string}>
     */
    public function rows(): array
    {
        return [
            ['title' => __('Chat (persisted)'), 'description' => __('RemembersConversations, forUser, continue'), 'route' => 'chat', 'path' => '/chat', 'keys' => config('ai.default').' API key'],
            ['title' => __('Structured output'), 'description' => __('HasStructuredOutput, JSON schema'), 'route' => 'ai.structured', 'path' => '/ai/structured', 'keys' => config('ai.default').' API key'],
            ['title' => __('Tools & provider tools'), 'description' => __('Custom tools, WebSearch, WebFetch'), 'route' => 'ai.tools', 'path' => '/ai/tools', 'keys' => config('ai.default').' API key'],
            ['title' => __('Anonymous agent'), 'description' => __('agent() helper'), 'route' => 'ai.quick', 'path' => '/ai/quick', 'keys' => config('ai.default').' API key'],
            ['title' => __('Attachments'), 'description' => __('Document / image uploads with prompt'), 'route' => 'ai.attachments', 'path' => '/ai/attachments', 'keys' => config('ai.default').' API key'],
            ['title' => __('Streaming'), 'description' => __('SSE + Vercel protocol routes'), 'route' => 'ai.stream', 'path' => '/ai/stream', 'keys' => config('ai.default').' API key'],
            ['title' => __('Queued agent'), 'description' => __('queue(), then, catch'), 'route' => 'ai.queue', 'path' => '/ai/queue', 'keys' => config('ai.default').' API key'],
            ['title' => __('Image generation'), 'description' => __('Image::of, store'), 'route' => 'ai.images', 'path' => '/ai/images', 'keys' => 'GEMINI / OPENAI / XAI (see config/ai.php)'],
            ['title' => __('Text to speech'), 'description' => __('Audio::of'), 'route' => 'ai.speech', 'path' => '/ai/speech', 'keys' => 'OPENAI or ELEVENLABS_API_KEY'],
            ['title' => __('Transcription'), 'description' => __('Transcription::fromUpload'), 'route' => 'ai.transcribe', 'path' => '/ai/transcribe', 'keys' => 'OPENAI (or Mistral/Eleven per config)'],
            ['title' => __('Embeddings & reranking'), 'description' => __('Embeddings::for, Reranking::of'), 'route' => 'ai.embeddings', 'path' => '/ai/embeddings', 'keys' => 'OPENAI + COHERE_API_KEY (rerank default)'],
            ['title' => __('Provider files'), 'description' => __('Document::put, fromId'), 'route' => 'ai.files', 'path' => '/ai/files', 'keys' => config('ai.default').' API key'],
            ['title' => __('Vector stores'), 'description' => __('Stores::create, add'), 'route' => 'ai.stores', 'path' => '/ai/stores', 'keys' => 'OPENAI or GEMINI (per default_for text/store)'],
            ['title' => __('File search tool'), 'description' => __('FileSearch + OPENAI_VECTOR_STORE_ID'), 'route' => 'ai.file-search', 'path' => '/ai/file-search', 'keys' => 'OPENAI_API_KEY, OPENAI_VECTOR_STORE_ID'],
            ['title' => __('Similarity search (pgvector)'), 'description' => __('SimilaritySearch tool, PostgreSQL only'), 'route' => 'ai.similarity', 'path' => '/ai/similarity', 'keys' => 'PostgreSQL + pgvector, OPENAI (embeddings)'],
            ['title' => __('Agent middleware'), 'description' => __('HasMiddleware'), 'route' => 'ai.middleware', 'path' => '/ai/middleware', 'keys' => config('ai.default').' API key'],
            ['title' => __('Provider failover'), 'description' => __('prompt(..., provider: [Lab::…, Lab::…])'), 'route' => 'ai.failover', 'path' => '/ai/failover', 'keys' => 'Two configured text providers recommended'],
        ];
    }

    public function render()
    {
        return view('livewire.ai.examples-index')
            ->layout('layouts.app', [
                'title' => __('Laravel AI SDK examples'),
            ]);
    }
}
