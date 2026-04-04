<x-ai.demo-shell
    :title="__('Similarity search (pgvector)')"
    :subtitle="__('Requires PostgreSQL, pgvector, and knowledge_chunks. Covers SimilaritySearch + local vectors (topics 16, 29).')"
>
    <div class="mx-auto max-w-2xl space-y-6">
        @if (! $this->supportsVectors())
            <flux:callout variant="warning" heading="{{ __('Not available on this database') }}" />
            <p class="text-sm text-zinc-500">{{ __('Switch to PostgreSQL, enable pgvector, run migrations, and ensure the knowledge_chunks table exists.') }}</p>
        @endif

        @if ($error)
            <flux:callout variant="danger" :heading="$error" />
        @endif

        <flux:card class="space-y-4 border-zinc-800 bg-zinc-900/50 p-4">
            <flux:heading size="sm" class="text-zinc-200">{{ __('Index a chunk') }}</flux:heading>
            <flux:input wire:model="chunkTitle" label="{{ __('Title') }}" class="border-zinc-700 bg-zinc-900" />
            <flux:textarea wire:model="chunkContent" rows="4" label="{{ __('Content') }}" class="border-zinc-700 bg-zinc-900" />
            <flux:button variant="primary" wire:click="indexChunk" wire:loading.attr="disabled" :disabled="! $this->supportsVectors()">
                {{ __('Embed & save') }}
            </flux:button>
        </flux:card>

        <flux:card class="space-y-4 border-zinc-800 bg-zinc-900/50 p-4">
            <flux:heading size="sm" class="text-zinc-200">{{ __('Ask with SimilaritySearch tool') }}</flux:heading>
            <flux:textarea wire:model="question" rows="3" label="{{ __('Question') }}" class="border-zinc-700 bg-zinc-900" />
            <flux:button variant="primary" wire:click="ask" wire:loading.attr="disabled" :disabled="! $this->supportsVectors()">
                {{ __('Ask') }}
            </flux:button>
        </flux:card>

        @if ($answer)
            <flux:card class="whitespace-pre-wrap border-zinc-800 bg-zinc-900/50 p-4 text-sm text-zinc-300">{{ $answer }}</flux:card>
        @endif
    </div>
</x-ai.demo-shell>
