<x-ai.demo-shell
    :title="__('Transcription')"
    :subtitle="__('Upload a short audio file. Uses Laravel\\Ai\\Transcription (optionally diarize() in code).')"
>
    <div class="mx-auto max-w-2xl space-y-6">
        <flux:card class="space-y-4 border-zinc-800 bg-zinc-900/50 p-4">
            <flux:input type="file" wire:model="audio" label="{{ __('Audio file') }}" />
            <flux:button variant="primary" wire:click="transcribe" wire:loading.attr="disabled">
                {{ __('Transcribe') }}
            </flux:button>
            @if ($error)
                <flux:callout variant="danger" :heading="$error" />
            @endif
        </flux:card>

        @if ($transcript)
            <flux:card class="whitespace-pre-wrap border-zinc-800 bg-zinc-900/50 p-4 text-sm text-zinc-300">{{ $transcript }}</flux:card>
        @endif
    </div>
</x-ai.demo-shell>
