<div class="mx-auto max-w-2xl space-y-6 p-6">
        <div>
            <flux:heading size="lg">{{ __('Image generation') }}</flux:heading>
            <flux:text class="mt-1 text-zinc-600 dark:text-zinc-400">
                {{ __('Uses Laravel\\Ai\\Image. Default image provider comes from config/ai.php.') }}
            </flux:text>
        </div>

        <flux:card class="space-y-4 p-4">
            <flux:textarea wire:model="prompt" rows="3" label="{{ __('Prompt') }}" />
            <flux:button variant="primary" wire:click="generate" wire:loading.attr="disabled">
                {{ __('Generate') }}
            </flux:button>
            @if ($error)
                <flux:callout variant="danger" :heading="$error" />
            @endif
        </flux:card>

        @if ($path)
            <flux:card class="p-4">
                <flux:text class="mb-2 text-sm">{{ __('Stored at') }}: <code>{{ $path }}</code></flux:text>
                <img src="{{ $publicUrl }}" alt="" class="max-h-96 rounded-lg border border-zinc-700" />
            </flux:card>
        @endif
</div>
