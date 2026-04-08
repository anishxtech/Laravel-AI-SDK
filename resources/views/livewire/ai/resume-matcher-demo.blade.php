<x-ai.demo-shell
    :title="__('Resume + Job Matching Engine')"
    :subtitle="__('Parses resume and job descriptions, creates embeddings, scores by vector similarity, reranks, and explains skill gaps.')"
>
    <div class="mx-auto max-w-5xl space-y-6">
        <flux:card class="space-y-4 border-zinc-800 bg-zinc-900/50 p-4">
            <div class="grid gap-4 md:grid-cols-2">
                <flux:input
                    wire:model="sourceLabel"
                    label="{{ __('Candidate label') }}"
                    class="border-zinc-700 bg-zinc-900"
                    placeholder="Candidate name or source"
                />
                <div class="text-xs text-zinc-500 md:pt-7">
                    {{ __('Separate multiple jobs using a line with ---') }}
                </div>
            </div>

            <div class="grid gap-4 lg:grid-cols-2">
                <flux:textarea
                    wire:model="resumeText"
                    rows="14"
                    label="{{ __('Resume text') }}"
                    class="border-zinc-700 bg-zinc-900"
                />
                <flux:textarea
                    wire:model="jobDescriptions"
                    rows="14"
                    label="{{ __('Job descriptions') }}"
                    class="border-zinc-700 bg-zinc-900"
                />
            </div>

            <flux:button variant="primary" wire:click="run" wire:loading.attr="disabled">
                {{ __('Run matching engine') }}
            </flux:button>

            @if ($resumeProfileId)
                <p class="text-xs text-zinc-500">
                    {{ __('Stored resume profile ID: :id', ['id' => $resumeProfileId]) }}
                </p>
            @endif

            @if ($error)
                <flux:callout variant="danger" :heading="$error" />
            @endif
        </flux:card>

        @if (count($matches) > 0)
            <div class="space-y-4">
                @foreach ($matches as $index => $match)
                    <flux:card class="space-y-3 border-zinc-800 bg-zinc-900/50 p-4">
                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                            <h3 class="text-sm font-semibold text-zinc-100">
                                #{{ $index + 1 }} {{ $match['job_title'] }}
                            </h3>
                            <div class="text-xs text-zinc-300">
                                <span class="rounded bg-zinc-800 px-2 py-1">{{ __('Match: :score%', ['score' => $match['match_score']]) }}</span>
                                <span class="ml-2 rounded bg-zinc-800 px-2 py-1">{{ __('Cosine: :score%', ['score' => $match['cosine_similarity']]) }}</span>
                                @if ($match['rerank_score'] !== null)
                                    <span class="ml-2 rounded bg-zinc-800 px-2 py-1">{{ __('Rerank: :score%', ['score' => $match['rerank_score']]) }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <p class="mb-1 text-xs uppercase tracking-wide text-zinc-500">{{ __('Strengths') }}</p>
                                <p class="text-sm text-zinc-300">
                                    {{ count($match['strengths']) > 0 ? implode(', ', $match['strengths']) : __('No strong overlap detected') }}
                                </p>
                            </div>
                            <div>
                                <p class="mb-1 text-xs uppercase tracking-wide text-zinc-500">{{ __('Missing skills') }}</p>
                                <p class="text-sm text-zinc-300">
                                    {{ count($match['missing_skills']) > 0 ? implode(', ', $match['missing_skills']) : __('No major hard-skill gaps') }}
                                </p>
                            </div>
                        </div>

                        <div class="rounded border border-zinc-800 bg-zinc-950 p-3 text-sm whitespace-pre-wrap text-zinc-300">{{ $match['gap_summary'] }}</div>
                    </flux:card>
                @endforeach
            </div>
        @endif
    </div>
</x-ai.demo-shell>
