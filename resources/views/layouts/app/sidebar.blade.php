<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky collapsible="mobile" class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.header>
                <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                <flux:sidebar.collapse class="lg:hidden" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.group :heading="__('Platform')" class="grid">
                    <flux:sidebar.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                        {{ __('Dashboard') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="sparkles" :href="route('chat')" :current="request()->routeIs('chat')" wire:navigate>
                        {{ __('Chat') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>

                <flux:sidebar.group :heading="__('AI SDK')" class="grid">
                    <flux:sidebar.item icon="layout-grid" :href="route('ai.index')" :current="request()->routeIs('ai.index')" wire:navigate>
                        {{ __('Overview') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="document-text" :href="route('ai.structured')" :current="request()->routeIs('ai.structured')" wire:navigate>
                        {{ __('Structured output') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="wrench" :href="route('ai.tools')" :current="request()->routeIs('ai.tools')" wire:navigate>
                        {{ __('Tools') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="bolt" :href="route('ai.quick')" :current="request()->routeIs('ai.quick')" wire:navigate>
                        {{ __('Quick ask') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="paper-clip" :href="route('ai.attachments')" :current="request()->routeIs('ai.attachments')" wire:navigate>
                        {{ __('Attachments') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="signal" :href="route('ai.stream')" :current="request()->routeIs('ai.stream') || request()->routeIs('ai.stream.sse') || request()->routeIs('ai.stream.vercel')" wire:navigate>
                        {{ __('Streaming') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="queue-list" :href="route('ai.queue')" :current="request()->routeIs('ai.queue')" wire:navigate>
                        {{ __('Queued agent') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="photo" :href="route('ai.images')" :current="request()->routeIs('ai.images')" wire:navigate>
                        {{ __('Images') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="musical-note" :href="route('ai.speech')" :current="request()->routeIs('ai.speech')" wire:navigate>
                        {{ __('Speech') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="microphone" :href="route('ai.transcribe')" :current="request()->routeIs('ai.transcribe')" wire:navigate>
                        {{ __('Transcribe') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="circle-stack" :href="route('ai.embeddings')" :current="request()->routeIs('ai.embeddings')" wire:navigate>
                        {{ __('Embeddings') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="document" :href="route('ai.files')" :current="request()->routeIs('ai.files')" wire:navigate>
                        {{ __('Provider files') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="archive-box" :href="route('ai.stores')" :current="request()->routeIs('ai.stores')" wire:navigate>
                        {{ __('Vector stores') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="magnifying-glass" :href="route('ai.file-search')" :current="request()->routeIs('ai.file-search')" wire:navigate>
                        {{ __('File search') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="rectangle-group" :href="route('ai.similarity')" :current="request()->routeIs('ai.similarity')" wire:navigate>
                        {{ __('Similarity (pgvector)') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="shield-check" :href="route('ai.middleware')" :current="request()->routeIs('ai.middleware')" wire:navigate>
                        {{ __('Middleware') }}
                    </flux:sidebar.item>
                    <flux:sidebar.item icon="arrow-path" :href="route('ai.failover')" :current="request()->routeIs('ai.failover')" wire:navigate>
                        {{ __('Failover') }}
                    </flux:sidebar.item>
                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:spacer />

            <flux:sidebar.nav>
                <flux:sidebar.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                    {{ __('Repository') }}
                </flux:sidebar.item>

                <flux:sidebar.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                    {{ __('Documentation') }}
                </flux:sidebar.item>
            </flux:sidebar.nav>

            <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <flux:avatar
                                    :name="auth()->user()->name"
                                    :initials="auth()->user()->initials()"
                                />

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <flux:heading class="truncate">{{ auth()->user()->name }}</flux:heading>
                                    <flux:text class="truncate">{{ auth()->user()->email }}</flux:text>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>
                            {{ __('Settings') }}
                        </flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item
                            as="button"
                            type="submit"
                            icon="arrow-right-start-on-rectangle"
                            class="w-full cursor-pointer"
                            data-test="logout-button"
                        >
                            {{ __('Log out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
