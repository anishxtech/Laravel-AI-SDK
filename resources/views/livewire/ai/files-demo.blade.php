<x-ai.demo-shell
    :title="__('Provider files')"
    :subtitle="__('Document::put then prompt with Document::fromId — avoids re-uploading large files.')"
>
    <div class="mx-auto max-w-2xl space-y-6">
        <flux:card class="space-y-4 border-zinc-800 bg-zinc-900/50 p-4">
            <flux:textarea wire:model="content" rows="4" label="{{ __('Text to upload') }}" class="border-zinc-700 bg-zinc-900" />
            <flux:button variant="primary" wire:click="uploadAndSummarize" wire:loading.attr="disabled">
                {{ __('Upload & summarize') }}
            </flux:button>
            @if ($error)
                <flux:callout variant="danger" :heading="$error" />
            @endif
            @if ($fileId)
                <flux:text class="text-sm text-zinc-400">{{ __('Provider file id') }}: <code class="text-zinc-300">{{ $fileId }}</code></flux:text>
            @endif
            @if ($summary)
                <div class="rounded-lg bg-zinc-900 p-3 text-sm text-zinc-300 ring-1 ring-zinc-800">{{ $summary }}</div>
            @endif
        </flux:card>
    </div>
</x-ai.demo-shell>
