@props(['document', 'readingTime', 'hideImage' => false])

<div {{ $attributes->merge(['class' => '']) }}>
    @if ($document->category)
        <div class="mb-4">
            <a href="{{ route('prezet.articles', ['category' => strtolower($document->category)]) }}"
                class="inline-flex items-center rounded-3xl bg-primary-100 px-3 py-1 text-xs font-semibold text-primary-500 transition-colors hover:bg-primary-200 dark:bg-primary-900/30 dark:text-primary-400 dark:hover:bg-primary-900/50">
                {{ $document->category }}
            </a>
        </div>
    @endif

    <h1 class="mb-6 text-3xl font-bold leading-tight! text-zinc-900 sm:text-4xl md:text-5xl dark:text-white font-['Be_Vietnam_Pro']">
        {{ $document->frontmatter->title }}
    </h1>

    <div class="flex flex-wrap items-center gap-4 border-b border-zinc-200 pb-8 dark:border-zinc-800">
        <div class="flex items-center gap-6 text-xs font-bold text-zinc-500 dark:text-zinc-400">
            <time datetime="{{ $document->createdAt->format('Y-m-d') }}"
                class="flex items-center gap-1.5 leading-none">
                <x-prezet.icon-calendar class="size-3.5 mb-0.5" />
                {{ $document->createdAt->format('d/m/Y') }}
            </time>
            <span class="text-zinc-300 dark:text-zinc-700">&bull;</span>
            <span class="flex items-center gap-1.5 leading-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" class="size-3.5 mb-0.5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                {{ $readingTime }} phút đọc
            </span>
        </div>
    </div>

    {{-- Hero Image --}}
    @if ($hideImage && $document->frontmatter->image)
        <div class="mt-8">
            <img src="{{ url($document->frontmatter->image) }}" alt="{{ $document->frontmatter->title }}"
                width="1120" height="595" loading="lazy" decoding="async"
                class="h-auto max-h-125 w-full rounded-3xl bg-zinc-50 object-cover dark:bg-zinc-800 ring-1 ring-zinc-200 dark:ring-zinc-800" />
        </div>
    @endif
</div>
