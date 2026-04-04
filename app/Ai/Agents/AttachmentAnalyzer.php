<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Promptable;
use Stringable;

class AttachmentAnalyzer implements Agent
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return 'You summarize uploaded files. Use clear bullet points. If the file is an image, describe what is relevant for a developer.';
    }
}
