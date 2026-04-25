@php
    /* @var \Illuminate\Support\Collection<int,object> $articles */
    /* @var array $seo */
    /* @var \Illuminate\Support\Collection $series */
    /* @var \Illuminate\Support\Collection $articlesByCategory */
    /* @var \Illuminate\Support\Collection $knowledgeArticles */
@endphp

<x-prezet.template>
    @seo($seo)

    <x-slot:fullWidthTop>
        <x-prezet.hero-section />
    </x-slot:fullWidthTop>

    {{-- Featured & Latest Grid --}}
    @if ($articles->isNotEmpty())
        <div class="py-20" id="latest-posts">
            <x-prezet.section-header title="Nổi bật & Mới nhất" :link="route('prezet.articles')" />

            <div class="grid grid-cols-1 gap-12 lg:grid-cols-3">
                {{-- Large Hero Article --}}
                <div class="lg:col-span-2">
                    <x-prezet.article-featured :article="$articles->first()->data"
                        :readingTime="$articles->first()->readingTime" />
                </div>

                {{-- Side Compact Articles --}}
                <div class="flex flex-col">
                    <h3 class="mb-6 text-xs font-black uppercase tracking-widest text-zinc-400">Đọc thêm</h3>
                    <div class="space-y-1">
                        @foreach ($articles->slice(1, 4) as $post)
                            <x-prezet.article-compact :article="$post->data" :readingTime="$post->readingTime" />
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Series Highlight Section --}}
    @if ($series->isNotEmpty())
        <div class="py-12 bg-zinc-50 dark:bg-zinc-900/50 -mx-4 px-4 sm:-mx-8 sm:px-8 lg:-mx-12 lg:px-12 rounded-[60px]"
            id="series">
            <div class="max-w-7xl mx-auto py-8">
                <x-prezet.section-header title="Chuỗi bài viết chuyên sâu" :link="route('prezet.series.index')" />

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach ($series->take(3) as $item)
                        <div class="transform transition duration-500 hover:-translate-y-2">
                            <x-prezet.series-card :series="$item" />
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    {{-- New Knowledge Section --}}
    @if ($knowledgeArticles->isNotEmpty())
        <div class="py-12" id="knowledge">
            <x-prezet.section-header title="Ôn tập kiến thức" :link="route('knowledge.index')" />

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-10">
                @foreach ($knowledgeArticles->take(4) as $post)
                    <div class="flex flex-col h-full animate-fade-in">
                        <x-prezet.article :article="$post" />
                    </div>
                @endforeach
            </div>

            <div class="mt-16 flex justify-center">
                <a href="{{ route('knowledge.index') }}"
                    class="group inline-flex items-center gap-3 rounded-full border-2 border-zinc-100 dark:border-zinc-800 px-8 py-3 text-xs font-black uppercase tracking-widest text-zinc-900 dark:text-white transition-all hover:bg-zinc-900 hover:text-white dark:hover:bg-white dark:hover:text-black">
                    Truy cập kho kiến thức
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                        stroke="currentColor" class="size-4 transition-transform group-hover:translate-x-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                    </svg>
                </a>
            </div>
        </div>
    @endif

    {{-- Browse by Categories - SEO & Mobile & PC Optimized --}}
    @if ($articlesByCategory->isNotEmpty())
        <div class="py-12" x-data="{
                activeCategory: '{{ $articlesByCategory->keys()->first() }}' ,
                scroll(direction) {
                    const el = this.$refs.scrollContainer;
                    const scrollAmount = 400;
                    el.scrollBy({
                        left: direction === 'left' ? -scrollAmount : scrollAmount,
                        behavior: 'smooth'
                    });
                },
                handleWheel(e) {
                    if (e.deltaY !== 0) {
                        this.$refs.scrollContainer.scrollLeft += e.deltaY;
                        e.preventDefault();
                    }
                }
            }">
            <div class="mb-12 space-y-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                    <div class="space-y-2">
                        <h2
                            class="text-3xl font-black tracking-tight text-zinc-900 dark:text-white md:text-4xl font-['Be_Vietnam_Pro']">
                            Khám phá theo chủ đề
                        </h2>
                        <div class="h-1.5 w-20 rounded-full bg-primary-500"></div>
                    </div>
                </div>

                {{-- Category Navigation --}}
                <div class="relative group/nav px-2">
                    {{-- Navigation Buttons (Centered to Pills) --}}
                    <div
                        class="absolute inset-y-0 -left-4 -right-4 z-30 flex items-center justify-between pointer-events-none">
                        <button @click="scroll('left')"
                            class="pointer-events-auto hidden lg:flex items-center justify-center rounded-full bg-white/80 dark:bg-zinc-800/80 backdrop-blur-md p-3 text-zinc-900 dark:text-white shadow-xl ring-1 ring-zinc-200 dark:ring-zinc-700 transition-all hover:bg-zinc-900 hover:text-white dark:hover:bg-white dark:hover:text-black opacity-0 group-hover/nav:opacity-100 -translate-x-2 group-hover/nav:translate-x-0 cursor-pointer mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                                stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                            </svg>
                        </button>

                        <button @click="scroll('right')"
                            class="pointer-events-auto hidden lg:flex items-center justify-center rounded-full bg-white/80 dark:bg-zinc-800/80 backdrop-blur-md p-3 text-zinc-900 dark:text-white shadow-xl ring-1 ring-zinc-200 dark:ring-zinc-700 transition-all hover:bg-zinc-900 hover:text-white dark:hover:bg-white dark:hover:text-black opacity-0 group-hover/nav:opacity-100 translate-x-2 group-hover/nav:translate-x-0 cursor-pointer mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                                stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </button>
                    </div>

                    {{-- Left Fade Overlay --}}
                    <div
                        class="absolute left-0 top-0 bottom-0 z-10 w-20 bg-linear-to-r from-white via-white/40 to-transparent pointer-events-none dark:from-zinc-950 dark:via-zinc-950/40">
                    </div>

                    <nav class="relative">
                        <ul x-ref="scrollContainer" @wheel="handleWheel($event)"
                            class="flex overflow-x-auto pb-8 pt-2 gap-4 no-scrollbar scroll-smooth snap-x px-4 sm:px-0">

                            {{-- Category Tabs --}}
                            @foreach ($articlesByCategory as $category => $posts)
                                <li class="snap-start shrink-0 first:pl-2 last:pr-24 md:first:pl-0">
                                    <button @click="activeCategory = '{{ $category }}'"
                                        aria-label="Xem bài viết về {{ $category }}"
                                        :class="activeCategory === '{{ $category }}'
                                                                    ? 'bg-zinc-900 text-white shadow-2xl shadow-zinc-500/20 dark:bg-white dark:text-black scale-105 ring-4 ring-primary-500/10 border-transparent'
                                                                    : 'bg-zinc-50 text-zinc-500 hover:bg-zinc-100 dark:bg-zinc-900/50 dark:text-zinc-400 dark:hover:bg-zinc-800 hover:scale-102 border-zinc-100 dark:border-zinc-800'"
                                        class="flex items-center gap-3 rounded-2xl px-6 py-4 text-xs font-black uppercase tracking-widest transition-all duration-300 cursor-pointer border">
                                        <span
                                            :class="activeCategory === '{{ $category }}' ? 'bg-primary-500 text-white' : 'bg-zinc-200 dark:bg-zinc-800 text-zinc-500'"
                                            class="flex h-6 w-6 items-center justify-center rounded-full text-[10px] transition-colors">
                                            {{ substr($category, 0, 1) }}
                                        </span>
                                        {{ $category }}
                                        <span class="ml-1 text-[10px] font-bold opacity-40">/ {{ $posts->count() }}</span>
                                    </button>
                                </li>
                            @endforeach
                        </ul>
                    </nav>

                    {{-- Right Fade Overlay --}}
                    <div
                        class="absolute right-0 top-0 bottom-0 z-10 w-32 bg-linear-to-l from-white via-white/40 to-transparent pointer-events-none dark:from-zinc-950 dark:via-zinc-950/40">
                    </div>
                </div>
            </div>

            {{-- Dynamic Content Area --}}
            <div class="relative min-h-[600px]">
                {{-- Category Content --}}
                @foreach ($articlesByCategory as $category => $posts)
                    <div x-show="activeCategory === '{{ $category }}'"
                        x-transition:enter="transition ease-out duration-500 delay-150"
                        x-transition:enter-start="opacity-0 translate-y-12" x-transition:enter-end="opacity-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-300 absolute inset-0"
                        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 -translate-y-12">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-10">
                            @foreach ($posts->take(8) as $post)
                                <div class="flex flex-col h-full animate-fade-in">
                                    <x-prezet.article :article="$post->data" :readingTime="$post->readingTime" />
                                </div>
                            @endforeach
                        </div>

                        <div class="mt-20 flex justify-center">
                            <a :href="'{{ route('prezet.articles') }}?category=' + activeCategory.toLowerCase()"
                                class="group relative inline-flex items-center gap-4 overflow-hidden rounded-2xl bg-zinc-900 px-10 py-5 text-white dark:bg-white dark:text-black shadow-2xl transition-all hover:bg-primary-600 hover:text-white dark:hover:bg-primary-600 active:scale-95">
                                <span class="relative z-10 text-xs font-black uppercase tracking-[0.2em]">
                                    Khám phá toàn bộ <span x-text="activeCategory"></span>
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                                    stroke="currentColor"
                                    class="relative z-10 size-4 transition-transform group-hover:translate-x-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Newsletter/CTA Section --}}
    <div>
        <div class="relative overflow-hidden rounded-[50px] bg-primary-600 px-8 py-16 text-center shadow-2xl">
            <div class="absolute -right-20 -top-20 h-64 w-64 rounded-full bg-white/10 blur-3xl"></div>
            <div class="absolute -left-20 -bottom-20 h-64 w-64 rounded-full bg-black/10 blur-3xl"></div>

            <div class="relative z-10 mx-auto max-w-2xl">
                <h2 class="mb-6 text-3xl font-black text-white md:text-5xl font-['Be_Vietnam_Pro']">
                    Tiếp tục hành trình học tập
                </h2>
                <p class="mb-10 text-primary-100 md:text-lg">
                    Cập nhật những kiến thức lập trình mới nhất và các thủ thuật tối ưu code hiệu quả.
                </p>
                <a href="{{ route('prezet.articles') }}"
                    class="inline-flex items-center justify-center rounded-2xl bg-white px-8 py-4 text-sm font-black uppercase tracking-widest text-primary-600 shadow-xl transition-transform hover:scale-105 active:scale-95">
                    Khám phá tất cả bài viết
                </a>
            </div>
        </div>
    </div>

    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in {
            animation: fade-in 0.5s ease-out forwards;
        }
    </style>
</x-prezet.template>
