@php
    /* @var \Illuminate\Support\Collection<int,object> $articles */
    /* @var array $seo */
@endphp

<x-prezet.template>
    @seo($seo)

    <x-prezet.hero-section />

    @if ($series->isNotEmpty())
        <div class="py-16" id="series">
            <div class="flex items-center justify-between mb-16">
                <div class="flex items-center gap-8 flex-grow">
                    <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">
                        Chuỗi bài viết nổi bật
                    </h2>
                    <div class="h-px grow bg-zinc-100 dark:bg-zinc-800"></div>
                </div>

                <a href="{{ route('prezet.series.index') }}"
                    class="ml-8 group flex items-center gap-2 text-sm font-bold text-zinc-500 hover:text-zinc-900 dark:hover:text-white transition-colors shrink-0">
                    Xem tất cả
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke="currentColor" class="size-4 group-hover:translate-x-1 transition-transform">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                @foreach ($series as $item)
                    <div
                        class="group relative flex flex-col rounded-3xl bg-zinc-50/50 text-zinc-900 ring-1 ring-zinc-500/10 transition-all hover:bg-white hover:ring-zinc-500/20 dark:border-zinc-800 dark:bg-zinc-800/50 dark:text-zinc-100 dark:ring-zinc-700 dark:hover:bg-zinc-900 dark:hover:ring-zinc-600 overflow-hidden p-6 sm:p-8">
                        <div class="grow flex flex-col">
                            <div class="flex items-center gap-4 mb-4 sm:mb-6">
                                {{-- <span
                                    class="flex flex-wrap items-center justify-center size-12 sm:size-14 rounded-3xl bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 font-bold text-lg sm:text-xl ring-1 ring-primary-100 dark:ring-primary-900/50 group-hover:scale-110 transition-transform duration-300">
                                    {{ $item->postCount }} <br>
                                    <span class="text-xs">bài viết</span>
                                </span> --}}
                                <div class="flex flex-col">
                                    <span
                                        class="text-[10px] font-black uppercase tracking-[0.2em] text-primary-600 dark:text-primary-400">
                                        Chuỗi bài viết
                                    </span>
                                    <span class="mt-1 text-xs font-bold text-zinc-500 dark:text-zinc-500">
                                        {{ $item->postCount }} bài viết
                                    </span>
                                </div>
                            </div>

                            <h3
                                class="text-xl sm:text-2xl font-bold text-zinc-900 dark:text-white mb-3 sm:mb-4 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors leading-tight">
                                {{ $item->data->frontmatter->title ?? $item->title }}
                            </h3>

                            <p class="text-zinc-500 dark:text-zinc-400 leading-relaxed line-clamp-2 text-sm">
                                {{ $item->data->frontmatter->excerpt ?? 'Khám phá chuỗi bài viết chi tiết về ' . ($item->data->frontmatter->title ?? $item->title) }}
                            </p>
                        </div>

                        <div
                            class="mt-auto pt-4 sm:pt-6 border-t border-zinc-100 dark:border-zinc-800 flex items-center justify-between gap-6 w-full">
                            <div class="flex items-center gap-2 text-xs font-bold text-zinc-400 leading-none">
                                <x-prezet.icon-calendar class="size-3.5 mb-0.5" />
                                <time datetime="{{ $item->data->createdAt->toIso8601String() }}">
                                    {{ $item->data->createdAt->format('d/m/Y') }}
                                </time>
                            </div>

                            <div
                                class="text-primary-500 flex items-center gap-2 text-sm font-bold opacity-60 group-hover:opacity-100 transition-opacity leading-none">
                                <span class="hidden sm:inline">Bắt đầu đọc</span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2.5" stroke="currentColor"
                                    class="size-4 group-hover:translate-x-1 transition-transform mb-0.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                </svg>
                            </div>
                        </div>

                        {{-- Link Overlay --}}
                        <a href="{{ route('prezet.series.show', $item->slug . '/index') }}"
                            class="absolute inset-0 z-10" aria-label="{{ $item->title }}"></a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <div id="latest-posts" class="py-16 scroll-mt-24">
        <div class="flex items-center justify-between mb-16">
            <div class="flex items-center gap-8 grow">
                <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">
                    Bài viết mới nhất
                </h2>
                <div class="h-px grow bg-zinc-100 dark:bg-zinc-800"></div>
            </div>

            <a href="{{ route('prezet.articles') }}"
                class="ml-8 group flex items-center gap-2 text-sm font-bold text-zinc-500 hover:text-zinc-900 dark:hover:text-white transition-colors shrink-0">
                Xem tất cả
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                    stroke="currentColor" class="size-4 group-hover:translate-x-1 transition-transform">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                </svg>
            </a>
        </div>

        {{-- 2-column grid for 12 posts --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-12">
            @foreach ($articles as $post)
                <x-prezet.article :article="$post->data" :readingTime="$post->readingTime" :hideImage="true" />
            @endforeach
        </div>
    </div>
</x-prezet.template>
