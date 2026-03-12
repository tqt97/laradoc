<header :class="showHeader ? 'translate-y-0' : '-translate-y-full'"
    class="sticky top-0 z-50 w-full border-b border-zinc-200/50 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-xl transition-all duration-500 ease-in-out dark:border-zinc-800/50">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="flex h-20 items-center justify-between gap-4">
            {{-- Left: Logo & Navigation --}}
            <div class="flex items-center gap-6 xl:gap-8 flex-none">
                <a aria-label="Home" href="{{ route('prezet.index') }}" class="flex items-center gap-2.5 group">
                    <div class="transition-all duration-500 group-hover:scale-110 group-hover:rotate-3">
                        <x-prezet.logo class="size-12" />
                    </div>
                </a>

                {{-- Desktop Navigation --}}
                <nav class="hidden items-center gap-6 xl:gap-4 lg:flex">
                    <x-prezet.nav-link :href="route('prezet.articles')" :active="request()->routeIs('prezet.articles')" class="relative py-1 group/nav">
                        Bài viết
                        <span
                            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary-500 transition-all duration-300 {{ request()->routeIs('prezet.articles') ? 'w-full' : 'group-hover/nav:w-full' }}"></span>
                    </x-prezet.nav-link>

                    <x-prezet.nav-link :href="route('prezet.series.index')" :active="request()->is('series*')" class="relative py-1 group/nav">
                        Chuỗi bài viết
                        <span
                            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary-500 transition-all duration-300 {{ request()->is('series*') ? 'w-full' : 'group-hover/nav:w-full' }}"></span>
                    </x-prezet.nav-link>

                    <x-prezet.nav-link :href="route('links.index')" :active="request()->routeIs('links.index')" class="relative py-1 group/nav">
                        Liên kết
                        <span
                            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary-500 transition-all duration-300 {{ request()->routeIs('links.index') ? 'w-full' : 'group-hover/nav:w-full' }}"></span>
                    </x-prezet.nav-link>

                    <x-prezet.nav-link :href="route('snippets.index')" :active="request()->routeIs('snippets.index')" class="relative py-1 group/nav">
                        Snippets
                        <span
                            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary-500 transition-all duration-300 {{ request()->routeIs('snippets.index') ? 'w-full' : 'group-hover/nav:w-full' }}"></span>
                    </x-prezet.nav-link>

                    <x-prezet.nav-link :href="route('gallery.index')" :active="request()->routeIs('gallery.index')" class="relative py-1 group/nav">
                        Thư viện
                        <span
                            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-primary-500 transition-all duration-300 {{ request()->routeIs('gallery.index') ? 'w-full' : 'group-hover/nav:w-full' }}"></span>
                    </x-prezet.nav-link>

                    <x-prezet.nav-link :href="route('portfolio.index')" :active="request()->routeIs('portfolio.index')" class="relative py-1 group/nav">
                        <span class="text-pink-600 dark:text-pink-400">Portfolio</span>
                        <span
                            class="absolute -bottom-1 left-0 w-0 h-0.5 bg-pink-500 transition-all duration-300 {{ request()->routeIs('portfolio.index') ? 'w-full' : 'group-hover/nav:w-full' }}"></span>
                    </x-prezet.nav-link>

                    <a href="{{ route('ideas.index') }}"
                        class="relative flex items-center gap-2 px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 border border-primary-100 dark:border-primary-900/50 hover:bg-primary-100 dark:hover:bg-primary-900/30 transition-all active:scale-95">
                        <span class="relative flex h-1.5 w-1.5">
                            <span
                                class="absolute inline-flex h-full w-full animate-ping rounded-full bg-primary-400 opacity-75"></span>
                            <span class="relative inline-flex h-1.5 w-1.5 rounded-full bg-primary-500"></span>
                        </span>
                        Gợi ý
                    </a>
                </nav>
            </div>

            {{-- Right: Actions --}}
            <div class="flex items-center justify-end gap-2 sm:gap-2 flex-none ml-auto">
                {{-- Search --}}
                <div class="hidden sm:block sm:mr-3">
                    <x-prezet.search />
                </div>
                <div class="sm:hidden">
                    <x-prezet.search />
                </div>

                <div class="h-6 w-px bg-zinc-200 dark:bg-zinc-800 mx-1 hidden lg:block"></div>

                {{-- Dark Mode Toggle --}}
                <div x-data="{
                    darkMode: document.documentElement.classList.contains('dark'),
                    toggle() {
                        this.darkMode = !this.darkMode;
                        document.documentElement.classList.toggle('dark', this.darkMode);
                        localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
                    }
                }" class="flex items-center">
                    <button @click="toggle"
                        class="group relative size-10 rounded-xl hover:cursor-pointer transition-all duration-300 outline-none flex items-center justify-center border border-transparent dark:bg-zinc-900 hover:bg-zinc-50 dark:hover:bg-zinc-800"
                        aria-label="Toggle Theme">
                        <svg x-show="darkMode" x-cloak
                            class="size-5 text-yellow-500 dark:hover:text-yellow-400 transition-all" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 3v2.25m0 13.5V21m8.966-8.966h-2.25M3 12h2.25m13.503-6.997-1.591 1.591M5.509 18.491l-1.591 1.591m12.982 0 1.591-1.591M4.217 4.217l1.591 1.591M12 7.5a4.5 4.5 0 1 1 0 9 4.5 4.5 0 0 1 0-9Z" />
                        </svg>
                        <svg x-show="!darkMode" x-cloak
                            class="size-5 text-zinc-500 group-hover:text-zinc-900 transition-all" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" />
                        </svg>
                    </button>
                </div>

                {{-- Auth Section --}}
                @auth
                    <div class="hidden lg:block relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                            class="flex items-center gap-2 py-1.5 px-2 pr-3 rounded-3xl bg-zinc-50 dark:bg-zinc-900/50 border border-zinc-200 dark:border-zinc-800 hover:border-zinc-300 dark:hover:border-zinc-700 transition-all active:scale-95 outline-none group hover:cursor-pointer">
                            <div
                                class="size-6 rounded-xl bg-primary-600 flex items-center justify-center text-white text-xs font-semibold shadow-lg shadow-primary-500/20 group-hover:scale-105 transition-transform">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span
                                class="text-sm font-bold text-zinc-700 dark:text-zinc-300 group-hover:text-zinc-900 dark:group-hover:text-white truncate max-w-[100px]">{{ Auth::user()->name }}</span>
                            <svg class="size-3 text-zinc-400 group-hover:text-zinc-600 dark:group-hover:text-zinc-200 transition-transform duration-300"
                                :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" x-cloak x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                            x-transition:leave="transition ease-in duration-100"
                            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                            x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                            class="absolute right-0 mt-4 w-60 rounded-3xl bg-white dark:bg-zinc-950 shadow-[0_20px_50px_rgba(0,0,0,0.15)] dark:shadow-[0_20px_50px_rgba(0,0,0,0.4)] border border-zinc-200 dark:border-zinc-800 p-2 z-50 overflow-hidden">
                            <div class="px-3 py-2.5 mb-1 border-b border-zinc-100 dark:border-zinc-900">
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-zinc-400">Account</p>
                            </div>
                            <a href="{{ route('dashboard') }}"
                                class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-zinc-700 dark:text-zinc-300 hover:bg-primary-50/80 dark:hover:bg-zinc-900 rounded-2xl transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="size-4 opacity-50">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25a2.25 2.25 0 0 1-2.25-2.25v-2.25Z" />
                                </svg>
                                Dashboard
                            </a>
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-zinc-700 dark:text-zinc-300 hover:bg-primary-50/80 dark:hover:bg-zinc-900 rounded-2xl transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="size-4 opacity-50">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                                Hồ sơ
                            </a>
                            <hr class="my-2 border-zinc-100 dark:border-zinc-900">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-3 text-sm font-bold text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-2xl transition-all hover:cursor-pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                    </svg>
                                    Đăng xuất
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="hidden lg:flex items-center ml-2">
                        <a href="{{ route('login') }}"
                            class="group relative flex items-center gap-2 px-5 py-2.5 text-[11px] font-black uppercase tracking-widest rounded-2xl bg-primary-500 text-white shadow-lg shadow-primary-500/20 hover:bg-primary-600 hover:shadow-primary-500/40 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="3" stroke="currentColor"
                                class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                            </svg>
                            <span>Đăng nhập</span>
                        </a>
                    </div>
                @endauth

                <button aria-label="Menu"
                    class="group relative size-10 rounded-xl hover:bg-zinc-100 dark:hover:bg-zinc-900 lg:hidden transition-all flex items-center justify-center border "
                    @click="showSidebar = !showSidebar">
                    <svg class="h-6 w-6 text-zinc-500 group-hover:text-zinc-900 dark:text-zinc-400 dark:group-hover:text-zinc-100 transition-colors"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" stroke-linejoin="round">
                        <line x1="4" x2="20" y1="12" y2="12" x-show="!showSidebar">
                        </line>
                        <line x1="4" x2="20" y1="6" y2="6"
                            :class="showSidebar ? 'rotate-45 translate-y-2' : ''"
                            class="origin-center transition-transform duration-300"></line>
                        <line x1="4" x2="20" y1="18" y2="18"
                            :class="showSidebar ? '-rotate-45 -translate-y-2' : ''"
                            class="origin-center transition-transform duration-300"></line>
                    </svg>
                </button>
            </div>
        </div>
    </div>
