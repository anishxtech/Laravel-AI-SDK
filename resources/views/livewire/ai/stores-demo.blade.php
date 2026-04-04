<div class="mx-auto max-w-2xl space-y-6 p-6">
        <div>
            <flux:heading size="lg">{{ __('Vector stores') }}</flux:heading>
            <flux:text class="mt-1 text-zinc-600 dark:text-zinc-400">
                {{ __('Creates a provider-side store and adds a text document. Uses your default text/store-capable provider.') }}
            </flux:text>
        </div>

        <flux:card class="space-y-4 p-4">
            <flux:input wire:model="name" label="{{ __('Store name') }}" />
            <flux:textarea wire:model="content" rows="4" label="{{ __('File content') }}" />
            <flux:button variant="primary" wire:click="createAndAdd" wire:loading.attr="disabled">
                {{ __('Create store & add file') }}
            </flux:button>
            @if ($error)
                <flux:callout variant="danger" :heading="$error" />
            @endif
            @if ($storeId)
                <p class="text-sm text-zinc-600 dark:text-zinc-400">{{ __('Store id') }}: <code>{{ $storeId }}</code></p>
            @endif
            @if ($documentNote)
                <p class="text-sm">{{ $documentNote }}</p>
            @endif
        </flux:card>
</div>
