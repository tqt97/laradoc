@props(['series'])

<div
    {{ $attributes->merge([
        'class' => 'group relative flex flex-col rounded-3xl bg-zinc-50/50 text-zinc-900 ring-1 ring-zinc-500/10 transition-all hover:bg-white hover:ring-zinc-500/20 dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-zinc-100 dark:ring-zinc-700 dark:hover:bg-zinc-900 dark:hover:ring-zinc-600 overflow-hidden p-8'
    ]) }}>
    
    {{-- Absolute Article Count Badge --}}
    <div class="absolute top-6 right-6 flex flex-col items-center">
        <span class="text-2xl font-black text-primary-500 dark:text-primary-400 leading-none mb-1">{{ $series->postCount }}</span>
        <span class="text-[8px] font-black uppercase tracking-widest text-zinc-400">Bài viết</span>
    </div>

    <div class="flex-grow flex flex-col">
        <div class="flex items-center gap-4 mb-6">
            <div class="flex flex-col">
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-primary-600 dark:text-primary-400">
                    Chuỗi bài viết
                </span>
            </div>
        </div>

        <h3 class="text-2xl font-bold text-zinc-900 dark:text-white mb-4 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors leading-tight">
            {{ $series->data->frontmatter->title ?? $series->title }}
        </h3>

        <p class="text-zinc-500 dark:text-zinc-400 text-sm leading-relaxed line-clamp-3 mb-8">
            {{ $series->data->frontmatter->excerpt ?? 'Khám phá chuỗi bài viết chi tiết về ' . ($series->data->frontmatter->title ?? $series->title) }}
        </p>
    </div>

    <div class="pt-6 border-t border-zinc-100 dark:border-zinc-800 flex items-center justify-between mt-auto">
        <div class="flex items-center gap-2 text-xs font-bold text-zinc-400 leading-none">
            <x-prezet.icon-calendar class="size-3.5 mb-0.5" />
            <time datetime="{{ $series->data->createdAt->toIso8601String() }}">
                {{ $series->data->createdAt->format('d/m/Y') }}
            </time>
        </div>

        <div class="text-primary-500 flex items-center gap-2 text-sm font-bold opacity-60 group-hover:opacity-100 transition-opacity leading-none">
            <span>Bắt đầu đọc</span>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke-width="2.5" stroke="currentColor" class="size-4 group-hover:translate-x-1 transition-transform mb-0.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
            </svg>
        </div>
    </div>

    {{-- Link Overlay --}}
    <a href="{{ route('prezet.series.show', $series->slug . '/index') }}"
        class="absolute inset-0 z-10" aria-label="{{ $series->title }}"></a>
</div>
