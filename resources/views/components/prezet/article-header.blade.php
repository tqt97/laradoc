@props(['document', 'author', 'readingTime', 'hideImage' => true])

<div {{ $attributes->merge(['class' => 'pb-8 border-b border-zinc-100']) }}>
    @if ($document->category)
        <div class="mb-4">
            <a href="{{ route('prezet.articles', ['category' => strtolower($document->category)]) }}"
                class="inline-flex items-center rounded-full bg-primary-100 px-3 py-1 text-xs font-semibold text-primary-700 transition-colors hover:bg-primary-200 dark:bg-primary-900/30 dark:text-primary-400 dark:hover:bg-primary-900/50">
                {{ $document->category }}
            </a>
        </div>
    @endif

    <h1 class="mb-6 text-3xl font-bold !leading-tight text-zinc-900 sm:text-4xl md:text-5xl dark:text-white">
        {{ $document->frontmatter->title }}
    </h1>

    <div class="flex flex-wrap items-center gap-4 dark:border-zinc-800">
        <div class="flex items-center gap-3">
            {{-- @if ($author['image'])
                <a href="{{ route('prezet.articles', ['author' => strtolower($document->frontmatter->author)]) }}"
                    class="shrink-0">
                    <img src="{{ $author['image'] }}" alt="{{ $author['name'] }}"
                        class="h-10 w-10 rounded-full bg-zinc-100 object-cover ring-2 ring-white transition-opacity hover:opacity-90 dark:bg-zinc-800 dark:ring-zinc-900" />
                </a>
            @else
                <div
                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-zinc-100 text-zinc-400 dark:bg-zinc-800">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </div>
            @endif --}}

            <div class="flex flex-col">
                {{-- <a href="{{ route('prezet.articles', ['author' => strtolower($document->frontmatter->author)]) }}"
                    class="text-sm font-semibold text-zinc-900 hover:text-primary-600 dark:text-zinc-100 dark:hover:text-primary-400">
                    {{ $author['name'] }}
                </a> --}}
                <div class="flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400">
                    <time datetime="{{ $document->createdAt->format('Y-m-d') }}" class="flex items-center gap-1">
                        <x-prezet.icon-calendar class="size-3" />
                        {{ $document->createdAt->format('d/m/Y') }}
                    </time>
                    <span class="text-zinc-300 dark:text-zinc-700">&bull;</span>
                    <span class="flex items-center gap-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-3">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        {{ $readingTime }} phút đọc
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Hero Image --}}
    @if (!$hideImage && $document->frontmatter->image)
        <div class="mt-6">
            <img src="{{ url($document->frontmatter->image) }}" alt="{{ $document->frontmatter->title }}"
                width="1120" height="595" loading="lazy" decoding="async"
                class="h-auto max-h-[500px] w-full rounded-3xl bg-zinc-50 object-cover dark:bg-zinc-800 ring-1 ring-zinc-200 dark:ring-zinc-800" />
        </div>
    @endif
</div>
