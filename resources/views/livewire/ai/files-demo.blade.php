<div class="mx-auto max-w-2xl space-y-6 p-6">
        <div>
            <flux:heading size="lg">{{ __('Provider files') }}</flux:heading>
            <flux:text class="mt-1 text-zinc-600 dark:text-zinc-400">
                {{ __('Document::put then prompt with Document::fromId — avoids re-uploading large files.') }}
            </flux:text>
        </div>

        <flux:card class="space-y-4 p-4">
            <flux:textarea wire:model="content" rows="4" label="{{ __('Text to upload') }}" />
            <flux:button variant="primary" wire:click="uploadAndSummarize" wire:loading.attr="disabled">
                {{ __('Upload & summarize') }}
            </flux:button>
            @if ($error)
                <flux:callout variant="danger" :heading="$error" />
            @endif
            @if ($fileId)
                <flux:text class="text-sm">{{ __('Provider file id') }}: <code>{{ $fileId }}</code></flux:text>
            @endif
            @if ($summary)
                <flux:card class="bg-zinc-50 p-3 text-sm dark:bg-zinc-900">{{ $summary }}</flux:card>
            @endif
        </flux:card>
</div>
