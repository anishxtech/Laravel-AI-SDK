<div class="mx-auto max-w-2xl space-y-6 p-6">
        <div>
            <flux:heading size="lg">{{ __('Attachments') }}</flux:heading>
            <flux:text class="mt-1 text-zinc-600 dark:text-zinc-400">
                {{ __('Upload a text-oriented file or image. The agent receives Files\\Document or Files\\Image.') }}
            </flux:text>
        </div>

        <flux:card class="space-y-4 p-4">
            <flux:input type="file" wire:model="file" label="{{ __('File') }}" />
            <div wire:loading wire:target="file" class="text-sm text-zinc-500">{{ __('Uploading…') }}</div>
            <flux:textarea wire:model="prompt" rows="2" label="{{ __('Prompt') }}" />
            <flux:button variant="primary" wire:click="analyze" wire:loading.attr="disabled">
                {{ __('Analyze') }}
            </flux:button>
            @error('file')
                <flux:callout variant="danger" :heading="$message" />
            @enderror
        </flux:card>

        @if ($output)
            <flux:card class="p-4 text-sm whitespace-pre-wrap">{{ $output }}</flux:card>
        @endif
</div>
