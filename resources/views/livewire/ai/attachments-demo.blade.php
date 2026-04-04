<x-ai.demo-shell
    :title="__('Attachments')"
    :subtitle="__('Upload a text-oriented file or image. The agent receives Files\\Document or Files\\Image.')"
>
    <div class="mx-auto max-w-2xl space-y-6">
        <flux:card class="space-y-4 border-zinc-800 bg-zinc-900/50 p-4">
            <flux:input type="file" wire:model="file" label="{{ __('File') }}" />
            <div wire:loading wire:target="file" class="text-sm text-zinc-500">{{ __('Uploading…') }}</div>
            <flux:textarea wire:model="prompt" rows="2" label="{{ __('Prompt') }}" class="border-zinc-700 bg-zinc-900" />
            <flux:button variant="primary" wire:click="analyze" wire:loading.attr="disabled">
                {{ __('Analyze') }}
            </flux:button>
            @error('file')
                <flux:callout variant="danger" :heading="$message" />
            @enderror
        </flux:card>

        @if ($output)
            <flux:card class="whitespace-pre-wrap border-zinc-800 bg-zinc-900/50 p-4 text-sm text-zinc-300">{{ $output }}</flux:card>
        @endif
    </div>
</x-ai.demo-shell>
