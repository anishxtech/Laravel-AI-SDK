<div class="mx-auto max-w-2xl space-y-8 p-6">
        <div>
            <flux:heading size="lg">{{ __('Embeddings & reranking') }}</flux:heading>
            <flux:text class="mt-1 text-zinc-600 dark:text-zinc-400">
                {{ __('Embeddings use your default embedding provider; reranking uses default_for_reranking (often Cohere).') }}
            </flux:text>
        </div>

        @if ($error)
            <flux:callout variant="danger" :heading="$error" />
        @endif

        <flux:card class="space-y-4 p-4">
            <flux:heading size="sm">{{ __('Embeddings') }}</flux:heading>
            <flux:textarea wire:model="embedInput" rows="5" label="{{ __('One string per line') }}" />
            <flux:button variant="primary" wire:click="embed" wire:loading.attr="disabled">
                {{ __('Generate embeddings preview') }}
            </flux:button>
            @if ($embeddingPreview)
                <pre class="overflow-x-auto rounded-lg bg-zinc-100 p-3 text-xs dark:bg-zinc-900">{{ json_encode($embeddingPreview, JSON_PRETTY_PRINT) }}</pre>
            @endif
        </flux:card>

        <flux:card class="space-y-4 p-4">
            <flux:heading size="sm">{{ __('Reranking') }}</flux:heading>
            <flux:textarea wire:model="rerankCandidates" rows="5" label="{{ __('Candidate lines') }}" />
            <flux:input wire:model="rerankQuery" label="{{ __('Query') }}" />
            <flux:button variant="primary" wire:click="rerank" wire:loading.attr="disabled">
                {{ __('Rerank') }}
            </flux:button>
            @if ($rerankResults)
                <pre class="overflow-x-auto rounded-lg bg-zinc-100 p-3 text-xs dark:bg-zinc-900">{{ json_encode($rerankResults, JSON_PRETTY_PRINT) }}</pre>
            @endif
        </flux:card>
</div>
