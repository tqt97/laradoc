<header
    class="sticky top-0 z-50 w-full border-b border-zinc-200/50 bg-white/80 backdrop-blur-md transition-colors duration-300 dark:border-zinc-800/50 dark:bg-zinc-950/80">
    <div class="absolute top-0 left-0 w-full h-[2px] bg-transparent overflow-hidden pointer-events-none">
        <div class="h-full bg-zinc-900 dark:bg-white transition-all duration-300 ease-out shadow-[0_0_10px_rgba(0,0,0,0.1)] dark:shadow-[0_0_10px_rgba(255,255,255,0.1)]"
            :style="`width: ${progress}%`" x-show="progress > 0"></div>
    </div>
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
                {{-- <nav class="hidden items-center gap-8 lg:flex">
                    <a href="{{ route('prezet.index') }}"
                       class="text-sm font-semibold text-zinc-600 hover:text-zinc-900 transition-colors dark:text-zinc-400 dark:hover:text-zinc-200">
                        Home
                    </a>
                    <a href="{{ route('prezet.index') }}#articles"
                       class="text-sm font-semibold text-zinc-600 hover:text-zinc-900 transition-colors dark:text-zinc-400 dark:hover:text-zinc-200">
                        Articles
                    </a>
                    <a href="{{ route('prezet.index') }}#articles"
                       class="text-sm font-semibold text-zinc-600 hover:text-zinc-900 transition-colors dark:text-zinc-400 dark:hover:text-zinc-200">
                        Categories
                    </a>
                    <a href="{{ route('prezet.index') }}#articles"
                       class="text-sm font-semibold text-zinc-600 hover:text-zinc-900 transition-colors dark:text-zinc-400 dark:hover:text-zinc-200">
                        Tags
                    </a>
                </nav> --}}
            </div>

            {{-- Actions --}}
            <div class="flex items-center gap-4 sm:gap-6">
                <x-prezet.search />

                <div
                    class="flex items-center gap-2 border-l border-zinc-200 pl-4 dark:border-zinc-800 sm:gap-4 sm:pl-6">
                    <button
                        onclick="const isDark = document.documentElement.classList.toggle('dark'); localStorage.setItem('theme', isDark ? 'dark' : 'light');"
                        class="group p-2 rounded-xl hover:bg-zinc-100 dark:hover:bg-zinc-900 transition-colors outline-none hover:cursor-pointer"
                        aria-label="Toggle theme">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor"
                            class="h-5 w-5 text-zinc-500 group-hover:text-zinc-900 dark:text-zinc-400 dark:group-hover:text-zinc-100 transition-colors">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                        </svg>
                    </button>

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
</header>
