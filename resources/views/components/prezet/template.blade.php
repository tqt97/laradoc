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
            const progress = (h[st] || b[st]) / ((h[sh] || b[sh]) - h.clientHeight) * 100;
            this.progress = isNaN(progress) ? 0 : Math.min(100, Math.max(0, progress));
            this.scrolled = window.scrollY > 500;
        }
    }" x-init="updateScroll();
    window.addEventListener('scroll', () => updateScroll())">

    <div class="min-h-screen flex flex-col bg-white dark:bg-zinc-950 transition-colors duration-300">
        <x-prezet.header />

        <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            {{ $slot }}
        </main>

        <footer class="bg-zinc-50 dark:bg-zinc-900/30 border-t border-zinc-100 dark:border-zinc-800/50 mt-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="flex flex-col items-center text-center space-y-12">
                    {{-- Compact Newsletter --}}
                    <div class="max-w-2xl w-full">
                        <h3 class="text-2xl font-black text-zinc-900 dark:text-white mb-3 tracking-tight">Bản tin hàng tuần
                        </h3>
                        <p class="text-zinc-500 dark:text-zinc-400 font-medium mb-8">
                            Tham gia cùng các nhà phát triển nhận nội dung Laravel chất lượng hàng tuần.
                        </p>

                        @if (session('success'))
                            <div
                                class="mb-8 p-4 rounded-xl bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 font-bold text-sm">
                                {{ session('success') }}
                            </div>
                        @endif

                        <form action="{{ route('newsletter.subscribe') }}" method="POST"
                            class="flex flex-col sm:flex-row gap-3 max-w-md mx-auto">
                            @csrf
                            <div class="flex-grow relative">
                                <input type="email" name="email" placeholder="Địa chỉ email" required
                                    class="w-full px-5 py-3 rounded-xl bg-white dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700 text-sm focus:ring-2 focus:ring-zinc-900 dark:focus:ring-white transition-all outline-none font-medium shadow-sm" />
                                @error('email')
                                    <span
                                        class="absolute -bottom-6 left-0 text-[10px] text-red-500 font-bold uppercase tracking-wider">{{ $message }}</span>
                                @enderror
                            </div>
                            <button type="submit"
                                class="px-6 py-3 rounded-xl bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 font-bold text-sm shadow-lg hover:scale-[1.02] active:scale-[0.98] transition-all whitespace-nowrap">
                                Đăng ký
                            </button>
                        </form>

                    </div>

                    <div class="w-full h-px bg-zinc-200/50 dark:bg-zinc-800/50"></div>

                    {{-- Simple Footer Bottom --}}
                    <div class="flex flex-col md:flex-row justify-between items-center w-full gap-8">
                        <div class="flex items-center gap-6">
                            <x-prezet.logo />
                            <p class="text-sm font-bold text-zinc-400 dark:text-zinc-500">
                                &copy; {{ date('Y') }} Laradoc & Prezet.
                            </p>
                        </div>

                        <div class="flex items-center gap-8 text-sm font-bold">
                            <a href="{{ route('prezet.index') }}"
                                class="text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white transition-colors">Bài viết</a>
                            <a href="https://github.com/benbjurstrom/prezet" target="_blank"
                                class="text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white transition-colors">GitHub</a>
                            <a href="#"
                                class="text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white transition-colors">Twitter</a>
                        </div>
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
