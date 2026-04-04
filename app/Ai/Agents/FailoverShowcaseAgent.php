<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Promptable;
use Stringable;

class FailoverShowcaseAgent implements Agent
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return 'You answer in one or two sentences.';
    }
}
