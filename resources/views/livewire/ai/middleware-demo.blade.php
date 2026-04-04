<x-ai.demo-shell
    :title="__('Agent middleware')"
    :subtitle="__('LogAiPrompt logs a preview to the default log channel. For SDK-wide events (PromptingAgent, EmbeddingsGenerated, …), see ai-sdk topic 34.')"
>
    <div class="mx-auto max-w-2xl space-y-6">
        <flux:card class="space-y-4 border-zinc-800 bg-zinc-900/50 p-4">
            <flux:textarea wire:model="input" rows="3" label="{{ __('Prompt') }}" class="border-zinc-700 bg-zinc-900" />
            <flux:button variant="primary" wire:click="run" wire:loading.attr="disabled">
                {{ __('Run') }}
            </flux:button>
            @if ($error)
                <flux:callout variant="danger" :heading="$error" />
            @endif
        </flux:card>

        @if ($output)
            <flux:card class="border-zinc-800 bg-zinc-900/50 p-4 text-sm text-zinc-300">{{ $output }}</flux:card>
        @endif
    </div>
</x-ai.demo-shell>
