@php
    /* @var string $body */
    /* @var array $nav */
    /* @var array $headings */
    /* @var string $linkedData */
    /* @var \Prezet\Prezet\Data\DocumentData $document */
@endphp

<x-prezet.template>
    @seo([
        'title' => $document->frontmatter->title,
        'description' => $document->frontmatter->excerpt,
        'url' => route('prezet.show', ['slug' => $document->slug]),
        'image' => $document->frontmatter->image ? url($document->frontmatter->image) : null,
    ])

    @push('jsonld')
        <script type="application/ld+json">
            {!! $linkedData !!}
        </script>
    @endpush

    <div id="articles" class="py-12 lg:py-24 scroll-mt-24">
        <div id="articles-content">
            <x-prezet.alpine class="grid grid-cols-12 gap-8">
                <div class="col-span-12">
                    @if ($document->category)
                        <div class="mb-4">
                            <a href="{{ route('prezet.index', ['category' => strtolower($document->category)]) }}"
                                class="inline-flex items-center rounded-full bg-primary-100 px-3 py-1 text-xs font-semibold text-primary-700 transition-colors hover:bg-primary-200 dark:bg-primary-900/30 dark:text-primary-400 dark:hover:bg-primary-900/50">
                                {{ $document->category }}
                            </a>
                        </div>
                    @endif

                    <h1
                        class="mb-6 text-3xl font-bold !leading-tight text-zinc-900 sm:text-4xl md:text-5xl dark:text-white">
                        {{ $document->frontmatter->title }}
                    </h1>

                    <div class="flex flex-wrap items-center gap-4 border-b border-zinc-200 pb-8 dark:border-zinc-800">
                        <div class="flex items-center gap-3">
                            @if ($author['image'])
                                <a href="#author" class="shrink-0">
                                    <img src="{{ $author['image'] }}" alt="{{ $author['name'] }}"
                                        class="h-10 w-10 rounded-full bg-zinc-100 object-cover ring-2 ring-white transition-opacity hover:opacity-90 dark:bg-zinc-800 dark:ring-zinc-900" />
                                </a>
                            @else
                                <div
                                    class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-zinc-100 text-zinc-400 dark:bg-zinc-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                </div>
                            @endif

                            <div class="flex flex-col">
                                <a href="#author"
                                    class="text-sm font-semibold text-zinc-900 hover:text-primary-600 dark:text-zinc-100 dark:hover:text-primary-400">
                                    {{ $author['name'] }}
                                </a>
                                <div class="flex items-center gap-2 text-xs text-zinc-500 dark:text-zinc-400">
                                    <time datetime="{{ $document->createdAt->format('Y-m-d') }}"
                                        class="flex items-center gap-1">
                                        <x-prezet.icon-calendar class="size-3" />
                                        {{ $document->createdAt->format('d/m/Y') }}
                                    </time>
                                    <span class="text-zinc-300 dark:text-zinc-700">&bull;</span>
                                    <span class="flex items-center gap-1">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-3">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                        </svg>
                                        {{ $readingTime }} phút đọc
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Hero Image --}}
                @if ($document->frontmatter->image)
                    <div class="-mx-8 sm:mx-0 col-span-12 lg:my-4 mx-auto">
                        <img src="{{ url($document->frontmatter->image) }}" alt="{{ $document->frontmatter->title }}"
                            width="1120" height="595" loading="lazy" decoding="async"
                            class="h-auto max-h-[500px] w-full sm:rounded-2xl bg-zinc-50 object-cover dark:bg-zinc-800" />
                    </div>

                    <div class="col-span-12">
                        <div class="h-px w-full border-0 bg-zinc-200 dark:bg-zinc-700"></div>
                    </div>
                @endif

                {{-- Right Sidebar --}}
                <div class="col-span-12 lg:order-last lg:col-span-3">
                    <div class="flex-none overflow-y-auto lg:sticky lg:top-[6rem] lg:h-[calc(100vh-4.75rem)] ml-4">
                        <nav aria-labelledby="on-this-page-title" class="px-2">
                            <div class="flex items-center gap-2 mb-6">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="size-4 text-primary-500">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-3.75 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                                </svg>
                                <p id="on-this-page-title"
                                    class="font-bold text-xs uppercase tracking-[0.2em] text-zinc-900 dark:text-zinc-100">
                                    Mục lục
                                </p>
                            </div>
                            <ol role="list" class="space-y-4 text-sm border-l border-zinc-100 dark:border-zinc-800">
                                @foreach ($headings as $h2)
                                    <li class="relative">
                                        <div x-show="activeHeading === '{{ $h2['id'] }}'"
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 -translate-x-1"
                                            x-transition:enter-end="opacity-100 translate-x-0"
                                            class="absolute -left-px top-0 h-full w-0.5 bg-primary-500"></div>

                                        <a href="#{{ $h2['id'] }}"
                                            :class="activeHeading === '{{ $h2['id'] }}' ?
                                                'text-primary-600 dark:text-primary-400' :
                                                'text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-200'"
                                            x-on:click.prevent="scrollToHeading('{{ $h2['id'] }}')"
                                            class="block pl-4 py-1 transition-all duration-200 leading-relaxed">
                                            {{ $h2['title'] }}
                                        </a>

                                        @if ($h2['children'])
                                            <ol role="list" class="mt-2 space-y-2">
                                                @foreach ($h2['children'] as $h3)
                                                    <li class="relative">
                                                        <div x-show="activeHeading === '{{ $h3['id'] }}'"
                                                            x-transition:enter="transition ease-out duration-200"
                                                            x-transition:enter-start="opacity-0 -translate-x-1"
                                                            x-transition:enter-end="opacity-100 translate-x-0"
                                                            class="absolute -left-px top-0 h-full w-0.5 bg-primary-500/50">
                                                        </div>

                                                        <a href="#{{ $h3['id'] }}"
                                                            :class="activeHeading === '{{ $h3['id'] }}' ?
                                                                'text-primary-600 dark:text-primary-400' :
                                                                'text-zinc-400 hover:text-zinc-700 dark:text-zinc-500 dark:hover:text-zinc-300'"
                                                            x-on:click.prevent="scrollToHeading('{{ $h3['id'] }}')"
                                                            class="block pl-8 py-1 text-xs transition-all duration-200 leading-relaxed">
                                                            {{ $h3['title'] }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ol>
                                        @endif
                                    </li>
                                @endforeach
                            </ol>
                        </nav>
                    </div>
                </div>

                <div class="col-span-12 lg:hidden">
                    <div class="h-px w-full border-0 bg-zinc-200 dark:bg-zinc-700"></div>
                </div>

                {{-- Main Content --}}
                <div class="col-span-12 lg:col-span-9">
                    <article
                        class="prose-pre:rounded-xl prose-headings:font-display prose prose-zinc prose-a:border-b prose-a:border-dashed prose-a:border-black/30 prose-a:font-semibold prose-a:no-underline prose-a:hover:border-solid prose-img:rounded-sm dark:prose-invert max-w-none">
                        {!! $body !!}
                    </article>

                    <div
                        class="my-12 flex flex-col justify-start gap-y-5 border-t border-zinc-200 pt-10 dark:border-zinc-800">
                        @if ($document->frontmatter->tags)
                            <div class="flex flex-wrap items-center gap-2">
                                @foreach ($document->frontmatter->tags as $tag)
                                    <a href="{{ route('prezet.index', ['tag' => strtolower($tag)]) }}"
                                        class="inline-flex items-center rounded-md bg-zinc-100 dark:bg-zinc-800/50 px-2.5 py-1 text-xs font-medium text-zinc-600 transition-colors hover:bg-zinc-200 dark:bg-zinc-400 dark:hover:bg-zinc-700">
                                        <x-prezet.icon-tag class="mr-1.5 h-3 w-3" />
                                        {{ $tag }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div id="author"
                        class="mt-12 flex flex-col items-start gap-x-8 gap-y-6 rounded-2xl bg-zinc-50 p-8 ring-1 ring-zinc-900/5 md:flex-row dark:bg-zinc-800/50 dark:ring-white/10">
                        @if ($author['image'])
                            <img src="{{ $author['image'] }}" alt="{{ $author['name'] }}" width="100"
                                height="100" loading="lazy" decoding="async"
                                class="h-24 w-24 rounded-full bg-zinc-100 object-cover ring-4 ring-white dark:bg-zinc-800 dark:ring-zinc-900" />
                        @else
                            <div
                                class="flex h-24 w-24 items-center justify-center rounded-full bg-zinc-100 text-zinc-400 ring-4 ring-white dark:bg-zinc-800 dark:ring-zinc-900">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-12">
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
                                {{ $author['bio'] }}
                            </p>
                            <div class="mt-6">
                                <a href="{{ route('prezet.index', ['author' => strtolower($document->frontmatter->author)]) }}"
                                    class="inline-flex items-center gap-1 text-sm font-semibold text-primary-600 transition-colors hover:text-primary-700 dark:text-primary-400 dark:hover:text-primary-300">
                                    Xem thêm các bài viết của {{ $author['name'] }}
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>

                    @if ($relatedPosts->isNotEmpty())
                        <div class="mt-16 mb-16 border-t border-zinc-200 pt-16 dark:border-zinc-700">
                            <h3 class="mb-8 text-2xl font-bold text-zinc-900 dark:text-white">Bài viết liên quan</h3>
                            <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                                @foreach ($relatedPosts as $relatedPost)
                                    <x-prezet.article :article="$relatedPost->data" :author="$relatedPost->author" :hide-image="true" />
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </x-prezet.alpine>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const article = document.querySelector('article');
            if (!article) return;

            const initCopyButtons = () => {
                article.querySelectorAll('pre').forEach((pre) => {
                    if (pre.dataset.copyInitialized) return;
                    pre.dataset.copyInitialized = 'true';

                    // Ensure pre is relative
                    pre.style.position = 'relative';
                    pre.classList.add('group/copy');

                    const button = document.createElement('button');
                    button.type = 'button';
                    button.className =
                        'absolute top-2 right-2 w-7 h-7 flex items-center justify-center rounded bg-zinc-800/30 text-zinc-500 opacity-0 group-hover/copy:opacity-100 transition-all hover:bg-zinc-800 hover:text-zinc-300 border border-zinc-700/20 cursor-pointer z-10';
                    button.innerHTML = `
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
                    `;

                    button.onclick = async (e) => {
                        e.preventDefault();
                        const code = pre.querySelector('code')?.innerText || pre.innerText;
                        try {
                            await navigator.clipboard.writeText(code);
                            const original = button.innerHTML;
                            button.innerHTML = `
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-emerald-500"><polyline points="20 6 9 17 4 12"/></svg>
                            `;
                            setTimeout(() => button.innerHTML = original, 2000);
                        } catch (err) {
                            console.error('Copy failed', err);
                        }
                    };

                    pre.appendChild(button);
                });
            };

            initCopyButtons();

            // Re-run if content changes (e.g. HTMX)
            const observer = new MutationObserver(initCopyButtons);
            observer.observe(article, {
                childList: true,
                subtree: true
            });
        });
    </script>
</x-prezet.template>
