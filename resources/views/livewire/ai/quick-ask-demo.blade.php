<div class="mx-auto max-w-2xl space-y-6 p-6">
        <div>
            <flux:heading size="lg">{{ __('Anonymous agent') }}</flux:heading>
            <flux:text class="mt-1 text-zinc-600 dark:text-zinc-400">
                {{ __('Uses the agent() helper without a dedicated Agent class.') }}
            </flux:text>
        </div>

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
            <flux:card class="p-4 text-sm">{{ $output }}</flux:card>
        @endif
</div>
