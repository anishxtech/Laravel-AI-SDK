<div class="mx-auto max-w-2xl space-y-6 p-6">
        <div>
            <flux:heading size="lg">{{ __('File search (provider tool)') }}</flux:heading>
            <flux:text class="mt-1 text-zinc-600 dark:text-zinc-400">
                {{ __('Requires OPENAI_VECTOR_STORE_ID and documents indexed in that OpenAI vector store.') }}
            </flux:text>
        </div>

        @if (! config('services.ai.openai_vector_store_id'))
            <flux:callout variant="warning" heading="{{ __('Missing OPENAI_VECTOR_STORE_ID') }}" />
        @endif

        <flux:card class="space-y-4 p-4">
            <flux:textarea wire:model="input" rows="3" label="{{ __('Prompt') }}" />
            <flux:button variant="primary" wire:click="ask" wire:loading.attr="disabled">
                {{ __('Ask') }}
            </flux:button>
            @error('input')
                <flux:callout variant="danger" :heading="$message" />
            @enderror
        </flux:card>

        @if ($output)
            <flux:card class="p-4 text-sm whitespace-pre-wrap">{{ $output }}</flux:card>
        @endif
</div>
