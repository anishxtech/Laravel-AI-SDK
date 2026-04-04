<?php

namespace App\Livewire\Ai;

use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Streaming')]
class StreamDemo extends Component
{
    public string $query = 'List three cool things about Laravel in one sentence each.';

    public function render()
    {
        return view('livewire.ai.stream-demo')
            ->layout('layouts.app', [
                'title' => __('Streaming'),
            ]);
    }
}
