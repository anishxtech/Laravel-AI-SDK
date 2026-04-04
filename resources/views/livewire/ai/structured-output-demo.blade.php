<x-ai.demo-shell
    :title="__('Structured output')"
    :subtitle="__('HasStructuredOutput — summary, sentiment, and confidence as JSON.')"
>
    <div class="mx-auto max-w-2xl space-y-6">
        <flux:card class="space-y-4 border-zinc-800 bg-zinc-900/50 p-4">
            <flux:textarea wire:model="input" rows="4" label="{{ __('Text') }}" class="border-zinc-700 bg-zinc-900" />
            <flux:button variant="primary" wire:click="analyze" wire:loading.attr="disabled">
                {{ __('Analyze') }}
            </flux:button>
            @error('input')
                <flux:callout variant="danger" :heading="$message" />
            @enderror
        </flux:card>

        @if ($result)
            <flux:card class="space-y-2 border-zinc-800 bg-zinc-900/50 p-4">
                <flux:heading size="sm" class="text-zinc-200">{{ __('Result') }}</flux:heading>
                <pre class="overflow-x-auto rounded-lg bg-zinc-900 p-3 text-sm text-zinc-300 ring-1 ring-zinc-800">{{ json_encode($result, JSON_PRETTY_PRINT) }}</pre>
            </flux:card>
        @endif
    </div>
</x-ai.demo-shell>
