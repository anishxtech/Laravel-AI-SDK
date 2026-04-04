<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Promptable;
use Stringable;

class QueueShowcaseAgent implements Agent
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return 'Reply with one short paragraph.';
    }
}
