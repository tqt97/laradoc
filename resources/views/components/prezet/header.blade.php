<header :class="showHeader ? 'translate-y-0' : '-translate-y-full'"
    class="sticky top-0 z-50 w-full border-b border-zinc-200/50 bg-white/80 backdrop-blur-md transition-transform duration-300 ease-in-out dark:border-zinc-800/50 dark:bg-zinc-950/80">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between gap-8">
            {{-- Logo & Brand --}}
            <div class="flex items-center gap-10">
                <a aria-label="Home" href="{{ route('prezet.index') }}" class="flex items-center gap-3 group">
                    <div class="transition-transform duration-300 group-hover:scale-110">
                        <x-prezet.logo />
                    </div>
                    <span class="text-xl font-bold tracking-tight text-zinc-900 dark:text-white">
                        {{ config('app.name', 'PREZET') }}
                    </span>
                </a>

                {{-- Desktop Navigation --}}
                <nav class="hidden items-center gap-8 lg:flex">
                    <a href="{{ route('prezet.articles') }}"
                        class="text-sm font-semibold {{ request()->routeIs('prezet.articles') ? 'text-zinc-900 dark:text-white' : 'text-zinc-600 dark:text-zinc-400' }} hover:text-zinc-900 transition-colors dark:hover:text-zinc-200">
                        Bài viết
                    </a>
                    <a href="{{ route('prezet.series.index') }}"
                        class="text-sm font-semibold {{ request()->is('series*') ? 'text-zinc-900 dark:text-white' : 'text-zinc-600 dark:text-zinc-400' }} hover:text-zinc-900 transition-colors dark:hover:text-zinc-200">
                        Chuỗi bài viết
                    </a>
                    <a href="{{ route('links.index') }}"
                        class="text-sm font-semibold {{ request()->routeIs('links.index') ? 'text-zinc-900 dark:text-white' : 'text-zinc-600 dark:text-zinc-400' }} hover:text-zinc-900 transition-colors dark:hover:text-zinc-200">
                        Lưu trữ
                    </a>
                    <a href="{{ route('snippets.index') }}"
                        class="text-sm font-semibold {{ request()->routeIs('snippets.index') ? 'text-zinc-900 dark:text-white' : 'text-zinc-600 dark:text-zinc-400' }} hover:text-zinc-900 transition-colors dark:hover:text-zinc-200">
                        Snippets
                    </a>
                    <a href="{{ route('ideas.index') }}"
                        class="relative ml-2 flex items-center gap-2 rounded-full px-4 py-1.5 text-sm font-bold transition-all hover:scale-105 active:scale-95 {{ request()->routeIs('ideas.index') ? 'bg-primary-100 text-primary-600 dark:bg-white dark:text-zinc-900' : 'bg-primary-50 text-primary-600 ring-1 ring-primary-100 dark:bg-primary-900/20 dark:text-primary-400 dark:ring-primary-900/50' }}">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="absolute inline-flex h-full w-full animate-ping rounded-full bg-primary-400 opacity-75"></span>
                            <span class="relative inline-flex h-2 w-2 rounded-full bg-primary-500"></span>
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
                            class="group relative p-2 rounded-xl hover:bg-zinc-100 dark:hover:bg-zinc-900 transition-all duration-300 outline-none overflow-hidden flex items-center justify-center size-10 hover:cursor-pointer"
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
                        class="group p-2 rounded-xl hover:bg-zinc-100 dark:hover:bg-zinc-900 lg:hidden transition-colors"
                        x-on:click="showSidebar = ! showSidebar">
                        <svg class="h-6 w-6 text-zinc-500 group-hover:text-zinc-900 dark:text-zinc-400 dark:group-hover:text-zinc-100"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <line x1="4" x2="20" y1="12" y2="12"></line>
                            <line x1="4" x2="20" y1="6" y2="6"></line>
                            <line x1="4" x2="20" y1="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile Menu Overlay --}}
    <div x-show="showSidebar" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[60] bg-zinc-900/50 backdrop-blur-sm lg:hidden" x-on:click="showSidebar = false" x-cloak>
    </div>

    {{-- Mobile Menu Panel --}}
    <div x-show="showSidebar" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed inset-y-0 right-0 z-[70] w-full max-w-xs bg-white shadow-2xl dark:bg-zinc-950 lg:hidden" x-cloak>
        <div class="flex h-full flex-col">
            <div class="flex items-center justify-between px-6 h-20 border-b border-zinc-100 dark:border-zinc-800">
                <a href="{{ route('prezet.index') }}" class="flex items-center gap-3" @click="showSidebar = false">
                    <x-prezet.logo />
                    <span
                        class="text-lg font-bold text-zinc-900 dark:text-white">{{ config('app.name', 'PREZET') }}</span>
                </a>
                <button @click="showSidebar = false"
                    class="p-2 text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="flex-grow overflow-y-auto py-8 px-6">
                <ul class="space-y-6">
                    <li>
                        <a href="{{ route('prezet.articles') }}" @click="showSidebar = false"
                            class="flex items-center gap-4 text-base font-bold {{ request()->routeIs('prezet.articles') ? 'text-primary-600 dark:text-primary-400' : 'text-zinc-600 dark:text-zinc-400' }}">
                            Bài viết
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('prezet.series.index') }}" @click="showSidebar = false"
                            class="flex items-center gap-4 text-base font-bold {{ request()->is('series*') ? 'text-primary-600 dark:text-primary-400' : 'text-zinc-600 dark:text-zinc-400' }}">
                            Chuỗi bài viết
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('links.index') }}" @click="showSidebar = false"
                            class="flex items-center gap-4 text-base font-bold {{ request()->routeIs('links.index') ? 'text-primary-600 dark:text-primary-400' : 'text-zinc-600 dark:text-zinc-400' }}">
                            Lưu trữ
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('snippets.index') }}" @click="showSidebar = false"
                            class="flex items-center gap-4 text-base font-bold {{ request()->routeIs('snippets.index') ? 'text-primary-600 dark:text-primary-400' : 'text-zinc-600 dark:text-zinc-400' }}">
                            Snippets
                        </a>
                    </li>
                    <li class="pt-6 border-t border-zinc-100 dark:border-zinc-800">
                        <a href="{{ route('ideas.index') }}" @click="showSidebar = false"
                            class="flex items-center justify-between rounded-2xl bg-primary-50 px-6 py-4 text-sm font-bold text-primary-600 ring-1 ring-primary-100 dark:bg-primary-900/20 dark:text-primary-400 dark:ring-primary-900/50">
                            Gợi ý bài viết
                            <span class="relative flex h-2 w-2">
                                <span
                                    class="absolute inline-flex h-full w-full animate-ping rounded-full bg-primary-400 opacity-75"></span>
                                <span class="relative inline-flex h-2 w-2 rounded-full bg-primary-500"></span>
                            </span>
                        </a>
                    </li>
                </ul>
            </nav>

            <div class="p-6 border-t border-zinc-100 dark:border-zinc-800">
                <p
                    class="text-[10px] font-bold uppercase tracking-widest text-zinc-400 dark:text-zinc-600 text-center">
                    Powered by Prezet
                </p>
            </div>
        </div>
    </div>
</header>
