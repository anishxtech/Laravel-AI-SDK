<div class="mx-auto max-w-2xl space-y-6 p-6">
        <div>
            <flux:heading size="lg">{{ __('Structured output') }}</flux:heading>
            <flux:text class="mt-1 text-zinc-600 dark:text-zinc-400">
                {{ __('Demonstrates HasStructuredOutput: summary, sentiment, confidence.') }}
            </flux:text>
        </div>

        <flux:card class="space-y-4 p-4">
            <flux:textarea wire:model="input" rows="4" label="{{ __('Text') }}" />
            <flux:button variant="primary" wire:click="analyze" wire:loading.attr="disabled">
                {{ __('Analyze') }}
            </flux:button>
            @error('input')
                <flux:callout variant="danger" :heading="$message" />
            @enderror
        </flux:card>

        @if ($result)
            <flux:card class="space-y-2 p-4">
                <flux:heading size="sm">{{ __('Result') }}</flux:heading>
                <pre class="overflow-x-auto rounded-lg bg-zinc-100 p-3 text-sm dark:bg-zinc-900">{{ json_encode($result, JSON_PRETTY_PRINT) }}</pre>
            </flux:card>
        @endif
</div>
