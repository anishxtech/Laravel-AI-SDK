<?php

namespace App\Livewire\Ai;

use App\Ai\Agents\AttachmentAnalyzer;
use Laravel\Ai\Files;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

#[Title('Attachments')]
class AttachmentsDemo extends Component
{
    use WithFileUploads;

    public $file;

    public string $prompt = 'Summarize this for a developer.';

    public ?string $output = null;

    public bool $busy = false;

    public function analyze(): void
    {
        $this->validate([
            'file' => 'required|file|max:10240',
            'prompt' => 'required|string|max:2000',
        ]);

        $this->busy = true;
        $this->output = null;

        try {
            $mime = $this->file->getMimeType() ?? '';
            $attachments = str_starts_with((string) $mime, 'image/')
                ? [Files\Image::fromUpload($this->file)]
                : [Files\Document::fromUpload($this->file)];

            $this->output = (string) (new AttachmentAnalyzer)->prompt($this->prompt, attachments: $attachments);
        } catch (\Throwable $e) {
            $this->addError('file', $e->getMessage());
        }

        $this->busy = false;
    }

    public function render()
    {
        return view('livewire.ai.attachments-demo')
            ->layout('layouts.app', [
                'title' => __('Attachments'),
            ]);
    }
}
