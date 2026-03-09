@props(['title', 'subtitle' => null])

<div
    class="relative py-10 md:py-12 overflow-hidden dark:border-zinc-800/50 bg-white dark:bg-zinc-950">
    {{-- Background Elements --}}
    <div class="absolute inset-0 z-0">
        <div class="absolute top-0 left-1/4 w-64 h-64 bg-primary-500/5 rounded-full blur-[96px]"></div>
        <div class="absolute bottom-0 right-1/4 w-64 h-64 bg-indigo-500/5 rounded-full blur-[96px]"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-5xl font-black tracking-tight text-zinc-900 dark:text-white leading-tight mb-6">
            {{ $title }}
        </h1>

        @if ($subtitle)
            <p class="text-lg text-zinc-500 dark:text-zinc-400 max-w-7xl mx-auto mt-6 leading-relaxed">
                {{ $subtitle }}
            </p>
        @endif

        {{ $slot }}
    </div>
</div>
