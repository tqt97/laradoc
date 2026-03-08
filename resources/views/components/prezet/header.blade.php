<header :class="showHeader ? 'translate-y-0' : '-translate-y-full'"
    class="sticky top-0 z-50 w-full border-b border-zinc-200/50 bg-linear-to-r from-white via-primary-50/20 to-white backdrop-blur-md transition-transform duration-300 ease-in-out dark:border-zinc-800/50 dark:from-zinc-950 dark:via-zinc-900/80 dark:to-zinc-950">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between gap-8">
            {{-- Logo & Brand --}}
            <div class="flex items-center gap-10">
                <a aria-label="Home" href="{{ route('prezet.index') }}" class="flex items-center gap-1 group">
                    <div class="transition-transform duration-300 group-hover:scale-110">
                        <x-prezet.logo />
                    </div>
                    <span class="text-xl font-bold tracking-tight text-zinc-900 dark:text-white">
                        {{ config('app.name', 'PREZET') }}
                    </span>
                </a>

                {{-- Desktop Navigation --}}
                <nav class="hidden items-center gap-4 lg:flex">
                    <x-prezet.nav-link :href="route('prezet.articles')" :active="request()->routeIs('prezet.articles')">
                        Bài viết
                    </x-prezet.nav-link>

                    <x-prezet.nav-link :href="route('prezet.series.index')" :active="request()->is('series*')">
                        Chuỗi bài viết
                    </x-prezet.nav-link>

                    <x-prezet.nav-link :href="route('links.index')" :active="request()->routeIs('links.index')">
                        Liên kết
                    </x-prezet.nav-link>

                    <x-prezet.nav-link :href="route('snippets.index')" :active="request()->routeIs('snippets.index')">
                        Snippets
                    </x-prezet.nav-link>

                    <a href="{{ route('ideas.index') }}"
                        class="relative ml-2 flex items-center gap-2 rounded-full px-4 py-1.5 text-sm font-bold transition-all hover:bg-primary-100 hover:text-primary-600 {{ request()->routeIs('ideas.index') ? 'bg-primary-100 text-primary-600 dark:bg-white dark:text-zinc-900' : 'bg-primary-50 text-primary-600 ring-1 ring-primary-100 dark:bg-primary-900/20 dark:text-primary-400 dark:ring-primary-900/50' }}">
                        <span class="relative flex h-3 w-3">
                            <span
                                class="absolute inline-flex h-full w-full animate-ping rounded-full bg-primary-400 opacity-75"></span>
                            <span class="relative inline-flex h-3 w-3 rounded-full bg-primary-400"></span>
                        </span>
                        Gợi ý bài viết
                    </a>
                </nav>
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-4 sm:gap-6">
                <x-prezet.search />

                <div
                    class="flex items-center gap-2 border-l border-zinc-200 pl-4 dark:border-zinc-800 sm:gap-4 sm:pl-6">
                    <div x-data="{
                        darkMode: document.documentElement.classList.contains('dark'),
                        toggle() {
                            this.darkMode = !this.darkMode;
                            document.documentElement.classList.toggle('dark', this.darkMode);
                            localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
                        }
                    }">
                        <button @click="toggle"
                            class="group relative p-2 rounded-3xl hover:bg-zinc-100 dark:hover:bg-zinc-900 transition-all duration-300 outline-none overflow-hidden flex items-center justify-center size-10 hover:cursor-pointer"
                            aria-label="Chuyển chế độ sáng tối">
                            <!-- Sun Icon (shown in dark mode) -->
                            <div x-show="darkMode" x-transition:enter="transition duration-300"
                                x-transition:enter-start="opacity-0 translate-y-8 rotate-90"
                                x-transition:enter-end="opacity-100 translate-y-0 rotate-0" class="absolute">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="size-5 text-yellow-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 3v2.25m0 13.5V21m8.966-8.966h-2.25M3 12h2.25m13.503-6.997-1.591 1.591M5.509 18.491l-1.591 1.591m12.982 0 1.591-1.591M4.217 4.217l1.591 1.591M12 7.5a4.5 4.5 0 1 1 0 9 4.5 4.5 0 0 1 0-9Z" />
                                </svg>
                            </div>
                            <!-- Moon Icon (shown in light mode) -->
                            <div x-show="!darkMode" x-transition:enter="transition duration-300"
                                x-transition:enter-start="opacity-0 -translate-y-8 -rotate-90"
                                x-transition:enter-end="opacity-100 translate-y-0 rotate-0" class="absolute">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor"
                                    class="size-5 text-zinc-500 group-hover:text-zinc-900">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                                </svg>
                            </div>
                        </button>
                    </div>

                    <button aria-label="Menu"
                        class="group p-2 rounded-3xl hover:bg-zinc-100 dark:hover:bg-zinc-900 lg:hidden transition-colors"
                        @click="showSidebar = !showSidebar">
                        <svg class="h-6 w-6 text-zinc-500 group-hover:text-zinc-900 dark:text-zinc-400 dark:group-hover:text-zinc-100"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <line x1="4" x2="20" y1="12" y2="12" x-show="!showSidebar"></line>
                            <line x1="4" x2="20" y1="6" y2="6" :class="showSidebar ? 'rotate-45 translate-y-2 origin-center transition-transform' : ''"></line>
                            <line x1="4" x2="20" y1="18" y2="18" :class="showSidebar ? '-rotate-45 -translate-y-2 origin-center transition-transform' : ''"></line>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
