<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Promptable;
use Stringable;

class StreamShowcaseAgent implements Agent
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return 'You are a concise assistant. Keep answers brief unless the user asks for detail.';
    }
}
