<x-ai.demo-shell
    :title="__('Text to speech')"
    :subtitle="__('Uses Laravel\\Ai\\Audio. Configure default audio provider and keys in config/ai.php.')"
>
    <div class="mx-auto max-w-2xl space-y-6">
        <flux:card class="space-y-4 border-zinc-800 bg-zinc-900/50 p-4">
            <flux:textarea wire:model="text" rows="4" label="{{ __('Text') }}" class="border-zinc-700 bg-zinc-900" />
            <flux:button variant="primary" wire:click="generate" wire:loading.attr="disabled">
                {{ __('Generate audio') }}
            </flux:button>
            @if ($error)
                <flux:callout variant="danger" :heading="$error" />
            @endif
        </flux:card>

        @if ($publicUrl)
            <flux:card class="border-zinc-800 bg-zinc-900/50 p-4">
                <audio controls src="{{ $publicUrl }}" class="w-full"></audio>
                <p class="mt-2 text-xs text-zinc-500"><code>{{ $path }}</code></p>
            </flux:card>
        @endif
    </div>
</x-ai.demo-shell>
