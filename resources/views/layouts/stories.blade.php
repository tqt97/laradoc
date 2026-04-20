@php
    /* @var \Illuminate\View\ComponentSlot $slot */
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <x-prezet.meta />
    @vite(['resources/css/app.css', 'resources/css/stories.css', 'resources/js/app.js'])
    <script>
        (function() {
            const stored = localStorage.getItem('theme')
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches
            const useDark = stored === 'dark' || (stored === null && prefersDark)
            if (useDark) document.documentElement.classList.add('dark')
        })()
    </script>
</head>
<body class="antialiased diary-desk min-h-screen py-6 md:py-12 px-2 md:px-4"
    x-data="{
        darkMode: document.documentElement.classList.contains('dark'),
        toggle() {
            this.darkMode = !this.darkMode;
            document.documentElement.classList.toggle('dark', this.darkMode);
            localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
        }
    }">

    {{-- Controls --}}
    <div class="fixed top-4 right-4 md:top-8 md:right-8 z-50 flex gap-3">
        <a href="{{ route('stories.index') }}" class="p-2.5 md:p-3 rounded-full bg-white dark:bg-zinc-800 shadow-lg text-zinc-500 hover:text-primary-500 transition-transform">
            <svg class="size-5 md:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" /></svg>
        </a>
        <button @click="toggle" class="p-2.5 md:p-3 rounded-full bg-white dark:bg-zinc-800 shadow-lg text-zinc-500 hover:text-primary-500 transition-transform">
            <svg x-show="!darkMode" class="size-5 md:size-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M21.752 15.002A9.72 9.72 0 0 1 18 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 0 0 3 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 0 0 9.002-5.998Z" /></svg>
            <svg x-show="darkMode" x-cloak class="size-5 md:size-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 3v2.25m0 13.5V21m8.966-8.966h-2.25M3 12h2.25m13.503-6.997-1.591 1.591M5.509 18.491l-1.591 1.591m12.982 0 1.591-1.591M4.217 4.217l1.591 1.591M12 7.5a4.5 4.5 0 1 1 0 9 4.5 4.5 0 0 1 0-9Z" /></svg>
        </button>
    </div>

    {{ $slot }}

</body>
</html>
