<?php

namespace App\Livewire\Ai;

use Laravel\Ai\Files\Document;
use Laravel\Ai\Stores;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Vector stores')]
class StoresDemo extends Component
{
    public string $name = 'Demo knowledge';

    public string $content = 'Laravel queues process jobs in the background.';

    public ?string $storeId = null;

    public ?string $documentNote = null;

    public ?string $error = null;

    public bool $busy = false;

    public function createAndAdd(): void
    {
        $this->busy = true;
        $this->error = null;
        $this->storeId = null;
        $this->documentNote = null;

        try {
            $store = Stores::create($this->name);
            $this->storeId = $store->id;

            $doc = $store->add(
                Document::fromString($this->content, 'text/plain')->as('chunk.txt'),
            );

            $this->documentNote = __('Store document id: :doc, underlying file id: :file', [
                'doc' => $doc->id,
                'file' => $doc->fileId ?? '—',
            ]);
        } catch (\Throwable $e) {
            $this->error = $e->getMessage();
        }

        $this->busy = false;
    }

    public function render()
    {
        return view('livewire.ai.stores-demo')
            ->layout('layouts.app', [
                'title' => __('Vector stores'),
            ]);
    }
}
