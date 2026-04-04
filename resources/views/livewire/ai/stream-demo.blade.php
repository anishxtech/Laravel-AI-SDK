<div class="mx-auto max-w-2xl space-y-6 p-6">
        <div>
            <flux:heading size="lg">{{ __('Streaming (SSE)') }}</flux:heading>
            <flux:text class="mt-1 text-zinc-600 dark:text-zinc-400">
                {{ __('These routes return StreamableAgentResponse for the browser or API clients. You must be logged in.') }}
            </flux:text>
        </div>

        <flux:card class="space-y-4 p-4">
            <flux:input wire:model="query" name="q" label="{{ __('Query (q)') }}" />
            <div class="flex flex-wrap gap-2">
                <a
                    href="{{ route('ai.stream.sse', ['q' => $query]) }}"
                    target="_blank"
                    rel="noopener"
                    class="inline-flex items-center justify-center rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white hover:bg-indigo-500"
                >
                    {{ __('Open SSE stream') }}
                </a>
                <a
                    href="{{ route('ai.stream.vercel', ['q' => $query]) }}"
                    target="_blank"
                    rel="noopener"
                    class="inline-flex items-center justify-center rounded-lg border border-zinc-600 px-4 py-2 text-sm font-medium text-zinc-200 hover:bg-zinc-800"
                >
                    {{ __('Open Vercel protocol stream') }}
                </a>
            </div>
        </flux:card>
</div>
