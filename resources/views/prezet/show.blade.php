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
        'image' => url($document->frontmatter->image),
    ])

    @push('jsonld')
        <script type="application/ld+json">
            {!! $linkedData !!}
        </script>
    @endpush

    <div id="articles-content">
        <x-prezet.alpine class="grid grid-cols-12 gap-8">
            <div class="col-span-12">
                <h1
                    class="mt-6 mb-6 text-3xl !leading-snug font-bold sm:text-4xl md:mb-8 lg:text-5xl lg:!leading-tight dark:text-white">
                    {{ $document->frontmatter->title }}
                </h1>
                <div class="flex items-center justify-between">
                    <ul>
                        <li class="flex items-center gap-1 dark:text-white">
                            @if ($document->category)
                                {{-- <x-icons.tag /> --}}
                                #

                                <a href="{{ route('prezet.show', ['slug' => strtolower($document->category)]) }}">
                                    {{ $document->category }}
                                </a>
                            @endif
                        </li>
                    </ul>
                    <ul class="flex flex-wrap items-center gap-3 font-medium">
                        <li class="w-full sm:w-auto dark:text-white">
                            <a href="#author" class="group flex items-center gap-x-2">
                                <img src="{{ $author['image'] ?? '' }}" alt="{{ $author['name'] }} profile image"
                                    width="26" height="26" loading="lazy" decoding="async"
                                    class="h-[26px] w-[26px] rounded bg-zinc-100 object-cover transition-all duration-300 group-hover:opacity-75 dark:bg-zinc-800" />
                                <span class="group-hover:text-primary transition-all duration-300">
                                    {{ $author['name'] }}
                                </span>
                            </a>
                        </li>
                        <li class="hidden text-zinc-600 sm:inline-block dark:text-zinc-400">
                            —
                        </li>
                        <li class="flex items-center gap-1 text-zinc-600 dark:text-zinc-400">
                            <x-prezet.icon-calendar class="size-5" />
                            <span>{{ $document->createdAt->format('M d, Y') }}</span>
                        </li>
                        <li class="hidden text-zinc-600 sm:inline-block dark:text-zinc-400">
                            —
                        </li>
                        <li class="flex items-center gap-1 text-zinc-600 dark:text-zinc-400">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span>{{ $readingTime }} min read</span>
                        </li>
                    </ul>

                </div>
            </div>
            {{-- Hero Image --}}

            @if ($document->frontmatter->image)
                <div class="-mx-8 sm:mx-0 col-span-12 lg:my-4">
                    <img src="{{ url($document->frontmatter->image) }}" alt="{{ $document->frontmatter->title }}"
                        width="1120" height="595" loading="lazy" decoding="async"
                        class="h-auto max-h-[500px] w-full sm:rounded-2xl bg-zinc-50 object-cover dark:bg-zinc-800" />
                </div>
            @endif


            <div class="col-span-12">
                <div class="h-px w-full border-0 bg-zinc-200 dark:bg-zinc-700"></div>
            </div>

            {{-- Right Sidebar --}}
            <div class="col-span-12 lg:order-last lg:col-span-3">
                <div class="flex-none overflow-y-auto lg:sticky lg:top-[6rem] lg:h-[calc(100vh-4.75rem)] ml-4">
                    <nav aria-labelledby="on-this-page-title">
                        <p id="on-this-page-title"
                            class="font-display text-sm font-medium text-zinc-900 dark:text-zinc-100">
                            On this page
                        </p>
                        <ol role="list" class="mt-4 space-y-3 text-sm">
                            @foreach ($headings as $h2)
                                <li>
                                    <a href="#{{ $h2['id'] }}"
                                        :class="{ '!text-primary-500 !dark:text-primary-400 !hover:text-primary-500': activeHeading === '{{ $h2['id'] }}' }"
                                        x-on:click.prevent="scrollToHeading('{{ $h2['id'] }}')"
                                        class="text-zinc-700 transition-colors dark:text-zinc-300">
                                        {{ $h2['title'] }}
                                    </a>

                                    @if ($h2['children'])
                                        <ol role="list" class="mt-2 space-y-3 border-l pl-5">
                                            @foreach ($h2['children'] as $h3)
                                                <li>
                                                    <a href="#{{ $h3['id'] }}"
                                                        :class="{ '!text-primary-500 !dark:text-primary-400 !hover:text-primary-500': activeHeading === '{{ $h3['id'] }}' }"
                                                        x-on:click.prevent="scrollToHeading('{{ $h3['id'] }}')"
                                                        class="text-zinc-700 transition-colors dark:text-zinc-300">
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
                {{-- prose-pre:-mx-8 prose-pre:rounded-none --}}
                <article
                    class="prose-pre:rounded-xl prose-headings:font-display prose prose-zinc prose-a:border-b prose-a:border-dashed prose-a:border-black/30 prose-a:font-semibold prose-a:no-underline prose-a:hover:border-solid prose-img:rounded-sm dark:prose-invert max-w-none">
                    {!! $body !!}
                </article>

                <div class="border-dark/5 my-10 flex flex-col justify-start gap-y-5 border-t pt-10">
                    @if ($document->frontmatter->tags)
                        <ul class="flex flex-wrap items-center gap-2 sm:gap-3">
                            <li>
                                @foreach ($document->frontmatter->tags as $tag)
                                    <a href="{{ route('prezet.index', ['tag' => strtolower($tag)]) }}"
                                        class="inline-flex items-center rounded-md bg-zinc-50 px-3 py-1.5 text-xs text-zinc-800 ring-1 ring-zinc-500/10 transition ring-inset hover:bg-zinc-200 dark:bg-zinc-700 dark:text-zinc-200 dark:ring-zinc-700 dark:hover:bg-zinc-600">
                                        <x-prezet.icon-tag class="mr-1 h-3 w-3" />

                                        {{ $tag }}
                                    </a>
                                @endforeach
                            </li>
                        </ul>
                    @endif
                </div>
                <div id="author"
                    class="flex flex-col items-start gap-x-6 gap-y-4 rounded-xl bg-zinc-50 p-6 ring-1 ring-zinc-500/10 ring-inset md:flex-row md:p-7 dark:bg-zinc-800 dark:text-zinc-300">
                    <img src="{{ $author['image'] }}" alt="profile image of {{ $author['name'] }}" width="135"
                        height="135" loading="lazy" decoding="async"
                        class="h-24 w-24 rounded-xl bg-zinc-100 object-cover md:h-[135px] md:w-[135px] dark:bg-zinc-800" />
                    <div>
                        <p class="text-[20px] font-medium text-black md:text-2xl dark:text-white">
                            {{ $author['name'] }}
                        </p>
                        <div class="mt-2 text-zinc-600 md:mt-3 dark:text-zinc-400">
                            <p class="dark">
                                {{ $author['bio'] }}
                            </p>
                        </div>
                        <a class="hover:text-primary dark:hover:text-primary-dark mt-3 flex w-fit items-center gap-x-1 text-sm font-medium underline md:text-base dark:text-zinc-200"
                            href="{{ route('prezet.index', ['author' => strtolower($document->frontmatter->author)]) }}">
                            More posts from {{ $author['name'] }}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                            </svg>
                        </a>
                    </div>
                </div>

                @if ($relatedPosts->isNotEmpty())
                    <div class="mt-16 mb-16 border-t border-zinc-200 pt-16 dark:border-zinc-700">
                        <h3 class="mb-8 text-2xl font-bold text-zinc-900 dark:text-white">Related Articles</h3>
                        <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                            @foreach ($relatedPosts as $relatedPost)
                                <x-prezet.article :article="$relatedPost" :author="config('prezet.authors.' . $relatedPost->frontmatter->author)" />
                            @endforeach
                        </div>
                    </div>
                @endif
        </x-prezet.alpine>
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
