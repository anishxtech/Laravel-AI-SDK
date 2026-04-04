<?php

namespace App\Livewire\Ai;

use App\Ai\Agents\SimilarityResearchAgent;
use App\Models\KnowledgeChunk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Laravel\Ai\Embeddings;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Similarity search')]
class SimilarityDemo extends Component
{
    public string $chunkTitle = 'Queues';

    public string $chunkContent = 'Laravel queues let you defer slow tasks to workers using Redis, database, or other drivers.';

    public string $question = 'How can I run work in the background?';

    public ?string $answer = null;

    public ?string $error = null;

    public bool $busy = false;

    public function supportsVectors(): bool
    {
        return DB::connection()->getDriverName() === 'pgsql'
            && Schema::hasTable('knowledge_chunks');
    }

    public function indexChunk(): void
    {
        if (! $this->supportsVectors()) {
            $this->addError('chunkContent', __('PostgreSQL with pgvector and the knowledge_chunks table is required.'));

            return;
        }

        $this->validate([
            'chunkTitle' => 'required|string|max:255',
            'chunkContent' => 'required|string|max:10000',
        ]);

        $this->busy = true;
        $this->error = null;

        try {
            $response = Embeddings::for([$this->chunkContent])->generate();
            KnowledgeChunk::query()->create([
                'title' => $this->chunkTitle,
                'content' => $this->chunkContent,
                'embedding' => $response->embeddings[0],
            ]);
        } catch (\Throwable $e) {
            $this->error = $e->getMessage();
        }

        $this->busy = false;
    }

    public function ask(): void
    {
        if (! $this->supportsVectors()) {
            $this->addError('question', __('PostgreSQL + pgvector required.'));

            return;
        }

        $this->busy = true;
        $this->answer = null;
        $this->error = null;

        try {
            $this->answer = (string) (new SimilarityResearchAgent)->prompt($this->question);
        } catch (\Throwable $e) {
            $this->error = $e->getMessage();
        }

        $this->busy = false;
    }

    public function render()
    {
        return view('livewire.ai.similarity-demo')
            ->layout('layouts.app', [
                'title' => __('Similarity search'),
            ]);
    }
}
