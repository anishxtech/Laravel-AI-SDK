<x-ai.demo-shell
    :title="__('Streaming (SSE & Vercel)')"
    :subtitle="__('Opens StreamShowcaseAgent streams in a new tab. Broadcasting streamed chunks to channels (Reverb, Pusher, etc.) is documented in ai-sdk topic 13.')"
>
    <div class="mx-auto max-w-2xl space-y-6">
        <div class="rounded-lg border border-zinc-700 bg-zinc-900/80 p-4 text-sm text-zinc-300">
            {{ __('Broadcasting: iterate the stream and call $event->broadcast(...) or use broadcastOnQueue() with a configured broadcasting driver.') }}
        </div>

        <flux:card class="space-y-4 border-zinc-800 bg-zinc-900/50 p-4">
            <flux:input wire:model="query" name="q" label="{{ __('Query (q)') }}" class="border-zinc-700 bg-zinc-900" />
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
</x-ai.demo-shell>
