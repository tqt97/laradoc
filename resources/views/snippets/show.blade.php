<x-prezet.template>
    @seo([
        'title' => $snippet->frontmatter->title . ' - Snippet',
        'description' => $snippet->frontmatter->excerpt,
        'url' => route('snippets.show', $slug),
    ])

    <div id="articles" class="py-12 lg:py-12">
        <div class="max-w-4xl mx-auto px-4">
            <nav class="mb-12">
                <a href="{{ route('snippets.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-bold text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white transition-colors group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke="currentColor" class="size-4 group-hover:-translate-x-1 transition-transform">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Quay lại danh sách
                </a>
            </nav>

            <header class="mb-12">
                <div class="flex flex-wrap items-center justify-between gap-6 mb-4">
                    <h1 class="text-3xl font-bold tracking-tight text-zinc-900 dark:text-white sm:text-4xl">
                        {{ $snippet->frontmatter->title }}
                    </h1>

                    <div class="flex items-center gap-3">
                        @php
                            $langConfig = config(
                                'prezet.snippet_languages.' . ($snippet->language ?? 'txt'),
                                config('prezet.snippet_languages.txt'),
                            );
                        @endphp
                        {{-- <a href="{{ route('snippets.edit', $slug) }}"
                        class="p-2.5 rounded-xl bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 shadow-lg hover:scale-105 active:scale-95 transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                    </svg>
                </a> --}}
                    </div>
                </div>

                <div
                    class="flex items-center justify-between gap-6 text-xs font-bold text-zinc-400 uppercase tracking-widest">
                    <span
                        class="px-3 py-1 rounded-lg {{ $langConfig['bg'] }} {{ $langConfig['text'] }} border {{ $langConfig['border'] }} text-xs font-black uppercase tracking-widest transition-colors">
                        {{ $langConfig['label'] }}
                    </span>
                    <div class="flex items-center gap-2">
                        <x-prezet.icon-calendar class="size-4" />
                        <span>{{ $snippet->createdAt->format('d/m/Y') }}</span>
                    </div>
                </div>
                @if ($snippet->frontmatter->excerpt)
                    <p class="text-lg text-zinc-500 dark:text-zinc-400 leading-relaxed mt-8">
                        {{ $snippet->frontmatter->excerpt }}
                    </p>
                @endif
            </header>

            <div class="relative group">
                <article
                    class="prose prose-zinc dark:prose-invert max-w-none prose-pre:rounded-3xl prose-pre:p-8 prose-pre:shadow-2xl prose-pre:ring-1 prose-pre:ring-zinc-200 dark:prose-pre:ring-zinc-800">
                    {!! $body !!}
                </article>
            </div>
        </div>
    </div>
</x-prezet.template>
