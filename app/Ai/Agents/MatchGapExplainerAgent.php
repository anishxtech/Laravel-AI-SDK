<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Promptable;
use Stringable;

class MatchGapExplainerAgent implements Agent
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return 'You are a hiring copilot. Explain resume-job fit in short, practical language. Always return 3 sections with markdown headings: "Fit summary", "Strengths", and "Gaps to close". Keep total output under 120 words.';
    }
}
