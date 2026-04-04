<?php

namespace App\Livewire\Ai;

use App\Ai\Agents\QueueShowcaseAgent;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Laravel\Ai\Responses\AgentResponse;
use Livewire\Attributes\Title;
use Livewire\Component;
use Throwable;

#[Title('Queued agent')]
class QueueDemo extends Component
{
    public string $input = 'Say hello in one sentence.';

    public ?string $queueToken = null;

    public bool $waitingForQueue = false;

    public ?string $queueResult = null;

    public function runQueuedPrompt(): void
    {
        $this->resetErrorBag();
        $this->queueResult = null;
        $token = (string) Str::uuid();
        $this->queueToken = $token;
        $this->waitingForQueue = true;

        try {
            (new QueueShowcaseAgent)->queue($this->input)
                ->then(function (AgentResponse $response) use ($token) {
                    Cache::put('ai_queue_demo:'.$token, (string) $response, now()->addMinutes(10));
                })
                ->catch(function (Throwable $e) use ($token) {
                    Cache::put('ai_queue_demo:'.$token, 'Error: '.$e->getMessage(), now()->addMinutes(10));
                });
        } catch (Throwable $e) {
            $this->waitingForQueue = false;
            $this->addError('input', $e->getMessage());
        }
    }

    public function checkQueueResult(): void
    {
        if (! $this->waitingForQueue || ! $this->queueToken) {
            return;
        }

        $key = 'ai_queue_demo:'.$this->queueToken;

        if (Cache::has($key)) {
            $this->queueResult = Cache::pull($key);
            $this->waitingForQueue = false;
        }
    }

    public function render()
    {
        return view('livewire.ai.queue-demo')
            ->layout('layouts.app', [
                'title' => __('Queued agent'),
            ]);
    }
}
