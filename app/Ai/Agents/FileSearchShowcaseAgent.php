<?php

namespace App\Ai\Agents;

use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Contracts\HasTools;
use Laravel\Ai\Promptable;
use Laravel\Ai\Providers\Tools\FileSearch;
use Stringable;

class FileSearchShowcaseAgent implements Agent, HasTools
{
    use Promptable;

    public function instructions(): Stringable|string
    {
        return 'Answer using the file search tool against the configured vector store. Cite retrieved facts briefly. If you cannot find an answer, say so.';
    }

    public function tools(): iterable
    {
        $storeId = config('services.ai.openai_vector_store_id');

        if (! filled($storeId)) {
            return [];
        }

        return [
            new FileSearch(stores: [$storeId]),
        ];
    }
}
