@props(['article', 'author', 'hideImage' => false])

<article
    class="relative group flex flex-col rounded-2xl bg-zinc-50/50 text-zinc-900 ring-1 ring-zinc-500/10 transition-all hover:bg-zinc-50 hover:ring-zinc-500/20 dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-zinc-100 dark:ring-zinc-700 dark:hover:bg-zinc-800 dark:hover:ring-zinc-600 overflow-hidden">

    @if (!$hideImage)
        {{-- Article Image --}}
        <div class="relative aspect-video w-full overflow-hidden bg-zinc-200 dark:bg-zinc-700">
            @if ($article->frontmatter->image)
                <img src="{{ url($article->frontmatter->image) }}" alt="{{ $article->frontmatter->title }}"
                    class="absolute inset-0 h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                    loading="lazy" />
            @else
                <div
                    class="absolute inset-0 flex items-center justify-center bg-linear-to-br from-zinc-100 to-zinc-200 dark:from-zinc-800 dark:to-zinc-900">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1"
                        stroke="currentColor" class="size-12 text-zinc-300 dark:text-zinc-700">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                    </svg>
                </div>
            @endif

            @if ($article->category)
                <div class="absolute top-4 left-4 z-20">
                    <a href="{{ route('prezet.index', ['category' => strtolower($article->category)]) }}"
                        class="relative rounded-full bg-white/90 px-3 py-1 text-xs font-bold text-zinc-900 backdrop-blur-sm transition hover:bg-white dark:bg-black/50 dark:text-white dark:hover:bg-black/70">
                        {{ strtoupper($article->category) }}
                    </a>
                </div>
            @endif
        </div>
    @endif

    <div class="flex flex-1 flex-col p-6 space-y-4">
        @if ($hideImage && $article->category)
            <div class="relative z-20 text-[10px] font-bold tracking-widest text-primary-600 dark:text-primary-400 uppercase">
                <a href="{{ route('prezet.index', ['category' => strtolower($article->category)]) }}" class="hover:underline">
                    {{ $article->category }}
                </a>
            </div>
        @endif

        <h2
            class="text-xl leading-tight font-bold tracking-tight text-zinc-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
            <a href="{{ route('prezet.show', $article->slug) }}">
                <span class="absolute inset-0 z-10" aria-hidden="true"></span>
                {{ $article->frontmatter->title }}
            </a>
        </h2>

        <p class="text-zinc-500 dark:text-zinc-400 leading-relaxed line-clamp-2 text-sm">
            {{ $article->frontmatter->excerpt }}
        </p>

        <div class="mt-auto pt-4 flex flex-col gap-4">
            <div class="relative z-20 flex items-center justify-between text-xs">
                <a href="{{ route('prezet.index', ['author' => strtolower($article->frontmatter->author)]) }}"
                    class="group/author flex items-center gap-2">
                    @if ($author['image'])
                        <img src="{{ $author['image'] }}" alt="{{ $author['name'] ?? 'Author' }}"
                            class="h-6 w-6 rounded-full bg-zinc-100 object-cover ring-2 ring-white dark:bg-zinc-800 dark:ring-zinc-900" />
                    @else
                        <div
                            class="flex h-6 w-6 items-center justify-center rounded-full bg-zinc-100 text-zinc-400 ring-2 ring-white dark:bg-zinc-800 dark:ring-zinc-900">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                        </div>
                    @endif
                    <span
                        class="font-semibold text-zinc-700 dark:text-zinc-300 group-hover/author:text-primary-600 dark:group-hover/author:text-primary-400 transition-colors">
                        {{ $author['name'] ?? 'Anonymous' }}
                    </span>
                </a>

                <div class="flex items-center gap-4 text-zinc-400">
                    <div class="flex items-center gap-1.5">
                        <x-prezet.icon-calendar class="size-3.5" />
                        <time datetime="{{ $article->createdAt->toIso8601String() }}">
                            {{ $article->createdAt->format('d/m/Y') }}
                        </time>
                    </div>
                    @if (isset($article->readingTime))
                        <div class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span>{{ $article->readingTime }} phút</span>
                        </div>
                    @endif
                </div>
            </div>

            @if (isset($article->frontmatter->tags) && count($article->frontmatter->tags) > 0)
                <div class="relative z-20 flex flex-wrap gap-1.5">
                    @foreach (array_slice($article->frontmatter->tags, 0, 3) as $tag)
                        <a href="{{ route('prezet.index', ['tag' => strtolower($tag)]) }}"
                            class="inline-flex items-center rounded-md bg-zinc-100 dark:bg-zinc-800/50 px-2 py-0.5 text-[10px] font-medium text-zinc-600 dark:text-zinc-400 transition-colors hover:bg-zinc-200 dark:hover:bg-zinc-700">
                            <x-prezet.icon-tag class="mr-1 size-2.5" />
                            {{ $tag }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</article>
