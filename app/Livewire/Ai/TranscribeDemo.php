<?php

namespace App\Livewire\Ai;

use Laravel\Ai\Transcription;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

#[Title('Transcription')]
class TranscribeDemo extends Component
{
    use WithFileUploads;

    public $audio;

    public ?string $transcript = null;

    public ?string $error = null;

    public bool $busy = false;

    public function transcribe(): void
    {
        $this->validate([
            'audio' => 'required|file|max:25600',
        ]);

        $this->busy = true;
        $this->error = null;
        $this->transcript = null;

        try {
            $this->transcript = (string) Transcription::fromUpload($this->audio)->generate();
        } catch (\Throwable $e) {
            $this->error = $e->getMessage();
        }

        $this->busy = false;
    }

    public function render()
    {
        return view('livewire.ai.transcribe-demo')
            ->layout('layouts.app', [
                'title' => __('Transcription'),
            ]);
    }
}
