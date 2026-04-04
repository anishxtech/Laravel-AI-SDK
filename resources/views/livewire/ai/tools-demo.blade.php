<div class="mx-auto max-w-2xl space-y-6 p-6">
        <div>
            <flux:heading size="lg">{{ __('Custom & provider tools') }}</flux:heading>
            <flux:text class="mt-1 text-zinc-600 dark:text-zinc-400">
                {{ __('LaravelVersion tool plus WebSearch and WebFetch (Gemini / OpenAI / Anthropic). Ask something that needs the app version or the web.') }}
            </flux:text>
        </div>

        <flux:card class="space-y-4 p-4">
            <flux:textarea wire:model="input" rows="3" label="{{ __('Prompt') }}" />
            <flux:button variant="primary" wire:click="run" wire:loading.attr="disabled">
                {{ __('Run') }}
            </flux:button>
            @error('input')
                <flux:callout variant="danger" :heading="$message" />
            @enderror
        </flux:card>

        @if ($output)
            <flux:card class="p-4">
                <flux:heading size="sm" class="mb-2">{{ __('Response') }}</flux:heading>
                <div class="prose prose-invert max-w-none text-sm">{{ $output }}</div>
            </flux:card>
        @endif
</div>
