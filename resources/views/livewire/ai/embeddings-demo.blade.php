<x-ai.demo-shell
    :title="__('Embeddings & reranking')"
    :subtitle="__('Embeddings use your default embedding provider; reranking uses default_for_reranking (often Cohere). Toggle cache to demo request-level embedding caching.')"
>
    <div class="mx-auto max-w-2xl space-y-8">
        @if ($error)
            <flux:callout variant="danger" :heading="$error" />
        @endif

        <flux:card class="space-y-4 border-zinc-800 bg-zinc-900/50 p-4">
            <flux:heading size="sm" class="text-zinc-200">{{ __('Embeddings') }}</flux:heading>
            <flux:textarea wire:model="embedInput" rows="5" label="{{ __('One string per line') }}" class="border-zinc-700 bg-zinc-900" />
            <flux:checkbox wire:model.live="useEmbeddingCache" label="{{ __('Use request cache (Embeddings::cache())') }}" />
            <flux:button variant="primary" wire:click="embed" wire:loading.attr="disabled">
                {{ __('Generate embeddings preview') }}
            </flux:button>
            @if ($embeddingPreview)
                <pre class="overflow-x-auto rounded-lg bg-zinc-900 p-3 text-xs text-zinc-300 ring-1 ring-zinc-800">{{ json_encode($embeddingPreview, JSON_PRETTY_PRINT) }}</pre>
            @endif
        </flux:card>

        <flux:card class="space-y-4 border-zinc-800 bg-zinc-900/50 p-4">
            <flux:heading size="sm" class="text-zinc-200">{{ __('Reranking') }}</flux:heading>
            <flux:textarea wire:model="rerankCandidates" rows="5" label="{{ __('Candidate lines') }}" class="border-zinc-700 bg-zinc-900" />
            <flux:input wire:model="rerankQuery" label="{{ __('Query') }}" class="border-zinc-700 bg-zinc-900" />
            <flux:button variant="primary" wire:click="rerank" wire:loading.attr="disabled">
                {{ __('Rerank') }}
            </flux:button>
            @if ($rerankResults)
                <pre class="overflow-x-auto rounded-lg bg-zinc-900 p-3 text-xs text-zinc-300 ring-1 ring-zinc-800">{{ json_encode($rerankResults, JSON_PRETTY_PRINT) }}</pre>
            @endif
        </flux:card>
    </div>
</x-ai.demo-shell>
