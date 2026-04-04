<?php

namespace App\Livewire\Ai;

use Livewire\Attributes\Title;
use Livewire\Component;

use function Laravel\Ai\agent;

#[Title('Anonymous agent')]
class QuickAskDemo extends Component
{
    public string $input = 'What is Eloquent?';

    public ?string $output = null;

    public bool $busy = false;

    public function ask(): void
    {
        $this->busy = true;
        $this->output = null;

        try {
            $this->output = (string) agent(
                instructions: 'You are a Laravel tutor. Answer in under 120 words.',
            )->prompt($this->input);
        } catch (\Throwable $e) {
            $this->addError('input', $e->getMessage());
        }

        $this->busy = false;
    }

    public function render()
    {
        return view('livewire.ai.quick-ask-demo')
            ->layout('layouts.app', [
                'title' => __('Anonymous agent'),
            ]);
    }
}
