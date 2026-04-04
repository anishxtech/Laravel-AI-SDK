<div class="mx-auto max-w-2xl space-y-6 p-6">
        <div>
            <flux:heading size="lg">{{ __('Transcription') }}</flux:heading>
            <flux:text class="mt-1 text-zinc-600 dark:text-zinc-400">
                {{ __('Upload a short audio file. Uses Laravel\\Ai\\Transcription.') }}
            </flux:text>
        </div>

        <flux:card class="space-y-4 p-4">
            <flux:input type="file" wire:model="audio" label="{{ __('Audio file') }}" />
            <flux:button variant="primary" wire:click="transcribe" wire:loading.attr="disabled">
                {{ __('Transcribe') }}
            </flux:button>
            @if ($error)
                <flux:callout variant="danger" :heading="$error" />
            @endif
        </flux:card>

        @if ($transcript)
            <flux:card class="p-4 text-sm whitespace-pre-wrap">{{ $transcript }}</flux:card>
        @endif
</div>
