<x-ai.demo-shell
    :title="__('Anonymous agent')"
    :subtitle="__('Uses the agent() helper without a dedicated Agent class. Agent PHP attributes are covered in the ai-sdk topic 22 docs.')"
>
    <div class="mx-auto max-w-2xl space-y-6">
        <flux:card class="space-y-4 border-zinc-800 bg-zinc-900/50 p-4">
            <flux:textarea wire:model="input" rows="3" label="{{ __('Prompt') }}" class="border-zinc-700 bg-zinc-900" />
            <flux:button variant="primary" wire:click="ask" wire:loading.attr="disabled">
                {{ __('Ask') }}
            </flux:button>
            @error('input')
                <flux:callout variant="danger" :heading="$message" />
            @enderror
        </flux:card>

        @if ($output)
            <flux:card class="border-zinc-800 bg-zinc-900/50 p-4 text-sm text-zinc-300">{{ $output }}</flux:card>
        @endif
    </div>
</x-ai.demo-shell>
