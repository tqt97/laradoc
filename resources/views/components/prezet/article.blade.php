@props(['article', 'author'])

<article
    class="relative group rounded-2xl bg-zinc-50/50 p-6 text-zinc-900 ring-1 ring-zinc-500/10 transition-all hover:bg-zinc-50 hover:ring-zinc-500/20 dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-zinc-100 dark:ring-zinc-700 dark:hover:bg-zinc-800 dark:hover:ring-zinc-600">
    <div class="space-y-4">
        <div class="relative z-10 text-sm">
            @if ($article->category)
                <a href="{{ route('prezet.index', ['category' => strtolower($article->category)]) }}#articles"
                    class="font-semibold text-zinc-400 transition-colors hover:text-zinc-900 dark:text-zinc-500 dark:hover:text-zinc-300">
                    # {{ strtoupper($article->category) }}
                </a>
            @endif
        </div>

        <h2 class="text-2xl leading-tight font-bold tracking-tight text-zinc-900 dark:text-white">
            <a href="{{ route('prezet.show', $article->slug) }}">
                <span class="absolute inset-0 z-0"></span>
                {{ $article->frontmatter->title }}
            </a>
        </h2>

        <p class="text-zinc-500 dark:text-zinc-400 leading-relaxed line-clamp-2">
            {{ $article->frontmatter->excerpt }}
        </p>

        <div class="relative z-10 flex flex-wrap items-center gap-y-4 gap-x-6 text-sm dark:text-zinc-400">
            <a href="{{ route('prezet.index', ['author' => strtolower($article->frontmatter->author)]) }}#articles"
                class="group/author flex items-center gap-2">
                <img src="{{ $author['image'] ?? '' }}" alt="{{ $author['name'] ?? 'Author' }}"
                    class="h-6 w-6 rounded-full bg-zinc-100 object-cover dark:bg-zinc-800" />
                <span
                    class="font-semibold text-zinc-700 dark:text-zinc-300 group-hover/author:text-zinc-900 dark:group-hover/author:text-white transition-colors">
                    {{ $author['name'] ?? 'Anonymous' }}
                </span>
            </a>

            <div class="flex items-center gap-1.5 font-medium text-zinc-400">
                <x-prezet.icon-calendar class="size-4" />
                <time datetime="{{ $article->createdAt->toIso8601String() }}">
                    {{ $article->createdAt->format('M j, Y') }}
                </time>
            </div>
        </div>

        @if (isset($article->frontmatter->tags) && count($article->frontmatter->tags) > 0)
            <div class="relative z-10 flex flex-wrap gap-2 pt-2">
                @foreach ($article->frontmatter->tags as $tag)
                    <a href="{{ route('prezet.index', ['tag' => strtolower($tag)]) }}"
                        class="inline-flex items-center rounded-lg bg-white dark:bg-zinc-900 px-2.5 py-1 text-xs font-bold text-zinc-500 dark:text-zinc-400 border border-zinc-200 dark:border-zinc-700 transition-colors hover:border-zinc-900 hover:text-zinc-900 dark:hover:border-zinc-300 dark:hover:text-zinc-200">
                        {{ $tag }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</article>
