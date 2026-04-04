<?php

namespace App\Livewire\Ai;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Laravel\Ai\Image;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Image generation')]
class ImageDemo extends Component
{
    public string $prompt = 'A friendly robot reading the Laravel documentation, flat vector art.';

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
            $image = Image::of($this->prompt)->landscape()->timeout(120)->generate();
            $this->path = $image->storePubliclyAs('ai-images', Str::uuid().'.png');
            $this->publicUrl = Storage::disk('public')->url($this->path);
        } catch (\Throwable $e) {
            $this->error = $e->getMessage();
        }

        $this->busy = false;
    }

    public function render()
    {
        return view('livewire.ai.image-demo')
            ->layout('layouts.app', [
                'title' => __('Image generation'),
            ]);
    }
}
