<x-ai.demo-shell
    :title="__('Vector stores')"
    :subtitle="__('Creates a provider-side store and adds a text document. Pair with the File search demo and FileSearch tool.')"
>
    <div class="mx-auto max-w-2xl space-y-6">
        <flux:card class="space-y-4 border-zinc-800 bg-zinc-900/50 p-4">
            <flux:input wire:model="name" label="{{ __('Store name') }}" class="border-zinc-700 bg-zinc-900" />
            <flux:textarea wire:model="content" rows="4" label="{{ __('File content') }}" class="border-zinc-700 bg-zinc-900" />
            <flux:button variant="primary" wire:click="createAndAdd" wire:loading.attr="disabled">
                {{ __('Create store & add file') }}
            </flux:button>
            @if ($error)
                <flux:callout variant="danger" :heading="$error" />
            @endif
            @if ($storeId)
                <p class="text-sm text-zinc-400">{{ __('Store id') }}: <code class="text-zinc-300">{{ $storeId }}</code></p>
            @endif
            @if ($documentNote)
                <p class="text-sm text-zinc-300">{{ $documentNote }}</p>
            @endif
        </flux:card>
    </div>
</x-ai.demo-shell>
