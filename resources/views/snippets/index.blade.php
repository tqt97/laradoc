<x-prezet.template>
    @seo([
        'title' => 'Snippets - Nơi lưu trữ mã nguồn hữu ích',
        'description' => 'Danh sách các đoạn mã nguồn (snippets) được lưu trữ để tái sử dụng.',
        'url' => route('snippets.index'),
    ])

    <div id="articles" class="py-12 lg:py-12">
        <div class="max-w-7xl mx-auto px-4">
            <header class="mb-16 text-center">
                <h1 class="text-7xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-6xl mb-6">
                    Snippets
                </h1>
                <p class="text-lg text-zinc-500 dark:text-zinc-400 leading-relaxed max-w-7xl mx-auto mb-10">
                    Thư viện các đoạn mã nguồn hữu ích, giúp bạn tiết kiệm thời gian và công sức.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <form action="{{ route('snippets.index') }}" method="GET" class="relative w-full max-w-md group">
                        <div
                            class="relative flex items-center p-1 rounded-2xl bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-sm focus-within:ring-2 focus-within:ring-primary-500 transition-all">
                            <div class="pl-4 text-zinc-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                </svg>
                            </div>
                            <input type="text" name="q" value="{{ $search }}"
                                placeholder="Tìm kiếm snippet..."
                                class="flex-grow bg-transparent border-none focus:ring-0 text-sm font-medium text-zinc-900 dark:text-white placeholder:text-zinc-400 py-3 px-3" />
                            <button type="submit"
                                class="bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 font-bold text-xs uppercase tracking-widest px-6 py-3 rounded-xl transition-all hover:scale-[1.02] active:scale-[0.98]">
                                Tìm
                            </button>
                        </div>
                    </form>

                    {{-- <a href="{{ route('snippets.create') }}"
                        class="inline-flex items-center gap-2 px-6 py-4 rounded-2xl bg-primary-600 text-white font-bold text-sm shadow-xl hover:bg-primary-700 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tạo Snippet mới
                    </a> --}}
                </div>
            </header>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($snippets as $snippet)
                    <article
                        class="relative group flex flex-col rounded-3xl bg-white dark:bg-zinc-900 border border-zinc-100 dark:border-zinc-800 p-6 hover:shadow-2xl hover:shadow-primary-500/5 transition-all duration-300">
                        @php
                            $langConfig = config(
                                'prezet.snippet_languages.' . ($snippet->language ?? 'txt'),
                                config('prezet.snippet_languages.txt'),
                            );
                        @endphp
                        <div class="flex items-start justify-between mb-4">
                            <div
                                class="p-2.5 rounded-xl bg-zinc-50 dark:bg-zinc-800 text-zinc-400 group-hover:text-primary-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" />
                                </svg>
                            </div>
                            <span
                                class="px-3 py-1 rounded-lg {{ $langConfig['bg'] }} {{ $langConfig['text'] }} border {{ $langConfig['border'] }} text-[10px] font-black uppercase tracking-widest transition-colors">
                                {{ $langConfig['label'] }}
                            </span>
                        </div>

                        <h2
                            class="text-xl font-bold text-zinc-900 dark:text-white mb-3 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                            <a href="{{ route('snippets.show', Str::after($snippet->slug, 'snippets/')) }}">
                                <span class="absolute inset-0"></span>
                                {{ $snippet->frontmatter->title }}
                            </a>
                        </h2>

                        <p class="text-sm text-zinc-500 dark:text-zinc-400 line-clamp-2 leading-relaxed mb-6">
                            {{ $snippet->frontmatter->excerpt }}
                        </p>

                        <div
                            class="mt-auto pt-6 border-t border-zinc-50 dark:border-zinc-800 flex items-center justify-between">
                            <div class="flex items-center gap-2 text-xs font-bold text-zinc-400">
                                <x-prezet.icon-calendar class="size-3.5" />
                                <span>{{ $snippet->createdAt->format('d/m/Y') }}</span>
                            </div>
                            <div
                                class="text-primary-500 opacity-0 group-hover:opacity-100 transition-opacity translate-x-2 group-hover:translate-x-0 transition-transform duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2.5" stroke="currentColor" class="size-5">
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
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-10">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-2">Không tìm thấy snippet nào</h3>
                        <p class="text-zinc-500 dark:text-zinc-400 font-medium">Hãy thử tìm kiếm với từ khóa khác hoặc
                            tạo mới.</p>
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
