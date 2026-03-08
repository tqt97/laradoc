@php
    /* @var string $body */
    /* @var array $headings */
    /* @var string $linkedData */
    /* @var \Prezet\Prezet\Data\DocumentData $document */
    /* @var \Illuminate\Support\Collection $seriesPosts */
    /* @var string $currentSeriesSlug */
@endphp

<x-prezet.template>
    @seo([
        'title' => $document->frontmatter->title,
        'description' => $document->frontmatter->excerpt,
        'url' => route('prezet.series.show', ['slug' => str_replace('series/', '', $document->slug)]),
        'image' => $document->frontmatter->image ? url($document->frontmatter->image) : null,
    ])

    @push('jsonld')
        <script type="application/ld+json">
            {!! $linkedData !!}
        </script>
    @endpush

    <div class="py-12 lg:py-24">
        {{-- Article Header --}}
        <x-prezet.article-header :document="$document" :readingTime="$readingTime" class="mb-10" />

        <x-prezet.alpine class="grid grid-cols-12 gap-12">

            {{-- Left Sidebar: Series Navigation --}}
            <aside class="col-span-12 lg:col-span-3 lg:border-r lg:border-zinc-100 lg:dark:border-zinc-800 lg:pr-8">
                <div class="sticky top-24">
                    <div class="mb-10">
                        <h3
                            class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-400 dark:text-zinc-500 mb-6 flex items-center gap-3">
                            <span class="w-8 h-px bg-zinc-200 dark:bg-zinc-800"></span>
                            Chuỗi bài viết
                        </h3>
                        <div
                            class="bg-zinc-50 dark:bg-zinc-900/50 rounded-3xl p-4 ring-1 ring-zinc-200/50 dark:ring-zinc-800/50">
                            <h4 class="text-sm font-bold text-zinc-900 dark:text-white mb-1">
                                {{ Str::headline($currentSeriesSlug) }}
                            </h4>
                            <p class="text-[10px] font-bold text-zinc-400 dark:text-zinc-500 uppercase tracking-widest">
                                {{ $seriesPosts->count() }} Bài viết trong chuỗi
                            </p>
                        </div>
                    </div>

                    <nav class="space-y-1">
                        @foreach ($seriesPosts as $index => $post)
                            @php
                                $isActive = $post->slug === $document->slug;
                            @endphp
                            <a href="{{ route('prezet.series.show', $post->series_slug) }}"
                                class="group flex items-start gap-3 py-3 px-4 rounded-3xl transition-all duration-200 {{ $isActive ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 ring-1 ring-primary-100 dark:ring-primary-900/50' : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 hover:text-zinc-900 dark:hover:text-zinc-200' }}">
                                <div class="mt-1 flex-shrink-0 flex items-center justify-center">
                                    @if ($isActive)
                                        <div class="size-2 rounded-full bg-primary-500 animate-pulse"></div>
                                    @else
                                        <span class="text-[10px] font-bold opacity-30 group-hover:opacity-100">
                                            {{ sprintf('%02d', $index + 1) }}
                                        </span>
                                    @endif
                                </div>
                                <span class="text-sm font-semibold leading-tight">
                                    {{ $post->frontmatter->title }}
                                </span>
                            </a>
                        @endforeach
                    </nav>

                    <div class="mt-12 pt-8 border-t border-zinc-100 dark:border-zinc-800">
                        <a href="{{ route('prezet.series.index') }}"
                            class="flex items-center gap-2 text-xs font-semibold text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor" class="size-3">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                            </svg>
                            Tất cả chuỗi bài
                        </a>
                    </div>
                </div>
            </aside>

            {{-- Main Content --}}
            <main class="col-span-12 lg:col-span-6">
                <article
                    class="prose prose-zinc dark:prose-invert max-w-none
                    prose-headings:font-bold prose-headings:tracking-tight
                    prose-a:text-primary-600 dark:prose-a:text-primary-400 prose-a:no-underline hover:prose-a:underline
                    prose-pre:rounded-3xl prose-pre:bg-zinc-900 prose-pre:ring-1 prose-pre:ring-white/10
                    prose-img:rounded-3xl">
                    {!! $body !!}
                </article>

                {{-- Author Box --}}
                {{-- <div class="mt-16 pt-16 border-t border-zinc-100 dark:border-zinc-800">
                    <x-prezet.author-box :author="$author" :document="$document" />
                </div> --}}
            </main>

            {{-- Right Sidebar: Table of Contents --}}
            <aside class="hidden lg:block lg:col-span-3">
                <div class="sticky top-24">
                    <x-prezet.toc :headings="$headings" />
                </div>
            </aside>
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
                    pre.style.position = 'relative';
                    pre.classList.add('group/copy');

                    const button = document.createElement('button');
                    button.type = 'button';
                    button.className =
                        'absolute top-2 right-2 w-7 h-7 flex items-center justify-center rounded bg-zinc-800/30 text-zinc-500 opacity-0 group-hover/copy:opacity-100 transition-all hover:bg-zinc-800 hover:text-zinc-300 border border-zinc-700/20 cursor-pointer z-10';
                    button.innerHTML =
                        `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>`;

                    button.onclick = async (e) => {
                        e.preventDefault();
                        const code = pre.querySelector('code')?.innerText || pre.innerText;
                        try {
                            await navigator.clipboard.writeText(code);
                            const original = button.innerHTML;
                            button.innerHTML =
                                `<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-emerald-500"><polyline points="20 6 9 17 4 12"/></svg>`;
                            setTimeout(() => button.innerHTML = original, 2000);
                        } catch (err) {
                            console.error('Copy failed', err);
                        }
                    };
                    pre.appendChild(button);
                });
            };
            initCopyButtons();
        });
    </script>
</x-prezet.template>
