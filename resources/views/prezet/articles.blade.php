@php
    /* @var string|HtmlString $headerTitle */
    /* @var string|null $headerSubtitle */
    /* @var array $seo */
    /* @var string|null $currentTag */
    /* @var string|null $currentCategory */
    /* @var array|null $currentAuthor */
    /* @var \Illuminate\Support\Collection $postsByYear */
    /* @var \Illuminate\Support\Collection $allCategories */
    /* @var \Illuminate\Support\Collection $allTags */
    /* @var int $allPostsCount */
    /* @var \Illuminate\Pagination\LengthAwarePaginator $paginator */
@endphp

<x-prezet.template>
    @seo($seo)

    <x-prezet.subpage-header :title="$headerTitle" :subtitle="$headerSubtitle" />

    <div id="articles" class="py-12 lg:py-24 scroll-mt-24">
        <div id="articles-content" class="grid grid-cols-1 lg:grid-cols-12 gap-12 xl:gap-16 min-h-[60vh]">
            {{-- Main Content: Articles Feed --}}
            <main class="col-span-1 lg:col-span-9">
                {{-- Articles List --}}
                <div class="space-y-16">
                    @foreach ($postsByYear as $year => $posts)
                        <section>
                            <div class="flex items-center gap-8 mb-6 mt-0">
                                <h2 class="text-2xl font-bold text-zinc-900 dark:text-white tracking-tighter">
                                    {{ $year }}
                                </h2>
                                <div class="h-px flex-grow bg-zinc-100 dark:bg-zinc-800"></div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-12">
                                @foreach ($posts as $post)
                                    <x-prezet.article :article="$post->data" :readingTime="$post->readingTime"
                                        :hide-image="true" />
                                @endforeach
                            </div>
                        </section>
                    @endforeach
                </div>

                @if ($paginator->hasPages())
                    <div class="mt-24 border-t border-zinc-100 dark:border-zinc-800 pt-16">
                        {{ $paginator->withQueryString()->links() }}
                    </div>
                @endif
            </main>

            {{-- Right Sidebar: Navigation & Taxonomy --}}
            <aside class="hidden lg:block lg:col-span-3" x-data="{ openCat: true, openTags: true }">
                <div class="sticky top-24 max-h-[calc(100vh-8rem)] overflow-y-auto pr-4 custom-scrollbar space-y-10">
                    {{-- Categories Section --}}
                    <div>
                        <button @click="openCat = !openCat"
                            class="flex items-center justify-between w-full group cursor-pointer mb-6 mt-2">
                            <h3
                                class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-700 dark:text-zinc-500 flex items-center gap-3">
                                <span class="w-8 h-px bg-zinc-200 dark:bg-zinc-800"></span>
                                Danh mục
                            </h3>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                stroke="currentColor"
                                class="size-3 text-zinc-400 group-hover:text-primary-500 transition-transform duration-300"
                                :class="openCat ? 'rotate-180' : ''">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>

                        <ul class="space-y-1 overflow-hidden transition-all duration-300" x-show="openCat" x-collapse>
                            <li>
                                <a href="{{ route('prezet.articles') }}"
                                    class="group flex items-center justify-between py-2 px-4 rounded-3xl transition-all {{ !$currentCategory ? 'text-primary-500 bg-gray-50/50 dark:bg-gray-800 dark:text-primary-400 shadow-sm' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 hover:text-zinc-900 dark:hover:text-zinc-200' }}">
                                    <span class="text-sm">Tất cả bài viết</span>
                                    <span
                                        class="text-[10px] font-bold py-1 px-2 rounded-xl bg-zinc-200/50 dark:bg-zinc-700/50 group-hover:bg-zinc-200 dark:group-hover:bg-zinc-700 transition-colors">
                                        {{ $allPostsCount }}
                                    </span>
                                </a>
                            </li>
                            @foreach ($allCategories as $cat)
                                <li>
                                    <a href="{{ route('prezet.articles', ['category' => strtolower($cat->category)]) }}"
                                        class="group flex items-center justify-between py-2 px-4 rounded-3xl transition-all capitalize {{ $currentCategory == strtolower($cat->category) ? 'bg-gray-50/50 text-primary-500 dark:bg-gray-800 dark:text-primary-400 shadow-sm' : 'text-zinc-600 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 hover:text-primary-500 dark:hover:text-zinc-200' }}">
                                        <span class="text-sm">{{ $cat->category }}</span>
                                        <span
                                            class="text-[10px] font-semibold py-1 px-2 rounded-xl bg-zinc-200/50 dark:bg-zinc-700/50 group-hover:bg-zinc-200 dark:group-hover:bg-zinc-700 transition-colors">{{ $cat->post_count }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Tags Section --}}
                    <div>
                        <button @click="openTags = !openTags"
                            class="flex items-center justify-between w-full group cursor-pointer mb-6">
                            <h3
                                class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-700 dark:text-zinc-500 flex items-center gap-3">
                                <span class="w-8 h-px bg-zinc-200 dark:bg-zinc-800"></span>
                                Thẻ phổ biến
                            </h3>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                stroke="currentColor"
                                class="size-3 text-zinc-400 group-hover:text-primary-500 transition-transform duration-300"
                                :class="openTags ? 'rotate-180' : ''">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>

                        <div class="flex flex-wrap gap-2 overflow-hidden transition-all duration-300" x-show="openTags"
                            x-collapse>
                            @foreach ($allTags as $tag)
                                <a href="{{ route('prezet.articles', ['tag' => strtolower($tag->name)]) }}"
                                    class="inline-flex items-center gap-1.5 py-1.5 px-3 rounded-xl text-xs transition-all {{ $currentTag == strtolower($tag->name) ? ' bg-primary-500 text-white shadow-lg shadow-primary-500/30' : ' bg-zinc-50 dark:bg-zinc-800/50 text-zinc-500 dark:text-zinc-400 hover:bg-primary-50 dark:hover:bg-primary-900/20 hover:text-primary-600 dark:hover:text-primary-400 border border-zinc-100 dark:border-zinc-800' }}">
                                    <x-prezet.icon-tag class="size-3" />
                                    <span>{{ $tag->name }}</span>
                                    <span class="text-[10px] font-bold opacity-60">{{ $tag->documents_count }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</x-prezet.template>
