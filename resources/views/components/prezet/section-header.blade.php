@props(['title', 'link' => null, 'linkLabel' => 'Xem tất cả'])

<div class="mb-12 flex items-end justify-between">
    <div class="space-y-2">
        <h2
            class="text-3xl font-black tracking-tight text-zinc-900 dark:text-white md:text-4xl font-['Be_Vietnam_Pro']">
            {{ $title }}
        </h2>
        <div class="h-1.5 w-20 rounded-full bg-primary-500"></div>
    </div>

    @if ($link)
        <a href="{{ $link }}"
            class="group flex items-center gap-2 text-xs font-black uppercase tracking-widest text-zinc-400 transition-colors hover:text-primary-600">
            {{ $linkLabel }}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"
                class="size-4 transition-transform group-hover:translate-x-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
            </svg>
        </a>
    @endif
</div>