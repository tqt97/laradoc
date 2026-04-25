@props(['article', 'readingTime' => null])

<article class="relative group h-125 w-full overflow-hidden rounded-2xl bg-zinc-900 shadow-2xl">
    {{-- Article Image with Overlay --}}
    <div class="absolute inset-0 z-0">
        @if ($article->frontmatter->image)
            <img src="{{ url($article->frontmatter->image) }}" alt="{{ $article->frontmatter->title }}"
                class="h-full w-full object-cover opacity-60 transition-transform duration-700 group-hover:scale-110" />
        @endif
        <div class="absolute inset-0 bg-linear-to-t from-black via-black/40 to-transparent"></div>
    </div>

    {{-- Content --}}
    <div class="relative z-10 flex h-full flex-col justify-end p-8 md:p-12">
        <div class="mb-4 flex flex-wrap items-center gap-4">
            @if ($article->category)
                <a href="{{ route('prezet.articles', ['category' => strtolower($article->category)]) }}"
                    class="rounded-full bg-primary-600 px-4 py-1 text-[10px] font-black uppercase tracking-[0.2em] text-white shadow-lg">
                    {{ $article->category }}
                </a>
            @endif
            <div class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-widest text-zinc-300">
                <time datetime="{{ $article->createdAt->toIso8601String() }}">
                    {{ $article->createdAt->format('d/m/Y') }}
                </time>
                <span>&bull;</span>
                <span>{{ $readingTime ?? 1 }} phút đọc</span>
            </div>
        </div>

        <h2 class="mb-6 text-3xl font-black leading-tight text-white md:text-5xl lg:max-w-3xl font-['Be_Vietnam_Pro']">
            <a href="{{ route('prezet.show', $article->slug) }}">
                <span class="absolute inset-0 z-10" aria-hidden="true"></span>
                {{ $article->frontmatter->title }}
            </a>
        </h2>

        <p class="mb-8 text-zinc-300 md:text-lg lg:max-w-2xl line-clamp-2">
            {{ $article->frontmatter->excerpt }}
        </p>

        <div class="flex items-center gap-4">
            <span
                class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-widest text-white group-hover:text-primary-400 transition-colors">
                Đọc bài viết
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                    stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </span>
        </div>
    </div>
</article>
