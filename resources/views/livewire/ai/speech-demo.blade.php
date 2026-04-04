<div class="mx-auto max-w-2xl space-y-6 p-6">
        <div>
            <flux:heading size="lg">{{ __('Text to speech') }}</flux:heading>
            <flux:text class="mt-1 text-zinc-600 dark:text-zinc-400">
                {{ __('Uses Laravel\\Ai\\Audio. Configure default audio provider and keys in config/ai.php.') }}
            </flux:text>
        </div>

        <flux:card class="space-y-4 p-4">
            <flux:textarea wire:model="text" rows="4" label="{{ __('Text') }}" />
            <flux:button variant="primary" wire:click="generate" wire:loading.attr="disabled">
                {{ __('Generate audio') }}
            </flux:button>
            @if ($error)
                <flux:callout variant="danger" :heading="$error" />
            @endif
        </flux:card>

        @if ($publicUrl)
            <flux:card class="p-4">
                <audio controls src="{{ $publicUrl }}" class="w-full"></audio>
                <p class="mt-2 text-xs text-zinc-500"><code>{{ $path }}</code></p>
            </flux:card>
        @endif
</div>
