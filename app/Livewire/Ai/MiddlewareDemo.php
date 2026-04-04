<?php

namespace App\Livewire\Ai;

use App\Ai\Agents\MiddlewareShowcaseAgent;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Agent middleware')]
class MiddlewareDemo extends Component
{
    public string $input = 'What is a service provider in Laravel?';

    public ?string $output = null;

    public ?string $error = null;

    public bool $busy = false;

    public function run(): void
    {
        $this->busy = true;
        $this->output = null;
        $this->error = null;

        try {
            $this->output = (string) (new MiddlewareShowcaseAgent)->prompt($this->input);
        } catch (\Throwable $e) {
            $this->error = $e->getMessage();
        }

        $this->busy = false;
    }

    public function render()
    {
        return view('livewire.ai.middleware-demo')
            ->layout('layouts.app', [
                'title' => __('Agent middleware'),
            ]);
    }
}
