<?php

namespace App\Livewire\Ai;

use App\Ai\Agents\StructuredAnalyzer;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Structured output')]
class StructuredOutputDemo extends Component
{
    public string $input = 'Laravel queues make background work reliable.';

    public ?array $result = null;

    public bool $busy = false;

    public function analyze(): void
    {
        $this->busy = true;
        $this->result = null;

        try {
            $response = (new StructuredAnalyzer)->prompt($this->input);
            $this->result = [
                'summary' => $response['summary'],
                'sentiment' => $response['sentiment'],
                'confidence' => $response['confidence'],
            ];
        } catch (\Throwable $e) {
            $this->addError('input', $e->getMessage());
        }

        $this->busy = false;
    }

    public function render()
    {
        return view('livewire.ai.structured-output-demo')
            ->layout('layouts.app', [
                'title' => __('Structured output'),
            ]);
    }
}
