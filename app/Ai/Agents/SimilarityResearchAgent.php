<?php

namespace App\Ai\Agents;

use App\Models\KnowledgeChunk;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Promptable;
use Laravel\Ai\Tools\SimilaritySearch;
use Stringable;

class SimilarityResearchAgent implements Agent, HasTools
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return 'You answer questions using the similarity search tool to retrieve relevant stored chunks. Combine facts from retrieved snippets.';
    }

    public function tools(): iterable
    {
        return [
            SimilaritySearch::usingModel(KnowledgeChunk::class, 'embedding', minSimilarity: 0.2, limit: 8)
                ->withDescription('Search indexed knowledge chunks by meaning.'),
        ];
    }
}
