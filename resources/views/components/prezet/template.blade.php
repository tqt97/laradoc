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

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="alternate icon" type="image/png" href="/favicon.ico">

    <x-prezet.meta />

    <!-- Scripts -->
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
    class="font-['Be_Vietnam_Pro'] antialiased bg-white dark:bg-zinc-950 selection:bg-zinc-900 selection:text-white dark:selection:bg-white dark:selection:text-zinc-900"
    x-data="{
        scrolled: false,
        progress: 0,
        showSidebar: false,
        lastScrollY: 0,
        showHeader: true,
        updateScroll() {
            const h = document.documentElement,
                b = document.body,
                st = 'scrollTop',
                sh = 'scrollHeight';
            const progress = (h[st] || b[st]) / ((h[sh] || b[sh]) - h.clientHeight) * 100;
            this.progress = isNaN(progress) ? 0 : Math.min(100, Math.max(0, progress));

            const currentScrollY = window.scrollY;

            if (currentScrollY > this.lastScrollY && currentScrollY > 100) {
                this.showHeader = false;
            } else {
                this.showHeader = true;
            }

            this.lastScrollY = currentScrollY;
            this.scrolled = currentScrollY > 500;
        }
    }" x-init="updateScroll();
    window.addEventListener('scroll', () => updateScroll())">

    <div class="min-h-screen flex flex-col transition-colors duration-300">
        <div class="fixed top-0 left-0 w-full h-[2.5px] bg-transparent overflow-hidden pointer-events-none z-[60]">
            <div class="h-full bg-primary-400 dark:bg-primary-400 transition-all duration-300 ease-out shadow-[0_0_10px_rgba(0,0,0,0.1)] dark:shadow-[0_0_10px_rgba(255,255,255,0.1)]"
                :style="`width: ${progress}%`" x-show="progress > 0"></div>
        </div>
        <x-prezet.header />

        @isset($fullWidthTop)
            {{ $fullWidthTop }}
        @endisset

        <main class="flex-grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            {{ $slot }}
        </main>

        <footer class="bg-zinc-900 dark:bg-black border-t border-zinc-800 mt-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="flex flex-col items-center text-center space-y-16">
                    {{-- Newsletter Section --}}
                    <x-prezet.newsletter />

                    <div class="w-full h-px bg-zinc-800"></div>

                    {{-- Simple Footer Bottom --}}
                    <div class="flex flex-col md:flex-row justify-between items-center w-full gap-8">
                        <div class="flex items-center gap-6">
                            <x-prezet.logo />
                            <p class="text-sm font-bold text-zinc-400">
                                &copy; {{ date('Y') }} <a
                                    class="text-primary-800 hover:text-primary-600 hover:underline"
                                    href="/">TuanTQ</a> - Chia sẻ và lưu trữ kiến thức.
                            </p>
                        </div>

                        <div class="flex items-center gap-8 text-sm font-bold device-x">
                            <a href="{{ route('prezet.index') }}"
                                class="text-zinc-400 hover:text-primary-500 transition-colors">Bài viết</a>
                            <a href="{{ route('prezet.series.index') }}"
                                class="text-zinc-400 hover:text-primary-500 transition-colors">Chuỗi bài viết</a>
                            <a href="{{ route('links.index') }}"
                                class="text-zinc-400 hover:text-primary-500 transition-colors">Liên kết</a>
                            <a href="{{ route('snippets.index') }}"
                                class="text-zinc-400 hover:text-primary-500 transition-colors">Snippets</a>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    {{-- Toast Container --}}
    <div id="toast-container"
        class="fixed top-24 right-4 z-[110] flex flex-col gap-4 w-full max-w-sm pointer-events-none">
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8"
                x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-8"
                class="p-4 rounded-3xl bg-emerald-400 text-white font-bold text-sm shadow-2xl flex items-center gap-3 pointer-events-auto">
                <div class="size-8 rounded-full bg-white/20 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                        stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </div>
                <p>
                    @if (is_string(session('success')))
                        {{ session('success') }}
                    @else
                        Thao tác thành công!
                    @endif
                </p>
            </div>
        @endif

        @if ($errors->any())
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 6000)"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8"
                x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-8"
                class="p-4 rounded-3xl bg-red-500 text-white font-bold text-sm shadow-2xl flex items-start gap-3 pointer-events-auto">
                <div class="size-8 rounded-full bg-white/20 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                        stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </div>
                <div class="flex-grow pt-1">
                    <ul class="list-none p-0 m-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
    </div>

    <!-- Back to Top Button -->
    <button x-show="scrolled" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-8" @click="window.scrollTo({top: 0, behavior: 'smooth'})"
        class="fixed bottom-6 right-6 z-40 size-10 sm:size-12 rounded-full bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white shadow-2xl flex items-center justify-center group outline-none ring-1 ring-zinc-200 dark:ring-zinc-700 hover:cursor-pointer">
        <svg class="absolute inset-0 w-full h-full -rotate-90" viewBox="0 0 100 100">
            <circle class="text-zinc-100 dark:text-zinc-700/50" stroke-width="6" stroke="currentColor"
                fill="transparent" r="44" cx="50" cy="50" />
            <circle class="text-primary-500 dark:text-primary-400 transition-all duration-100" stroke-width="6"
                :stroke-dasharray="2 * Math.PI * 44" :stroke-dashoffset="2 * Math.PI * 44 * (1 - progress / 100)"
                stroke-linecap="round" stroke="currentColor" fill="transparent" r="44" cx="50"
                cy="50" />
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
            stroke="currentColor"
            class="size-4 sm:size-5 relative z-10 group-hover:-translate-y-1 transition-transform text-primary-500">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" />
        </svg>
    </button>
</body>

</html>
