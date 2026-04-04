<?php

namespace App\Livewire\Ai;

use App\Ai\Agents\FileSearchShowcaseAgent;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('File search tool')]
class FileSearchDemo extends Component
{
    public string $input = 'What topics are covered in the uploaded documentation?';

    public ?string $output = null;

    public bool $busy = false;

    public function ask(): void
    {
        $this->busy = true;
        $this->output = null;

        if (! filled(config('services.ai.openai_vector_store_id'))) {
            $this->addError('input', __('Set OPENAI_VECTOR_STORE_ID in .env and add files to that store in the OpenAI dashboard.'));
            $this->busy = false;

            return;
        }

        try {
            $this->output = (string) (new FileSearchShowcaseAgent)->prompt($this->input);
        } catch (\Throwable $e) {
            $this->addError('input', $e->getMessage());
        }

        $this->busy = false;
    }

    public function render()
    {
        return view('livewire.ai.file-search-demo')
            ->layout('layouts.app', [
                'title' => __('File search'),
            ]);
    }
}
