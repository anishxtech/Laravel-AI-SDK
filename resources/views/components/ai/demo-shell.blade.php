@props([
    'title',
    'subtitle' => null,
])

<div {{ $attributes->class('flex min-h-[calc(100vh-9rem)] flex-col overflow-hidden rounded-xl border border-zinc-800 bg-zinc-950 text-zinc-100 shadow-sm') }}>
    <header class="flex shrink-0 items-start justify-between gap-4 border-b border-zinc-800 px-5 py-4">
        <div class="flex min-w-0 items-start gap-3">
            <div
                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-zinc-600 bg-zinc-800"
                aria-hidden="true"
            >
                <svg class="h-5 w-5 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"
                    />
                </svg>
            </div>
            <div class="min-w-0">
                <h1 class="truncate text-base font-semibold leading-tight text-zinc-100">{{ $title }}</h1>
                @if ($subtitle)
                    <p class="mt-1 text-xs leading-relaxed text-zinc-500">{{ $subtitle }}</p>
                @endif
            </div>
        </div>
        @isset($actions)
            <div class="flex shrink-0 items-center gap-2">
                {{ $actions }}
            </div>
        @endisset
    </header>

    <div class="min-h-0 flex-1 overflow-y-auto px-5 py-5">
        {{ $slot }}
    </div>
</div>
