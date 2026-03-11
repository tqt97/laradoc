<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="alternate icon" type="image/png" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/favicon.svg">

    <x-prezet.meta />

    <!-- Fonts Preload -->
    <link rel="preload" href="/build/assets/be-vietnam-pro-v12-latin_vietnamese-regular-CnRXpc0c.woff2" as="font" type="font/woff2" crossorigin>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('jsonld')

    <script>
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
    class="font-sans antialiased bg-white dark:bg-zinc-950 selection:bg-zinc-900 selection:text-white dark:selection:bg-white dark:selection:text-zinc-900"
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
    window.addEventListener('scroll', () => updateScroll());">

    <div class="min-h-screen flex flex-col transition-colors duration-300">
        <div class="fixed top-0 left-0 w-full h-[2.5px] bg-transparent overflow-hidden pointer-events-none z-[60]">
            <div class="h-full bg-primary-400 dark:bg-primary-400 transition-all duration-300 ease-out shadow-[0_0_10px_rgba(0,0,0,0.1)] dark:shadow-[0_0_10px_rgba(255,255,255,0.1)]"
                :style="`width: ${progress}%`" x-show="progress > 0"></div>
        </div>
        <x-prezet.header />

        @isset($fullWidthTop)
            {{ $fullWidthTop }}
        @endisset

        <main class="grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            {{ $slot }}
        </main>

        <x-prezet.footer />
    </div>

    {{-- Toast Notifications --}}
    @include('prezet.toast')

    {{-- Back to Top Button --}}
    <x-prezet.back-to-top />
</body>

</html>
