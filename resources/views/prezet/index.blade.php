@php
    /* @var \Illuminate\Support\Collection<int,object> $articles */
    /* @var array $seo */
@endphp

<x-prezet.template>
    @seo($seo)

    <x-slot:fullWidthTop>
        <x-prezet.hero-section />
    </x-slot:fullWidthTop>

    {{-- Series Section --}}
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
                    <x-prezet.series-card :series="$item" />
                @endforeach
            </div>
        </div>
    @endif
    {{-- Latest posts section --}}
    @if ($articles->isNotEmpty())
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
    @endif

    {{-- Articles By Category section --}}
    @if ($articlesByCategory->isNotEmpty())
        @foreach ($articlesByCategory as $category => $posts)
            <div class="py-16 scroll-mt-24">
                <div class="flex items-center justify-between mb-16">
                    <div class="flex items-center gap-8 grow">
                        <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">
                            {{ ucfirst($category) }}
                        </h2>
                        <div class="h-px grow bg-zinc-100 dark:bg-zinc-800"></div>
                    </div>

                    <a href="{{ route('prezet.articles', ['category' => $category]) }}"
                        class="ml-8 group flex items-center gap-2 text-sm font-bold text-zinc-500 hover:text-zinc-900 dark:hover:text-white transition-colors shrink-0">
                        Xem tất cả
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor" class="size-4 group-hover:translate-x-1 transition-transform">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>

                {{-- 2-column grid for 4 posts --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-12">
                    @foreach ($posts as $post)
                        <x-prezet.article :article="$post->data" :readingTime="$post->readingTime" :hideImage="true" />
                    @endforeach
                </div>
            </div>
        @endforeach
    @endif
</x-prezet.template>