</header>

{{-- Mobile Menu Overlay --}}
<div x-show="showSidebar"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-[9998] bg-zinc-900/60 backdrop-blur-md lg:hidden"
    @click="showSidebar = false"
    x-cloak>
</div>

{{-- Mobile Menu Panel --}}
<div x-show="showSidebar"
    x-transition:enter="transition ease-out duration-500"
    x-transition:enter-start="translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-300"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="translate-x-full"
    class="fixed inset-y-0 right-0 z-[9999] w-full max-w-sm bg-white dark:bg-zinc-950 shadow-[0_0_50px_rgba(0,0,0,0.3)] lg:hidden flex flex-col h-full border-l border-zinc-100 dark:border-zinc-800"
    x-cloak>

    {{-- Mobile Menu Header --}}
    <div class="flex items-center justify-between px-6 h-24 border-b border-zinc-100 dark:border-zinc-800 bg-white/50 dark:bg-zinc-950/50 backdrop-blur-md sticky top-0 z-10">
        <a href="{{ route('prezet.index') }}" class="flex items-center gap-3" @click="showSidebar = false">
            <x-prezet.logo class="size-8" />
            <span class="text-xl font-black tracking-tight text-zinc-900 dark:text-white">{{ config('app.name', 'PREZET') }}</span>
        </a>
        <button @click="showSidebar = false"
            class="p-2 rounded-3xl bg-zinc-50 dark:bg-zinc-900 text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white transition-all active:scale-95">
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    {{-- Mobile Menu Content --}}
    <nav class="flex-grow overflow-y-auto py-10 px-6 custom-scrollbar">
        <div class="space-y-10">
            {{-- Primary Links --}}
            <div class="space-y-2">
                <p class="px-4 text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400 dark:text-zinc-600 mb-4">Điều hướng</p>

                <a href="{{ route('prezet.articles') }}" @click="showSidebar = false"
                    class="flex items-center gap-4 px-4 py-4 rounded-3xl text-lg font-bold transition-all {{ request()->routeIs('prezet.articles') ? 'text-primary-600 dark:text-primary-400' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25v14.25" />
                    </svg>
                    Bài viết
                </a>

                <a href="{{ route('prezet.series.index') }}" @click="showSidebar = false"
                    class="flex items-center gap-4 px-4 py-4 rounded-3xl text-lg font-bold transition-all {{ request()->is('series*') ? 'text-primary-600 dark:text-primary-400' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25v14.25" />
                    </svg>
                    Chuỗi bài viết
                </a>

                <a href="{{ route('links.index') }}" @click="showSidebar = false"
                    class="flex items-center gap-4 px-4 py-4 rounded-3xl text-lg font-bold transition-all {{ request()->routeIs('links.index') ? 'text-primary-600 dark:text-primary-400' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                    </svg>
                    Liên kết
                </a>

                <a href="{{ route('snippets.index') }}" @click="showSidebar = false"
                    class="flex items-center gap-4 px-4 py-4 rounded-3xl text-lg font-bold transition-all {{ request()->routeIs('snippets.index') ? 'bg-primary-50 text-primary-600 dark:bg-primary-900/20 dark:text-primary-400' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" />
                    </svg>
                    Snippets
                </a>
            </div>

            {{-- Special Section --}}
            <div class="pt-6 border-t border-zinc-100 dark:border-zinc-800">
                <a href="{{ route('ideas.index') }}" @click="showSidebar = false"
                    class="flex items-center justify-between rounded-3xl bg-zinc-900 dark:bg-white px-6 py-5 text-white dark:text-zinc-900 shadow-xl transition-all active:scale-95 group">
                    <div class="flex flex-col">
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] opacity-60 mb-1">Cộng đồng</span>
                        <span class="text-base font-bold">Gợi ý bài viết</span>
                    </div>
                    <div class="relative flex h-3 w-3">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-primary-400 opacity-75"></span>
                        <span class="relative inline-flex h-3 w-3 rounded-full bg-primary-500"></span>
                    </div>
                </a>
            </div>        </div>
    </nav>

    {{-- Mobile Menu Footer --}}
    <div class="p-8 border-t border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
        <div class="flex items-center justify-between">
            <p class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400">
                &copy; {{ date('Y') }} {{ config('app.name') }}
            </p>
            <div class="flex gap-4">
                {{-- Add social icons if needed --}}
            </div>
        </div>
    </div>
</div>
