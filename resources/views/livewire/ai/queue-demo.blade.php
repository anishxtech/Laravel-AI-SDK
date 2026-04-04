<div
    class="mx-auto max-w-2xl space-y-6 p-6"
    @if ($waitingForQueue)
        wire:poll.1s="checkQueueResult"
    @endif
>
        <div>
            <flux:heading size="lg">{{ __('Queued agent') }}</flux:heading>
            <flux:text class="mt-1 text-zinc-600 dark:text-zinc-400">
                {{ __('Uses queue() with a then callback that stores the result in cache. Run ') }}
                <code class="rounded bg-zinc-200 px-1 text-xs dark:bg-zinc-700">php artisan queue:work</code>
                {{ __(' (or set QUEUE_CONNECTION=sync for instant local runs).') }}
            </flux:text>
        </div>

        <flux:card class="space-y-4 p-4">
            <flux:textarea wire:model="input" rows="3" label="{{ __('Prompt') }}" />
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
            <flux:card class="p-4 text-sm whitespace-pre-wrap">{{ $queueResult }}</flux:card>
        @endif
</div>
