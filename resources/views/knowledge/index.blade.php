@php
    /* @var \Illuminate\Support\Collection $knowledge */
    /* @var array $seo */
    /* @var string $search */
    /* @var string $currentTag */
@endphp

<x-prezet.template>
    @seo($seo)

    <x-prezet.subpage-header title="Ôn tập kiến thức"
        subtitle="Thư viện các kiến thức lập trình được tóm tắt và đúc kết dưới dạng các thẻ kiến thức dễ nhớ, dễ ôn tập.">
        <x-prezet.index-search :action="route('knowledge.index')" :value="$search"
            placeholder="Tìm kiếm kiến thức..." />
    </x-prezet.subpage-header>

    <div id="articles" class="py-12 lg:py-12">
        <div class="max-w-7xl mx-auto px-4">
            {{-- Active Tag Indicator --}}
            @if($currentTag)
                <div
                    class="mb-12 flex items-center justify-between p-6 rounded-3xl bg-primary-50 dark:bg-primary-900/10 border border-primary-100 dark:border-primary-900/20">
                    <div class="flex items-center gap-4">
                        <div class="p-2 rounded-xl bg-primary-500 text-white">
                            <x-prezet.icon-tag class="size-5" />
                        </div>
                        <div>
                            <p class="text-xs font-black uppercase tracking-widest text-primary-600 dark:text-primary-400">
                                Đang lọc theo thẻ</p>
                            <h2 class="text-xl font-black text-zinc-900 dark:text-white">#{{ $currentTag }}</h2>
                        </div>
                    </div>
                    <a href="{{ route('knowledge.index') }}"
                        class="text-xs font-black uppercase tracking-widest text-zinc-400 hover:text-zinc-900 dark:hover:text-white transition-colors">
                        Xóa lọc
                    </a>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($knowledge as $item)
                    <article
                        class="relative group flex flex-col rounded-3xl bg-white dark:bg-zinc-900 border border-zinc-100 dark:border-zinc-800 p-6 hover:shadow-2xl hover:shadow-primary-500/5 transition-all duration-300">

                        <div class="flex items-start justify-between mb-4">
                            <div
                                class="p-2.5 rounded-3xl bg-zinc-50 dark:bg-zinc-800 text-zinc-400 group-hover:text-primary-500 transition-colors">
                                <x-prezet.icon-knowledge class="size-6" />
                            </div>
                        </div>

                        <h2
                            class="text-xl font-bold text-zinc-900 dark:text-white mb-3 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                            <a href="{{ route('knowledge.show', Str::after($item->slug, 'knowledge/')) }}">
                                <span class="absolute inset-0"></span>
                                {{ $item->frontmatter->title }}
                            </a>
                        </h2>

                        <p class="text-sm text-zinc-500 dark:text-zinc-400 line-clamp-2 leading-relaxed mb-6">
                            {{ $item->frontmatter->description ?? $item->frontmatter->excerpt }}
                        </p>

                        {{-- Tags Section --}}
                        @if(isset($item->frontmatter->tags) && is_array($item->frontmatter->tags))
                            <div class="relative z-10 flex flex-wrap items-center gap-2 mb-8">
                                @foreach($item->frontmatter->tags as $tag)
                                    <a href="{{ route('knowledge.index', ['tag' => $tag]) }}"
                                        class="inline-flex items-center rounded-xl bg-zinc-50 dark:bg-zinc-800 px-2.5 py-1 text-[10px] font-bold tracking-widest text-zinc-500 transition-colors hover:bg-primary-500 hover:text-white">
                                        #{{ $tag }}
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        <div
                            class="mt-auto pt-6 border-t border-zinc-50 dark:border-zinc-800 flex items-center justify-between">
                            <div class="flex items-center gap-2 text-xs font-bold text-zinc-400 leading-none">
                                <x-prezet.icon-calendar class="size-3.5 mb-0.5" />
                                <span>{{ $item->createdAt->format('d/m/Y') }}</span>
                            </div>
                            <div
                                class="text-primary-500 opacity-0 group-hover:opacity-100 translate-x-2 group-hover:translate-x-0 transition-transform duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                    stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                </svg>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full py-20 text-center">
                        <div
                            class="size-20 bg-zinc-50 dark:bg-zinc-900 rounded-full flex items-center justify-center mx-auto mb-6 text-zinc-300 dark:text-zinc-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-10">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-2">Không tìm thấy kiến thức nào</h3>
                        <p class="text-zinc-500 dark:text-zinc-400 font-medium">Hãy thử tìm kiếm với từ khóa khác hoặc xóa
                            lọc thẻ.</p>
                    </div>
                @endforelse
            </div>

            @if ($paginator->hasPages())
                <div class="mt-16 border-t border-zinc-100 dark:border-zinc-800 pt-12">
                    {{ $paginator->links() }}
                </div>
            @endif
        </div>
    </div>
</x-prezet.template>