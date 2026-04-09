<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased h-full bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 overflow-hidden">
    <div class="flex flex-col h-full">
        <!-- Minimal Header -->
        <header class="flex-none border-b border-zinc-200 dark:border-zinc-800 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-md z-50">
            <div class="max-w-full mx-auto px-6 h-14 grid grid-cols-3 items-center">
                <div class="flex justify-start">
                    <a href="{{ route('files.index') }}" class="group flex items-center gap-2 text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100 transition-colors" title="Back to files">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-4 group-hover:-translate-x-0.5 transition-transform">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                        <span class="text-xs font-medium uppercase tracking-wider hidden sm:inline">Thư viện</span>
                    </a>
                </div>
                
                <div class="flex justify-center truncate">
                    <h1 class="text-sm font-semibold truncate text-zinc-800 dark:text-zinc-200">{{ $title }}</h1>
                </div>

                <div class="flex justify-end gap-3">
                    @if(isset($actions))
                        {{ $actions }}
                    @endif
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 overflow-auto bg-white dark:bg-zinc-950">
            <div class="max-w-full h-full">
                {{ $slot }}
            </div>
        </main>
    </div>
</body>
</html>
