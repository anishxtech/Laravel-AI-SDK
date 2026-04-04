<x-ai.demo-shell
    :title="__('AI SDK overview')"
    :subtitle="__('Each page below is also in the sidebar. Configure API keys in .env — see ai-sdk/README.md.')"
>
    <div class="mx-auto max-w-4xl space-y-4">
        <div class="space-y-3">
            @foreach ($this->rows() as $row)
                <flux:card class="border-zinc-800 bg-zinc-900/50 p-4">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <flux:link :href="route($row['route'])" wire:navigate class="font-medium text-zinc-100 hover:text-white">
                                {{ $row['title'] }}
                            </flux:link>
                            <p class="mt-1 text-sm text-zinc-500">{{ $row['description'] }}</p>
                        </div>
                        <div class="text-right text-sm">
                            <code class="rounded bg-zinc-800 px-1.5 py-0.5 text-xs text-zinc-300">{{ $row['path'] }}</code>
                            <p class="mt-1 text-xs text-zinc-500">{{ $row['keys'] }}</p>
                        </div>
                    </div>
                </flux:card>
            @endforeach
        </div>
    </div>
</x-ai.demo-shell>
