<?php

namespace App\Livewire\Ai;

use App\Ai\Agents\ToolsShowcaseAgent;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Tools')]
class ToolsDemo extends Component
{
    public string $input = 'What Laravel version is this application running?';

    public ?string $output = null;

    public bool $busy = false;

    public function run(): void
    {
        $this->busy = true;
        $this->output = null;

        try {
            $this->output = (string) (new ToolsShowcaseAgent)->prompt($this->input);
        } catch (\Throwable $e) {
            $this->addError('input', $e->getMessage());
        }

        $this->busy = false;
    }

    public function render()
    {
        return view('livewire.ai.tools-demo')
            ->layout('layouts.app', [
                'title' => __('Tools'),
            ]);
    }
}
