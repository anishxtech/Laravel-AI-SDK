<div class="mx-auto max-w-2xl space-y-6 p-6">
        <div>
            <flux:heading size="lg">{{ __('Agent middleware') }}</flux:heading>
            <flux:text class="mt-1 text-zinc-600 dark:text-zinc-400">
                {{ __('LogAiPrompt middleware logs a preview to the default log channel. Check storage/logs/laravel.log after running.') }}
            </flux:text>
        </div>

        <flux:card class="space-y-4 p-4">
            <flux:textarea wire:model="input" rows="3" label="{{ __('Prompt') }}" />
            <flux:button variant="primary" wire:click="run" wire:loading.attr="disabled">
                {{ __('Run') }}
            </flux:button>
            @if ($error)
                <flux:callout variant="danger" :heading="$error" />
            @endif
        </flux:card>

        @if ($output)
            <flux:card class="p-4 text-sm">{{ $output }}</flux:card>
        @endif
</div>
