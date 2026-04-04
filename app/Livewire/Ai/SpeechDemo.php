<?php

namespace App\Livewire\Ai;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Ai\Audio;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Text to speech')]
class SpeechDemo extends Component
{
    public string $text = 'Laravel makes building web applications enjoyable.';

    public ?string $path = null;

    public ?string $publicUrl = null;

    public ?string $error = null;

    public bool $busy = false;

    public function generate(): void
    {
        $this->busy = true;
        $this->error = null;
        $this->path = null;
        $this->publicUrl = null;

        try {
            $audio = Audio::of($this->text)->timeout(120)->generate();
            $this->path = $audio->storePubliclyAs('ai-audio', Str::uuid().'.mp3');
            $this->publicUrl = Storage::disk('public')->url($this->path);
        } catch (\Throwable $e) {
            $this->error = $e->getMessage();
        }

        $this->busy = false;
    }

    public function render()
    {
        return view('livewire.ai.speech-demo')
            ->layout('layouts.app', [
                'title' => __('Text to speech'),
            ]);
    }
}
