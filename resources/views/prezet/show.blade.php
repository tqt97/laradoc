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

    <div id="articles" class="py-8 lg:py-16 scroll-mt-24">
        <div id="articles-content">
            <x-prezet.alpine class="grid grid-cols-12 gap-8">
                <div class="col-span-12">
                    <x-prezet.article-header :document="$document" :author="$author" :readingTime="$readingTime" />
                </div>

                {{-- Right Sidebar --}}
                <div class="col-span-12 lg:order-last lg:col-span-3">
                    <div class="flex-none overflow-y-auto lg:sticky lg:top-[6rem] lg:h-[calc(100vh-4.75rem)] ml-4">
                        <x-prezet.toc :headings="$headings" class="px-2" />
                    </div>
                </div>

                <div class="col-span-12 lg:hidden">
                    <div class="h-px w-full border-0 bg-zinc-200 dark:bg-zinc-700"></div>
                </div>

                {{-- Main Content --}}
                <div class="col-span-12 lg:col-span-9">
                    <article
                        class="prose-pre:rounded-3xl prose-headings:font-display prose prose-zinc prose-a:border-b prose-a:border-dashed prose-a:border-black/30 prose-a:font-semibold prose-a:no-underline prose-a:hover:border-solid prose-img:rounded-3xl dark:prose-invert max-w-none">
                        {!! $body !!}
                    </article>

                    <div
                        class="my-12 flex flex-col justify-start gap-y-5 border-t border-zinc-200 pt-10 dark:border-zinc-800">
                        @if ($document->frontmatter->tags)
                            <div class="flex flex-wrap items-center gap-2">
                                @foreach ($document->frontmatter->tags as $tag)
                                    <a href="{{ route('prezet.index', ['tag' => strtolower($tag)]) }}"
                                        class="inline-flex items-center rounded-3xl bg-zinc-100 dark:bg-zinc-800/50 px-2.5 py-1 text-xs font-medium text-zinc-600 transition-colors hover:bg-zinc-200 dark:bg-zinc-400 dark:hover:bg-zinc-700">
                                        <x-prezet.icon-tag class="mr-1.5 h-3 w-3" />
                                        {{ $tag }}
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <x-prezet.author-box :author="$author" :document="$document" />

                    @if ($relatedPosts->isNotEmpty())
                        <div class="mt-16 mb-16 border-t border-zinc-200 pt-16 dark:border-zinc-700">
                            <h3 class="mb-8 text-2xl font-bold text-zinc-900 dark:text-white">Bài viết liên quan</h3>
                            <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                                @foreach ($relatedPosts as $relatedPost)
                                    <x-prezet.article :article="$relatedPost->data" :author="$relatedPost->author" :readingTime="$relatedPost->readingTime"
                                        :hide-image="true" />
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
