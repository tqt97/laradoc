<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;700;900&display=swap"
        rel="stylesheet">

    <x-prezet.meta />

    <!-- Scripts -->
    <script src="https://unpkg.com/htmx.org@2.0.1"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/lite-youtube-embed@0.3.3/src/lite-yt-embed.min.js"></script>
    <script defer src="https://unpkg.com/@benbjurstrom/alpinejs-zoomable@0.4.0/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/focus@3.14.1/dist/cdn.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
    @vite(['resources/css/prezet.css'])
    @stack('jsonld')

    <script>
        ;
        (function() {
            const stored = localStorage.getItem('theme')
            const prefersDark = window.matchMedia(
                '(prefers-color-scheme: dark)'
            ).matches
            const useDark =
                stored === 'dark' || (stored === null && prefersDark)

            if (useDark) {
                document.documentElement.classList.add('dark')
            }
        })()
    </script>
</head>

<body
    class="font-['Be_Vietnam_Pro'] antialiased dark:bg-zinc-900 selection:bg-zinc-900 selection:text-white dark:selection:bg-white dark:selection:text-zinc-900"
    x-data="{
        scrolled: false,
        progress: 0,
        showSidebar: false,
        updateScroll() {
            const h = document.documentElement,
                b = document.body,
                st = 'scrollTop',
                sh = 'scrollHeight';
            this.progress = (h[st] || b[st]) / ((h[sh] || b[sh]) - h.clientHeight) * 100;
            this.scrolled = window.scrollY > 500;
        }
    }" x-init="window.addEventListener('scroll', () => updateScroll())">

    <div class="min-h-screen flex flex-col bg-white dark:bg-zinc-950 transition-colors duration-300">
        <x-prezet.header />

        <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            {{ $slot }}
        </main>

        <footer class="bg-zinc-50 dark:bg-zinc-900/30 border-t border-zinc-100 dark:border-zinc-800/50 mt-24">
            {{-- Footer content --}}
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-12 md:gap-8">
                    <div class="md:col-span-4 lg:col-span-5">
                        <x-prezet.logo />
                        <p class="mt-6 text-zinc-500 dark:text-zinc-400 max-w-sm text-lg leading-relaxed font-medium">
                            A high-performance blogging engine for Laravel developers who love Markdown.
                        </p>
                        <div class="mt-8 flex items-center gap-4">
                            <a href="#"
                                class="w-10 h-10 rounded-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 flex items-center justify-center text-zinc-600 dark:text-zinc-400 hover:bg-zinc-900 hover:text-white dark:hover:bg-white dark:hover:text-zinc-900 transition-all">
                                <span class="sr-only">GitHub</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                                        clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="#"
                                class="w-10 h-10 rounded-full bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 flex items-center justify-center text-zinc-600 dark:text-zinc-400 hover:bg-zinc-900 hover:text-white dark:hover:bg-white dark:hover:text-zinc-900 transition-all">
                                <span class="sr-only">Twitter</span>
                                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477 4.072 4.072 0 01-1.858-.513v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84" />
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="md:col-span-3 lg:col-span-2 md:ml-auto">
                        <h3 class="text-sm font-black uppercase tracking-widest text-zinc-900 dark:text-white mb-6">
                            Explore</h3>
                        <ul class="space-y-4 text-base font-bold text-zinc-500 dark:text-zinc-400">
                            <li><a href="{{ route('prezet.index') }}"
                                    class="hover:text-zinc-900 dark:hover:text-white transition-colors">Home</a></li>
                            <li><a href="{{ route('prezet.index') }}"
                                    class="hover:text-zinc-900 dark:hover:text-white transition-colors">All Articles</a>
                            </li>
                            <li><a href="{{ route('prezet.index') }}"
                                    class="hover:text-zinc-900 dark:hover:text-white transition-colors">Categories</a>
                            </li>
                            <li><a href="{{ route('prezet.index') }}"
                                    class="hover:text-zinc-900 dark:hover:text-white transition-colors">Trending
                                    Tags</a></li>
                        </ul>
                    </div>
                    <div class="md:col-span-3 lg:col-span-2 md:ml-auto">
                        <h3 class="text-sm font-black uppercase tracking-widest text-zinc-900 dark:text-white mb-6">
                            Platform</h3>
                        <ul class="space-y-4 text-base font-bold text-zinc-500 dark:text-zinc-400">
                            <li><a href="https://prezet.com" target="_blank"
                                    class="hover:text-zinc-900 dark:hover:text-white transition-colors">Documentation</a>
                            </li>
                            <li><a href="https://github.com/benbjurstrom/prezet" target="_blank"
                                    class="hover:text-zinc-900 dark:hover:text-white transition-colors">Source Code</a>
                            </li>
                            <li><a href="#"
                                    class="hover:text-zinc-900 dark:hover:text-white transition-colors">Community</a>
                            </li>
                            <li><a href="#"
                                    class="hover:text-zinc-900 dark:hover:text-white transition-colors">Showcase</a>
                            </li>
                        </ul>
                    </div>
                    <div class="md:col-span-2 lg:col-span-3 lg:ml-auto">
                        <h3 class="text-sm font-black uppercase tracking-widest text-zinc-900 dark:text-white mb-6">
                            Support</h3>
                        <ul class="space-y-4 text-base font-bold text-zinc-500 dark:text-zinc-400">
                            <li><a href="#"
                                    class="hover:text-zinc-900 dark:hover:text-white transition-colors">Help Center</a>
                            </li>
                            <li><a href="#"
                                    class="hover:text-zinc-900 dark:hover:text-white transition-colors">Feedback</a>
                            </li>
                            <li><a href="#"
                                    class="hover:text-zinc-900 dark:hover:text-white transition-colors">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div
                    class="mt-20 pt-10 border-t border-zinc-200/50 dark:border-zinc-800/50 flex flex-col md:flex-row justify-between items-center gap-6">
                    <p class="text-sm font-bold text-zinc-400 dark:text-zinc-500">
                        &copy; {{ date('Y') }} Laradoc & Prezet. Crafted with passion.
                    </p>
                    <div class="flex items-center gap-8 text-sm font-bold text-zinc-400 dark:text-zinc-500">
                        <a href="#" class="hover:text-zinc-900 dark:hover:text-white transition-colors">Privacy
                            Policy</a>
                        <a href="#" class="hover:text-zinc-900 dark:hover:text-white transition-colors">Terms of
                            Service</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- Back to Top Button -->
    <button x-show="scrolled" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-8" @click="window.scrollTo({top: 0, behavior: 'smooth'})"
        class="fixed bottom-8 right-8 z-40 w-12 h-12 rounded-full bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white shadow-2xl flex items-center justify-center group outline-none ring-1 ring-zinc-200 dark:ring-zinc-700">
        <svg class="absolute inset-0 w-full h-full -rotate-90" viewBox="0 0 100 100">
            <circle class="text-zinc-100 dark:text-zinc-700/50" stroke-width="6" stroke="currentColor"
                fill="transparent" r="44" cx="50" cy="50" />
            <circle class="text-zinc-900 dark:text-zinc-400 transition-all duration-100" stroke-width="6"
                :stroke-dasharray="2 * Math.PI * 44" :stroke-dashoffset="2 * Math.PI * 44 * (1 - progress / 100)"
                stroke-linecap="round" stroke="currentColor" fill="transparent" r="44" cx="50" cy="50" />
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
            stroke="currentColor" class="size-5 relative z-10 group-hover:-translate-y-1 transition-transform">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" />
        </svg>
    </button>
</body>

</html>
