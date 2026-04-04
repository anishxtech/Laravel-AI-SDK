<div class="mx-auto max-w-2xl space-y-6 p-6">
        <div>
            <flux:heading size="lg">{{ __('Similarity search (pgvector)') }}</flux:heading>
            <flux:text class="mt-1 text-zinc-600 dark:text-zinc-400">
                {{ __('Requires PostgreSQL, pgvector, and migrations. Index a chunk, then ask the SimilarityResearch agent.') }}
            </flux:text>
        </div>

        @if (! $this->supportsVectors())
            <flux:callout variant="warning" heading="{{ __('Not available on this database') }}" />
            <p class="text-sm text-zinc-500">{{ __('Switch to PostgreSQL, enable pgvector, run migrations, and ensure the knowledge_chunks table exists.') }}</p>
        @endif

        @if ($error)
            <flux:callout variant="danger" :heading="$error" />
        @endif

        <flux:card class="space-y-4 p-4">
            <flux:heading size="sm">{{ __('Index a chunk') }}</flux:heading>
            <flux:input wire:model="chunkTitle" label="{{ __('Title') }}" />
            <flux:textarea wire:model="chunkContent" rows="4" label="{{ __('Content') }}" />
            <flux:button variant="primary" wire:click="indexChunk" wire:loading.attr="disabled" :disabled="! $this->supportsVectors()">
                {{ __('Embed & save') }}
            </flux:button>
        </flux:card>

        <flux:card class="space-y-4 p-4">
            <flux:heading size="sm">{{ __('Ask with SimilaritySearch tool') }}</flux:heading>
            <flux:textarea wire:model="question" rows="3" label="{{ __('Question') }}" />
            <flux:button variant="primary" wire:click="ask" wire:loading.attr="disabled" :disabled="! $this->supportsVectors()">
                {{ __('Ask') }}
            </flux:button>
        </flux:card>

        @if ($answer)
            <flux:card class="p-4 text-sm whitespace-pre-wrap">{{ $answer }}</flux:card>
        @endif
</div>
