@php
    /* @var string $body */
    /* @var array $headings */
    /* @var string $linkedData */
    /* @var object $document */
    /* @var \Illuminate\Support\Collection $seriesPosts */
    /* @var string $currentSeriesSlug */
@endphp

<x-prezet.template>
    @seo($seo)

    @push('jsonld')
        <script type="application/ld+json">
                {!! $linkedData !!}
            </script>
    @endpush

    <div class="py-12 lg:py-24" x-data="{ sidebarCollapsed: false }">
        {{-- Article Header --}}
        <x-prezet.article-header :document="$document" :readingTime="$readingTime" class="mb-10" />

        <x-prezet.alpine class="flex flex-col lg:flex-row gap-8 lg:gap-12">

            {{-- Left Sidebar: Series Navigation --}}
            <aside :class="sidebarCollapsed ? 'lg:w-20' : 'lg:w-80'"
                class="hidden md:block relative w-full lg:border-r lg:border-zinc-100 lg:dark:border-zinc-800 lg:pr-8 shrink-0">
                <div class="sticky top-24 overflow-hidden">
                    {{-- Sidebar Header & Toggle --}}
                    <div class="mb-6 lg:mb-10 flex items-center justify-between">
                        <h3 x-show="!sidebarCollapsed" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 -translate-x-4"
                            x-transition:enter-end="opacity-100 translate-x-0"
                            class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-500 dark:text-zinc-400 flex items-center gap-3 whitespace-nowrap">
                            <span class="w-8 h-px bg-zinc-200 dark:bg-zinc-800"></span>
                            Chuỗi bài viết
                        </h3>

                        {{-- Collapse/Expand Button --}}
                        <button @click="sidebarCollapsed = !sidebarCollapsed"
                            class="p-2 rounded-xl hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors text-zinc-400 hover:text-primary-500 flex items-center gap-2 hover:cursor-pointer"
                            :class="sidebarCollapsed ? 'mx-auto' : ''">
                            <span x-show="sidebarCollapsed && !window.matchMedia('(min-width: 1024px)').matches"
                                class="text-[10px] font-bold uppercase tracking-widest">Mở rộng chuỗi bài</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                stroke="currentColor" class="size-4 transition-transform duration-500"
                                :class="sidebarCollapsed ? 'rotate-180 lg:rotate-180 md:rotate-90' : 'md:-rotate-90 lg:rotate-0'">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5" />
                            </svg>
                        </button>
                    </div>

                    {{-- Collapsible Content Container --}}
                    <div class="transition-all duration-500 overflow-hidden"
                        :class="sidebarCollapsed ? 'md:max-h-0 lg:max-h-[2000px]' : 'max-h-[2000px]'">
                        {{-- Series Info Card --}}
                        <div x-show="!sidebarCollapsed" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="mb-10">
                            <div
                                class="bg-zinc-50/50 border border-primary-50/50 dark:bg-zinc-900/50 rounded-2xl px-4 py-3 ring-1 ring-zinc-200/50 dark:ring-zinc-800/50">
                                <h4 class="text-sm font-bold text-zinc-900 dark:text-white mb-1 truncate">
                                    {{ Str::headline($currentSeriesSlug) }}
                                </h4>
                                <p
                                    class="text-[10px] font-semibold text-zinc-400 dark:text-zinc-500 tracking-widest whitespace-nowrap">
                                    {{ $seriesPosts->count() }} Bài viết trong chuỗi
                                </p>
                            </div>
                        </div>

                        {{-- Navigation List --}}
                        <div
                            class="max-h-[calc(100vh-25rem)] lg:max-h-[calc(100vh-20rem)] overflow-y-auto pr-2 custom-scrollbar">
                            <nav class="space-y-2 pb-4 ml-1">
                                @foreach ($seriesPosts as $index => $post)
                                    @php
                                        // $post is now an array
                                        $isActive = $post['slug'] === str_replace('series/', '', $document->slug);
                                    @endphp
                                    <a href="{{ route('prezet.series.show', $post['slug']) }}"
                                        class="group flex items-center gap-3 py-2 px-2 rounded-full transition-all duration-200 {{ $isActive ? 'bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 ring-1 ring-primary-100 dark:ring-primary-900/50' : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 hover:text-zinc-900 dark:hover:text-zinc-200' }}"
                                        :class="sidebarCollapsed ? 'lg:justify-center p-1!' : ''"
                                        title="{{ $post['title'] }}">
                                        <div
                                            class="shrink-0 flex items-center justify-center size-8 rounded-full transition-colors duration-200 {{ $isActive ? 'bg-primary-500 text-white shadow-lg shadow-primary-500/30' : 'bg-zinc-100 dark:bg-zinc-800 text-zinc-400 group-hover:bg-primary-100 dark:group-hover:bg-primary-900/30 group-hover:text-primary-500' }}">
                                            <span class="text-[10px] font-bold leading-none">
                                                {{ sprintf('%02d', $index + 1) }}
                                            </span>
                                        </div>
                                        <span x-show="!sidebarCollapsed"
                                            x-transition:enter="transition ease-out duration-300"
                                            x-transition:enter-start="opacity-0 -translate-x-2"
                                            x-transition:enter-end="opacity-100 translate-x-0"
                                            class="text-sm font-semibold leading-tight truncate lg:max-w-xs">
                                            {{ $post['title'] }}
                                        </span>
                                    </a>
                                @endforeach
                            </nav>
                        </div>

                        {{-- Footer Link --}}
                        <div class="mt-6 lg:mt-12 pt-6 lg:pt-8 border-t border-zinc-100 dark:border-zinc-800">
                            <a href="{{ route('prezet.series.index') }}"
                                class="flex items-center gap-2 text-xs font-semibold text-zinc-400 hover:text-zinc-900 dark:hover:text-zinc-200 transition-colors"
                                :class="sidebarCollapsed ? 'lg:justify-center' : ''" title="Tất cả chuỗi bài">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2.5" stroke="currentColor" class="size-3 flex-shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                                </svg>
                                <span x-show="!sidebarCollapsed" x-transition class="whitespace-nowrap">Tất cả chuỗi
                                    bài</span>
                            </a>
                        </div>
                    </div>
                </div>
            </aside>

            {{-- Main Content --}}
            <main class="flex-1 min-w-0">
                <article class="prose prose-zinc dark:prose-invert max-w-none
                    prose-headings:font-bold prose-headings:tracking-tight
                    prose-a:text-primary-600 dark:prose-a:text-primary-400 prose-a:no-underline hover:prose-a:underline
                    prose-pre:rounded-3xl prose-pre:bg-zinc-900 prose-pre:ring-1 prose-pre:ring-white/10
                    prose-img:rounded-3xl">
                    {!! $body !!}
                </article>
            </main>

            {{-- Table of Contents Floating --}}
            <x-prezet.toc :headings="$headings" />
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
