<x-ai.demo-shell
    :title="__('File search (provider tool)')"
    :subtitle="__('Requires OPENAI_VECTOR_STORE_ID and documents indexed in that vector store. Implements FileSearch (topic 19).')"
>
    <div class="mx-auto max-w-2xl space-y-6">
        @if (! config('services.ai.openai_vector_store_id'))
            <flux:callout variant="warning" heading="{{ __('Missing OPENAI_VECTOR_STORE_ID') }}" />
        @endif

        <flux:card class="space-y-4 border-zinc-800 bg-zinc-900/50 p-4">
            <flux:textarea wire:model="input" rows="3" label="{{ __('Prompt') }}" class="border-zinc-700 bg-zinc-900" />
            <flux:button variant="primary" wire:click="ask" wire:loading.attr="disabled">
                {{ __('Ask') }}
            </flux:button>
            @error('input')
                <flux:callout variant="danger" :heading="$message" />
            @enderror
        </flux:card>

        @if ($output)
            <flux:card class="whitespace-pre-wrap border-zinc-800 bg-zinc-900/50 p-4 text-sm text-zinc-300">{{ $output }}</flux:card>
        @endif
    </div>
</x-ai.demo-shell>
