<x-ai.demo-shell
    :title="__('Image generation')"
    :subtitle="__('Uses Laravel\\Ai\\Image. Default image provider comes from config/ai.php. Failover: Image::generate(provider: […]).')"
>
    <div class="mx-auto max-w-2xl space-y-6">
        <flux:card class="space-y-4 border-zinc-800 bg-zinc-900/50 p-4">
            <flux:textarea wire:model="prompt" rows="3" label="{{ __('Prompt') }}" class="border-zinc-700 bg-zinc-900" />
            <flux:button variant="primary" wire:click="generate" wire:loading.attr="disabled">
                {{ __('Generate') }}
            </flux:button>
            @if ($error)
                <flux:callout variant="danger" :heading="$error" />
            @endif
        </flux:card>

        @if ($path)
            <flux:card class="border-zinc-800 bg-zinc-900/50 p-4">
                <flux:text class="mb-2 text-sm text-zinc-400">{{ __('Stored at') }}: <code class="text-zinc-300">{{ $path }}</code></flux:text>
                <img src="{{ $publicUrl }}" alt="" class="max-h-96 rounded-lg border border-zinc-700" />
            </flux:card>
        @endif
    </div>
</x-ai.demo-shell>
