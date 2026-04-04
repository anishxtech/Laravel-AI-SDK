<?php

namespace App\Livewire\Ai;

use Laravel\Ai\Embeddings;
use Laravel\Ai\Reranking;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Embeddings & reranking')]
class EmbeddingsDemo extends Component
{
    public string $embedInput = "Laravel is a PHP framework.\nVue is a JavaScript framework.\nPostgreSQL is a database.";

    public ?array $embeddingPreview = null;

    public string $rerankCandidates = "Django is a Python framework.\nLaravel is a PHP web framework.\nReact builds UIs.";

    public string $rerankQuery = 'PHP web frameworks';

    public ?array $rerankResults = null;

    public ?string $error = null;

    public bool $busy = false;

    /** When true, chains ->cache() on the embedding request (see ai-sdk topic 30). */
    public bool $useEmbeddingCache = false;

    public function embed(): void
    {
        $this->busy = true;
        $this->error = null;
        $this->embeddingPreview = null;

        try {
            $lines = array_values(array_filter(array_map('trim', explode("\n", $this->embedInput))));
            $builder = Embeddings::for($lines);
            if ($this->useEmbeddingCache) {
                $builder = $builder->cache();
            }
            $response = $builder->generate();
            $first = $response->embeddings[0] ?? [];
            $this->embeddingPreview = [
                'vectors' => count($response->embeddings),
                'dimensions' => count($first),
                'first_vector_preview' => array_slice($first, 0, 8),
            ];
        } catch (\Throwable $e) {
            $this->error = $e->getMessage();
        }

        $this->busy = false;
    }

    public function rerank(): void
    {
        $this->busy = true;
        $this->error = null;
        $this->rerankResults = null;

        try {
            $docs = array_values(array_filter(array_map('trim', explode("\n", $this->rerankCandidates))));
            $response = Reranking::of($docs)->limit(5)->rerank($this->rerankQuery);
            $this->rerankResults = $response->collect()->map(fn ($r) => [
                'score' => $r->score,
                'index' => $r->index,
                'document' => $r->document,
            ])->all();
        } catch (\Throwable $e) {
            $this->error = $e->getMessage();
        }

        $this->busy = false;
    }

    public function render()
    {
        return view('livewire.ai.embeddings-demo')
            ->layout('layouts.app', [
                'title' => __('Embeddings & reranking'),
            ]);
    }
}
