@props(['article', 'readingTime' => null])

<article class="group relative flex items-start gap-6 py-1 border-b border-zinc-100 dark:border-zinc-800 last:border-0">
    <div class="relative h-24 w-24 shrink-0 overflow-hidden rounded-2xl bg-zinc-100 dark:bg-zinc-800">
        @if ($article->frontmatter->image)
            <img src="{{ url($article->frontmatter->image) }}" alt="{{ $article->frontmatter->title }}"
                class="h-full w-full object-cover transition duration-300 group-hover:scale-110" />
        @endif
    </div>

    <div class="flex flex-col">
        <div
            class="mb-2 flex items-center gap-3 text-[10px] font-black uppercase tracking-widest text-primary-600 dark:text-primary-400">
            <span>{{ $article->category }}</span>
            <span class="text-zinc-300 dark:text-zinc-700">&bull;</span>
            <time class="text-zinc-400 dark:text-zinc-500" datetime="{{ $article->createdAt->toIso8601String() }}">
                {{ $article->createdAt->format('d/m/Y') }}
            </time>
        </div>

        <h3
            class="text-lg font-bold leading-snug text-zinc-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors line-clamp-2">
            <a href="{{ route('prezet.show', $article->slug) }}">
                <span class="absolute inset-0 z-10" aria-hidden="true"></span>
                {{ $article->frontmatter->title }}
            </a>
        </h3>
    </div>
</article>
