<x-ai.demo-shell
    :title="__('Queued agent')"
    :subtitle="__('Uses queue() with a then callback that stores the result in cache. Run php artisan queue:work (or QUEUE_CONNECTION=sync for local).')"
>
    <div
        class="mx-auto max-w-2xl space-y-6"
        @if ($waitingForQueue)
            wire:poll.1s="checkQueueResult"
        @endif
    >
        <flux:card class="space-y-4 border-zinc-800 bg-zinc-900/50 p-4">
            <flux:textarea wire:model="input" rows="3" label="{{ __('Prompt') }}" class="border-zinc-700 bg-zinc-900" />
            <flux:button variant="primary" wire:click="runQueuedPrompt" wire:loading.attr="disabled">
                {{ __('Queue prompt') }}
            </flux:button>
            @if ($waitingForQueue)
                <flux:text variant="subtle">{{ __('Waiting for worker…') }}</flux:text>
            @endif
            @error('input')
                <flux:callout variant="danger" :heading="$message" />
            @enderror
        </flux:card>

        @if ($queueResult)
            <flux:card class="whitespace-pre-wrap border-zinc-800 bg-zinc-900/50 p-4 text-sm text-zinc-300">{{ $queueResult }}</flux:card>
        @endif
    </div>
</x-ai.demo-shell>
