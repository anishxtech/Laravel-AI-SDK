<?php

namespace App\Livewire\Ai;

use App\Ai\Agents\FailoverShowcaseAgent;
use Laravel\Ai\Enums\Lab;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Provider failover')]
class FailoverDemo extends Component
{
    public string $input = 'Reply with the word "ok" only.';

    public ?string $output = null;

    public ?string $error = null;

    public bool $busy = false;

    public function run(): void
    {
        $this->busy = true;
        $this->output = null;
        $this->error = null;

        try {
            $this->output = (string) (new FailoverShowcaseAgent)->prompt(
                $this->input,
                provider: [Lab::Gemini, Lab::OpenAI],
            );
        } catch (\Throwable $e) {
            $this->error = $e->getMessage();
        }

        $this->busy = false;
    }

    public function render()
    {
        return view('livewire.ai.failover-demo')
            ->layout('layouts.app', [
                'title' => __('Provider failover'),
            ]);
    }
}
