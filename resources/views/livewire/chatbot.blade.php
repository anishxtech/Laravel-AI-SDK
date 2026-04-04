<div x-data="{ autoScroll: true }" x-on:message-added.window="
        $nextTick(() => {
            if (autoScroll) {
                const el = $refs.messages;
                el.scrollTop = el.scrollHeight;
            }
        })
    " class="flex flex-col h-screen bg-zinc-950">

    {{-- Header --}}
    <div class="bg-zinc-900 border-b border-zinc-800 px-6 py-4 flex-shrink-0">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                {{-- AI Avatar --}}
                <div
                    class="w-9 h-9 rounded-full bg-zinc-700 border border-zinc-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                        stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z" />
                    </svg>
                </div>
                <div>
                    <h1 class="text-zinc-100 font-semibold text-base leading-tight">Laravel Assistant</h1>
                    <p class="text-zinc-500 text-xs">Powered by Laravel AI SDK</p>
                </div>
            </div>
            <button wire:click="clearConversation"
                class="text-zinc-500 hover:text-zinc-300 text-xs transition-colors px-3 py-1.5 rounded-lg hover:bg-zinc-800">
                New chat
            </button>
        </div>
    </div>

    {{-- Messages --}}
    <div x-ref="messages" x-on:scroll="autoScroll = ($el.scrollTop + $el.clientHeight >= $el.scrollHeight - 50)"
        class="flex-1 overflow-y-auto px-4 py-6">

    @if(empty($messages))
            {{-- Empty State --}}
            <div class="flex flex-col items-center justify-center h-full gap-4 text-center px-4">
                <div class="w-14 h-14 rounded-2xl bg-zinc-800 border border-zinc-700 flex items-center justify-center">
                    <svg class="w-7 h-7 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-zinc-200 font-medium text-lg">Laravel Assistant</h2>
                    <p class="text-zinc-500 text-sm mt-1 max-w-xs">
                        Ask me anything about Laravel, Livewire, Eloquent, Filament, or any part of the PHP ecosystem.
                    </p>
                </div>
                {{-- Suggestion chips --}}
                <div class="flex flex-wrap gap-2 justify-center mt-2">
                    @foreach([
                        'How do I use Eloquent scopes?',
                        'Explain Laravel queues simply',
                        'What is new in Laravel 12?',
                        'How does Livewire work?',
                    ] as $suggestion)
                        <button
                            wire:click="$set('input', '{{ $suggestion }}')"
                            class="text-xs text-zinc-400 bg-zinc-800 border border-zinc-700 hover:border-zinc-600 hover:text-zinc-200 rounded-full px-3 py-1.5 transition-colors"
                        >
                            {{ $suggestion }}
                        </button>
                    @endforeach
                </div>
            </div>
        @else
            {{-- Message Loop --}}
            <div class="max-w-3xl mx-auto space-y-6">
                @foreach($messages as $message)
                    @if($message['role'] === 'user')
                        {{-- User message --}}
                        <div class="flex items-end justify-end gap-3">
                            <div class="max-w-sm lg:max-w-lg bg-zinc-700 text-zinc-100 rounded-2xl rounded-br-sm px-4 py-3 text-sm leading-relaxed">
                                {{ $message['content'] }}
                            </div>
                            <div class="w-8 h-8 rounded-full bg-zinc-600 border border-zinc-500 flex items-center justify-center text-zinc-200 text-xs font-semibold flex-shrink-0">
                                {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                            </div>
                        </div>
                    @else
                        {{-- Assistant message --}}
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-zinc-800 border border-zinc-700 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-4 h-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                                </svg>
                            </div>
                            <div
                                class="max-w-sm lg:max-w-2xl bg-zinc-900 border border-zinc-800 text-zinc-200 rounded-2xl rounded-tl-sm px-4 py-3 text-sm leading-relaxed markdown-body"
                                x-data="{ content: @js($message['content']) }"
                                x-html="marked.parse(content)"
                            ></div>
                        </div>
                    @endif
                @endforeach

                {{-- Thinking indicator --}}
                @if($thinking)
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-zinc-800 border border-zinc-700 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09 3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09z"/>
                            </svg>
                        </div>
                        <div class="bg-zinc-900 border border-zinc-800 rounded-2xl rounded-tl-sm px-4 py-3">
                            <div class="flex gap-1 items-center h-5">
                                <span class="w-1.5 h-1.5 bg-zinc-500 rounded-full animate-bounce" style="animation-delay: 0ms"></span>
                                <span class="w-1.5 h-1.5 bg-zinc-500 rounded-full animate-bounce" style="animation-delay: 150ms"></span>
                                <span class="w-1.5 h-1.5 bg-zinc-500 rounded-full animate-bounce" style="animation-delay: 300ms"></span>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>

    {{-- Input Bar --}}
    <div class="bg-zinc-900 border-t border-zinc-800 px-4 py-4 flex-shrink-0">
        <div class="max-w-3xl mx-auto">
            <form
                wire:submit="sendMessage"
                x-on:submit="$nextTick(() => $dispatch('message-added'))"
                class="flex items-end gap-3"
            >
                <div class="flex-1">
                    <textarea
                        wire:model="input"
                        x-on:keydown.enter.prevent="!$event.shiftKey && $el.form.requestSubmit()"
                        placeholder="Ask about Laravel, Livewire, Eloquent..."
                        rows="1"
                        x-on:input="$el.style.height = 'auto'; $el.style.height = Math.min($el.scrollHeight, 160) + 'px'"
                        class="w-full bg-zinc-800 border border-zinc-700 text-zinc-100
                               placeholder-zinc-500 rounded-xl px-4 py-3 text-sm
                               focus:outline-none focus:border-zinc-500 focus:ring-1 focus:ring-zinc-500
                               resize-none transition-colors leading-relaxed"
                    ></textarea>
                </div>
                <button
                    type="submit"
                    :disabled="$wire.thinking || $wire.input.trim() === ''"
                    class="bg-zinc-700 hover:bg-zinc-600 active:bg-zinc-500
                           text-zinc-100 rounded-xl p-3 transition-colors flex-shrink-0
                           disabled:opacity-40 disabled:cursor-not-allowed"
                >
                    <svg wire:loading.remove wire:target="sendMessage,getAiResponse" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/>
                    </svg>
                    <svg wire:loading wire:target="sendMessage,getAiResponse" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 22 6.477 22 12h-4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"/>
                    </svg>
                </button>
            </form>
            <p class="text-zinc-600 text-xs text-center mt-3">
                Laravel Assistant can make mistakes. Always verify critical code.
            </p>
        </div>
    </div>
    @script
    <script>
        $wire.on('message-added', () => {
            if (!$wire.thinking) return;
            setTimeout(() => $wire.getAiResponse(), 50);
        });
    </script>
    @endscript

    <style>
        .markdown-body h1, .markdown-body h2, .markdown-body h3,
        .markdown-body h4, .markdown-body h5, .markdown-body h6 {
            font-weight: 600; margin-top: 1rem; margin-bottom: 0.4rem; color: #e4e4e7;
        }
        .markdown-body h1 { font-size: 1.2em; }
        .markdown-body h2 { font-size: 1.1em; }
        .markdown-body h3 { font-size: 1em; }
        .markdown-body p { margin-bottom: 0.6rem; }
        .markdown-body ul, .markdown-body ol { padding-left: 1.4rem; margin-bottom: 0.6rem; }
        .markdown-body ul { list-style-type: disc; }
        .markdown-body ol { list-style-type: decimal; }
        .markdown-body li { margin-bottom: 0.2rem; }
        .markdown-body strong { font-weight: 600; color: #f4f4f5; }
        .markdown-body em { font-style: italic; }
        .markdown-body code {
            background: #27272a; border: 1px solid #3f3f46;
            border-radius: 4px; padding: 0.1em 0.4em; font-size: 0.85em; color: #a78bfa;
        }
        .markdown-body pre {
            background: #18181b; border: 1px solid #3f3f46;
            border-radius: 8px; padding: 1rem; overflow-x: auto; margin-bottom: 0.8rem;
        }
        .markdown-body pre code {
            background: none; border: none; padding: 0; color: #d4d4d8; font-size: 0.85em;
        }
        .markdown-body blockquote {
            border-left: 3px solid #52525b; padding-left: 0.8rem; color: #a1a1aa; margin-bottom: 0.6rem;
        }
        .markdown-body hr { border-color: #3f3f46; margin: 0.8rem 0; }
        .markdown-body a { color: #818cf8; text-decoration: underline; }
        .markdown-body > *:last-child { margin-bottom: 0; }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
</div>
