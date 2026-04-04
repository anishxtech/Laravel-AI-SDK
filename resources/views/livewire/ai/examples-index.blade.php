<div class="mx-auto max-w-4xl space-y-8 p-6">
        <div>
            <flux:heading size="xl">{{ __('Laravel AI SDK examples') }}</flux:heading>
            <flux:text class="mt-2 text-zinc-600 dark:text-zinc-400">
                {{ __('Each page demonstrates a small part of the SDK. Configure API keys in .env (see ai-sdk/README.md).') }}
            </flux:text>
        </div>

        <div class="space-y-3">
            @foreach ($this->rows() as $row)
                <flux:card class="p-4">
                    <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                        <div>
                            <flux:link :href="route($row['route'])" wire:navigate class="font-medium text-zinc-900 dark:text-white">
                                {{ $row['title'] }}
                            </flux:link>
                            <p class="mt-1 text-sm text-zinc-500 dark:text-zinc-400">{{ $row['description'] }}</p>
                        </div>
                        <div class="text-right text-sm">
                            <code class="rounded bg-zinc-100 px-1.5 py-0.5 text-xs dark:bg-zinc-800">{{ $row['path'] }}</code>
                            <p class="mt-1 text-xs text-zinc-500">{{ $row['keys'] }}</p>
                        </div>
                    </div>
                </flux:card>
            @endforeach
        </div>
</div>