</header>

{{-- Mobile Menu Overlay --}}
<div x-show="showSidebar" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
    class="fixed inset-0 z-[9998] bg-zinc-900/60 backdrop-blur-md lg:hidden" @click="showSidebar = false" x-cloak>
</div>

{{-- Mobile Menu Panel --}}
<div x-show="showSidebar" x-transition:enter="transition ease-out duration-500"
    x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="translate-x-0"
    x-transition:leave-end="translate-x-full"
    class="fixed inset-y-0 right-0 z-[9999] w-full max-w-sm bg-white dark:bg-zinc-950 shadow-[0_0_50px_rgba(0,0,0,0.3)] lg:hidden flex flex-col h-full border-l border-zinc-100 dark:border-zinc-800"
    x-cloak>

    {{-- Mobile Menu Header --}}
    <div
        class="flex items-center justify-between px-6 h-24 border-b border-zinc-100 dark:border-zinc-800 bg-white/50 dark:bg-zinc-950/50 backdrop-blur-md sticky top-0 z-10">
        <a href="{{ route('prezet.index') }}" class="flex items-center gap-3" @click="showSidebar = false">
            <x-prezet.logo class="size-8" />
            <span
                class="text-xl font-black tracking-tight text-zinc-900 dark:text-white">{{ config('app.name', 'PREZET') }}</span>
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
            {{-- Authentication --}}
            <div class="space-y-4">
                @auth
                    <div
                        class="p-5 rounded-3xl bg-zinc-50 dark:bg-zinc-900/50 border border-zinc-100 dark:border-zinc-800">
                        <div class="flex items-center gap-4 mb-5">
                            <div
                                class="size-12 rounded-2xl bg-primary-500 flex items-center justify-center text-white text-xl font-black shadow-lg shadow-primary-500/20">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                            <div class="flex flex-col min-w-0">
                                <span
                                    class="text-lg font-black text-zinc-900 dark:text-white truncate">{{ auth()->user()->name }}</span>
                                <span class="text-xs text-zinc-500 truncate">{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <a href="{{ route('dashboard') }}"
                                class="flex items-center justify-center h-12 rounded-2xl bg-white dark:bg-zinc-800 text-sm font-bold text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700 shadow-sm active:scale-95 transition-all">Dashboard</a>
                            <a href="{{ route('profile.edit') }}"
                                class="flex items-center justify-center h-12 rounded-2xl bg-white dark:bg-zinc-800 text-sm font-bold text-zinc-700 dark:text-zinc-300 border border-zinc-200 dark:border-zinc-700 shadow-sm active:scale-95 transition-all">Profile</a>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="mt-3">
                            @csrf
                            <button type="submit"
                                class="w-full h-12 rounded-2xl bg-red-50 dark:bg-red-900/10 text-sm font-bold text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/20 active:scale-95 transition-all">Log
                                Out</button>
                        </form>
                    </div>
                @else
                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('login') }}"
                            class="group flex items-center justify-center gap-2.5 h-14 rounded-2xl bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-800 shadow-[0_3px_0_0_rgba(229,231,235,1)] dark:shadow-[0_3px_0_0_rgba(24,24,27,1)] active:translate-y-[1.5px] active:shadow-[0_1.5px_0_0_rgba(229,231,235,1)] dark:active:shadow-[0_1.5px_0_0_rgba(24,24,27,1)] transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor"
                                class="size-5 text-zinc-500 group-hover:text-zinc-900 dark:group-hover:text-white transition-colors">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                            </svg>
                            <span class="text-[11px] font-black uppercase tracking-wider">Log in</span>
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="group flex items-center justify-center gap-2.5 h-14 rounded-2xl bg-primary-500 text-white shadow-[0_3px_0_0_rgba(194,65,12,1)] active:translate-y-[1.5px] active:shadow-[0_1.5px_0_0_rgba(194,65,12,1)] transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2.5" stroke="currentColor"
                                    class="size-5 group-hover:scale-110 transition-transform">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                                </svg>
                                <span class="text-[11px] font-black uppercase tracking-wider">Register</span>
                            </a>
                        @endif
                    </div>
                @endauth
            </div>

            {{-- Primary Links --}}
            <div class="space-y-2">
                <p
                    class="px-4 text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400 dark:text-zinc-600 mb-4">
                    Điều hướng</p>

                <a href="{{ route('prezet.articles') }}" @click="showSidebar = false"
                    class="flex items-center gap-4 px-4 py-4 rounded-3xl text-lg font-bold transition-all {{ request()->routeIs('prezet.articles') ? 'text-primary-600 dark:text-primary-400' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25v14.25" />
                    </svg>
                    Bài viết
                </a>

                <a href="{{ route('prezet.series.index') }}" @click="showSidebar = false"
                    class="flex items-center gap-4 px-4 py-4 rounded-3xl text-lg font-bold transition-all {{ request()->is('series*') ? 'text-primary-600 dark:text-primary-400' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25v14.25" />
                    </svg>
                    Chuỗi bài viết
                </a>

                <a href="{{ route('links.index') }}" @click="showSidebar = false"
                    class="flex items-center gap-4 px-4 py-4 rounded-3xl text-lg font-bold transition-all {{ request()->routeIs('links.index') ? 'text-primary-600 dark:text-primary-400' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                    </svg>
                    Liên kết
                </a>

                <a href="{{ route('snippets.index') }}" @click="showSidebar = false"
                    class="flex items-center gap-4 px-4 py-4 rounded-3xl text-lg font-bold transition-all {{ request()->routeIs('snippets.index') ? 'bg-primary-50 text-primary-600 dark:bg-primary-900/20 dark:text-primary-400' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" />
                    </svg>
                    Snippets
                </a>

                <a href="{{ route('gallery.index') }}" @click="showSidebar = false"
                    class="flex items-center gap-4 px-4 py-4 rounded-3xl text-lg font-bold transition-all {{ request()->routeIs('gallery.index') ? 'bg-primary-50 text-primary-600 dark:bg-primary-900/20 dark:text-primary-400' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    Thư viện
                </a>

                <a href="{{ route('portfolio.index') }}" @click="showSidebar = false"
                    class="flex items-center gap-4 px-4 py-4 rounded-3xl text-lg font-bold transition-all {{ request()->routeIs('portfolio.index') ? 'bg-pink-50 text-pink-600 dark:bg-pink-900/20 dark:text-pink-400' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-900' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.362 5.214A8.252 8.252 0 0112 21 8.25 8.25 0 016.038 7.048 8.287 8.287 0 009 9.6a8.983 8.983 0 013.361-6.867 8.21 8.21 0 003 2.48z" />
                    </svg>
                    Portfolio
                </a>
            </div>

            {{-- Special Section --}}
            <div class="pt-6 border-t border-zinc-100 dark:border-zinc-800">
                <a href="{{ route('ideas.index') }}" @click="showSidebar = false"
                    class="group relative flex items-center justify-between rounded-3xl bg-primary-500 px-6 py-5 text-white shadow-[0_5px_0_0_rgba(194,65,12,1)] active:translate-y-[2px] active:shadow-[0_3px_0_0_rgba(194,65,12,1)] transition-all">
                    <div class="flex flex-col">
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] opacity-80 mb-1">Cộng
                            đồng</span>
                        <span class="text-base font-bold">Gợi ý bài viết</span>
                    </div>
                    <div class="relative flex h-3 w-3">
                        <span
                            class="absolute inline-flex h-full w-full animate-ping rounded-full bg-white opacity-40"></span>
                        <span class="relative inline-flex h-3 w-3 rounded-full bg-white"></span>
                    </div>
                </a>
            </div>
        </div>
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
