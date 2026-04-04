<?php

namespace App\Livewire\Ai;

use App\Ai\Agents\AttachmentAnalyzer;
use Laravel\Ai\Files\Document;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Provider files')]
class FilesDemo extends Component
{
    public string $content = 'This is a tiny document stored with the AI provider, then attached by ID.';

    public ?string $fileId = null;

    public ?string $summary = null;

    public ?string $error = null;

    public bool $busy = false;

    public function uploadAndSummarize(): void
    {
        $this->busy = true;
        $this->error = null;
        $this->fileId = null;
        $this->summary = null;

        try {
            $stored = Document::fromString($this->content, 'text/plain')
                ->as('demo.txt')
                ->put();

            $this->fileId = $stored->id;

            $this->summary = (string) (new AttachmentAnalyzer)->prompt(
                'Summarize in one sentence.',
                attachments: [Document::fromId($stored->id)],
            );
        } catch (\Throwable $e) {
            $this->error = $e->getMessage();
        }

        $this->busy = false;
    }

    public function render()
    {
        return view('livewire.ai.files-demo')
            ->layout('layouts.app', [
                'title' => __('Provider files'),
            ]);
    }
}
