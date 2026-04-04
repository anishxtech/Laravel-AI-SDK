<x-ai.demo-shell
    :title="__('Custom & provider tools')"
    :subtitle="__('LaravelVersion tool plus WebSearch and WebFetch. Ask something that needs the app version or the web.')"
>
    <div class="mx-auto max-w-2xl space-y-6">
        <flux:card class="space-y-4 border-zinc-800 bg-zinc-900/50 p-4">
            <flux:textarea wire:model="input" rows="3" label="{{ __('Prompt') }}" class="border-zinc-700 bg-zinc-900" />
            <flux:button variant="primary" wire:click="run" wire:loading.attr="disabled">
                {{ __('Run') }}
            </flux:button>
            @error('input')
                <flux:callout variant="danger" :heading="$message" />
            @enderror
        </flux:card>

        @if ($output)
            <flux:card class="border-zinc-800 bg-zinc-900/50 p-4">
                <flux:heading size="sm" class="mb-2 text-zinc-200">{{ __('Response') }}</flux:heading>
                <div class="prose prose-invert max-w-none text-sm text-zinc-300">{{ $output }}</div>
            </flux:card>
        @endif
    </div>
</x-ai.demo-shell>
