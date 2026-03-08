@props(['author', 'document'])

<div id="author"
    {{ $attributes->merge(['class' => 'flex flex-col items-start gap-x-8 gap-y-6 rounded-2xl bg-zinc-50 p-8 ring-1 ring-zinc-900/5 md:flex-row dark:bg-zinc-800/50 dark:ring-white/10']) }}>
    @if ($author['image'])
        <img src="{{ $author['image'] }}" alt="{{ $author['name'] }}" width="100" height="100" loading="lazy"
            decoding="async"
            class="h-24 w-24 rounded-full bg-zinc-100 object-cover ring-4 ring-white dark:bg-zinc-800 dark:ring-zinc-900" />
    @else
        <div
            class="flex h-24 w-24 items-center justify-center rounded-full bg-zinc-100 text-zinc-400 ring-4 ring-white dark:bg-zinc-800 dark:ring-zinc-900">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-12">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
            </svg>
        </div>
    @endif

    <div class="flex-1">
        <h3 class="text-xl font-bold text-zinc-900 dark:text-white">
            {{ $author['name'] }}
        </h3>
        <p class="mt-3 text-base leading-relaxed text-zinc-600 dark:text-zinc-400">
            {{ $author['bio'] ?? '' }}
        </p>
        <div class="mt-6">
            <a href="{{ route('prezet.articles', ['author' => strtolower($document->frontmatter->author)]) }}"
                class="inline-flex items-center gap-1 text-sm font-semibold text-primary-600 transition-colors hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                Xem thêm các bài viết của {{ $author['name'] }}
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                </svg>
            </a>
        </div>
    </div>
</div>
