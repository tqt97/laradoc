@php
    /* @var array $nav */
    /* @var array|null|string $currentTag */
    /* @var array|null|string $currentCategory */
    /* @var array|null $currentAuthor */
    /* @var \Illuminate\Support\Collection<int,\Prezet\Prezet\Data\DocumentData> $articles */
    /* @var \Illuminate\Support\Collection $postsByYear */
    /* @var \Illuminate\Support\Collection $allCategories */
    /* @var \Illuminate\Support\Collection $allTags */
    /* @var int $allPostsCount */
    /* @var \Illuminate\Pagination\LengthAwarePaginator $paginator */
@endphp

<x-prezet.template>
    @seo([
        'title' => 'Prezet: Markdown Blogging for Laravel',
        'description' => 'Transform your markdown files into SEO-friendly blogs, articles, and documentation!',
        'url' => route('prezet.index'),
    ])

    <div id="articles" class="py-12 lg:py-24 scroll-mt-24" hx-boost="true" hx-select="#articles-content"
        hx-target="#articles-content" hx-push-url="true" hx-swap="outerHTML show:none">
        <div id="articles-content" class="grid grid-cols-1 lg:grid-cols-12 gap-12 xl:gap-16 min-h-[60vh]">
            {{-- Left Sidebar: Navigation & Taxonomy --}}
            <aside class="hidden lg:block lg:col-span-3">
                <div class="sticky top-24 space-y-12">
                    {{-- Categories Section --}}
                    <div>
                        <h3
                            class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-400 dark:text-zinc-500 mb-8 flex items-center gap-3">
                            <span class="w-8 h-px bg-zinc-200 dark:bg-zinc-800"></span>
                            Categories
                        </h3>
                        <ul class="space-y-2">
                            <li>
                                <a href="{{ route('prezet.index', array_filter(request()->except('category'))) }}#articles"
                                    class="group flex items-center justify-between py-2.5 px-4 rounded-xl transition-all {{ !$currentCategory ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-white font-bold shadow-sm' : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 hover:text-zinc-900 dark:hover:text-zinc-200' }}">
                                    <span class="text-sm">All Posts</span>
                                    <span
                                        class="text-[10px] font-bold py-1 px-2.5 rounded-lg bg-zinc-200/50 dark:bg-zinc-700/50 group-hover:bg-zinc-200 dark:group-hover:bg-zinc-700 transition-colors">
                                        {{ $allPostsCount }}
                                    </span>
                                </a>
                            </li>
                            @foreach ($allCategories as $cat)
                                <li>
                                    <a href="{{ route('prezet.index', array_merge(request()->query(), ['category' => strtolower($cat->category)])) }}#articles"
                                        class="group flex items-center justify-between py-2.5 px-4 rounded-xl transition-all {{ $currentCategory == strtolower($cat->category) ? 'bg-zinc-100 dark:bg-zinc-800 text-zinc-900 dark:text-white font-bold shadow-sm' : 'text-zinc-500 dark:text-zinc-400 hover:bg-zinc-50 dark:hover:bg-zinc-800/50 hover:text-zinc-900 dark:hover:text-zinc-200' }}">
                                        <span class="text-sm">{{ $cat->category }}</span>
                                        <span
                                            class="text-[10px] font-bold py-1 px-2.5 rounded-lg bg-zinc-200/50 dark:bg-zinc-700/50 group-hover:bg-zinc-200 dark:group-hover:bg-zinc-700 transition-colors">{{ $cat->post_count }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Tags Section --}}
                    <div>
                        <h3
                            class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-400 dark:text-zinc-500 mb-8 flex items-center gap-3">
                            <span class="w-8 h-px bg-zinc-200 dark:bg-zinc-800"></span>
                            Popular Tags
                        </h3>
                        <div class="flex flex-wrap gap-2.5">
                            @foreach ($allTags as $tag)
                                <a href="{{ route('prezet.index', array_merge(request()->query(), ['tag' => strtolower($tag->name)])) }}#articles"
                                    class="inline-flex items-center gap-1.5 py-2 px-3.5 rounded-xl text-xs font-bold transition-all {{ $currentTag == strtolower($tag->name) ? 'bg-zinc-900 text-white dark:bg-white dark:text-zinc-900 shadow-xl' : 'bg-zinc-50 dark:bg-zinc-800 text-zinc-500 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700 hover:text-zinc-900 dark:hover:text-zinc-200 border border-transparent' }}">
                                    <span>#{{ $tag->name }}</span>
                                    <span class="text-[10px] font-bold opacity-30">{{ $tag->documents_count }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </aside>

            {{-- Main Content: Articles Feed --}}
            <main class="col-span-1 lg:col-span-9">
                <header class="mb-16">
                    <h1
                        class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-6xl mb-6 leading-[1.1]">
                        @if ($currentCategory)
                            <span class="text-zinc-400 dark:text-zinc-600 block text-2xl font-bold mb-2">Category</span>
                            {{ $currentCategory }}
                        @elseif ($currentTag)
                            <span class="text-zinc-400 dark:text-zinc-600 block text-2xl font-bold mb-2">Tag</span>
                            #{{ $currentTag }}
                        @elseif ($currentAuthor)
                            <span class="text-zinc-400 dark:text-zinc-600 block text-2xl font-bold mb-2">Author</span>
                            {{ $currentAuthor['name'] }}
                        @else
                            Recent Posts
                        @endif
                    </h1>

                    @if (!$currentCategory && !$currentTag && !$currentAuthor)
                        <p class="text-lg text-zinc-500 dark:text-zinc-400 max-w-xl leading-relaxed font-medium mb-8">
                            A curated collection of stories, tutorials, and insights focused on modern Laravel
                            development and Markdown blogging.
                        </p>
                    @endif

                    {{-- Active Filter Pills --}}
                    @if ($currentTag || $currentCategory || $currentAuthor)
                        <div
                            class="flex flex-wrap items-center gap-4 border-t border-zinc-100 dark:border-zinc-800 pt-8 mt-8">
                            <span class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-400">Filtering By</span>
                            @if ($currentTag)
                                <span
                                    class="inline-flex items-center gap-2 rounded-xl bg-zinc-900 text-white px-4 py-2 text-xs font-bold dark:bg-white dark:text-zinc-900 shadow-lg">
                                    <x-prezet.icon-tag class="size-3" />
                                    {{ strtoupper($currentTag) }}
                                    <a href="{{ route('prezet.index', array_filter(request()->except('tag'))) }}#articles"
                                        class="ml-2 hover:opacity-70 transition-opacity">
                                        <svg viewBox="0 0 14 14" class="h-3.5 w-3.5 stroke-current" fill="none"
                                            stroke-width="3">
                                            <path d="M4 4l6 6m0-6l-6 6" />
                                        </svg>
                                    </a>
                                </span>
                            @endif

                            @if ($currentCategory)
                                <span
                                    class="inline-flex items-center gap-2 rounded-xl bg-zinc-900 text-white px-4 py-2 text-xs font-bold dark:bg-white dark:text-zinc-900 shadow-lg">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="3" stroke="currentColor" class="size-3">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                                    </svg>
                                    {{ strtoupper($currentCategory) }}
                                    <a href="{{ route('prezet.index', array_filter(request()->except('category'))) }}#articles"
                                        class="ml-2 hover:opacity-70 transition-opacity">
                                        <svg viewBox="0 0 14 14" class="h-3.5 w-3.5 stroke-current" fill="none"
                                            stroke-width="3">
                                            <path d="M4 4l6 6m0-6l-6 6" />
                                        </svg>
                                    </a>
                                </span>
                            @endif

                            @if ($currentAuthor)
                                <span
                                    class="inline-flex items-center gap-2 rounded-xl bg-zinc-900 text-white px-4 py-2 text-xs font-bold dark:bg-white dark:text-zinc-900 shadow-lg">
                                    <img src="{{ $currentAuthor['image'] }}" class="h-4 w-4 rounded-full" />
                                    {{ strtoupper($currentAuthor['name']) }}
                                    <a href="{{ route('prezet.index', array_filter(request()->except('author'))) }}#articles"
                                        class="ml-2 hover:opacity-70 transition-opacity">
                                        <svg viewBox="0 0 14 14" class="h-3.5 w-3.5 stroke-current" fill="none"
                                            stroke-width="3">
                                            <path d="M4 4l6 6m0-6l-6 6" />
                                        </svg>
                                    </a>
                                </span>
                            @endif

                            <a href="{{ route('prezet.index') }}#articles"
                                class="text-xs font-bold uppercase tracking-widest text-zinc-400 hover:text-red-500 transition-colors">
                                Reset
                            </a>
                        </div>
                    @endif
                </header>

                {{-- Articles List --}}
                <div class="space-y-32">
                    @foreach ($postsByYear as $year => $posts)
                        <section>
                            <div class="flex items-center gap-8 mb-16">
                                <h2 class="text-5xl font-bold text-zinc-900 dark:text-white tracking-tighter">
                                    {{ $year }}
                                </h2>
                                <div class="h-px flex-grow bg-zinc-100 dark:bg-zinc-800"></div>
                            </div>

                            <div class="grid grid-cols-1 gap-16">
                                @foreach ($posts as $post)
                                    <x-prezet.article :article="$post" :author="config('prezet.authors.' . $post->frontmatter->author)" />
                                @endforeach
                            </div>
                        </section>
                    @endforeach
                </div>

                @if ($paginator->hasPages())
                    <div class="mt-24 border-t border-zinc-100 dark:border-zinc-800 pt-16">
                        {{ $paginator->links() }}
                    </div>
                @endif
            </main>
        </div>
    </div>
</x-prezet.template>
