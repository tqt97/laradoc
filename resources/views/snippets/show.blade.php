@php
    /* @var array $seo */
    /* @var object $snippet */
    /* @var string $body */
    /* @var string $slug */
    /* @var int $views */
@endphp

<x-prezet.template>
    @seo($seo)

    <x-prezet.subpage-header :title="$snippet->frontmatter->title" :subtitle="$snippet->frontmatter->excerpt">
        <div class="mt-8 flex flex-wrap justify-center items-center gap-6">
            <div class="flex items-center gap-2 text-xs font-bold text-zinc-400 leading-none">
                <x-prezet.icon-calendar class="size-4 mb-0.5" />
                <span>{{ $snippet->createdAt->format('d/m/Y') }}</span>
            </div>

            <div class="flex items-center gap-2 text-xs font-bold text-zinc-400 leading-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4 mb-0.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12.a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <span>{{ number_format($views ?? 0) }} lượt xem</span>
            </div>

            <span class="hidden sm:block w-1.5 h-1.5 rounded-full bg-zinc-200 dark:bg-zinc-800"></span>

            @php
                $langConfig = config(
                    'prezet.snippet_languages.' . ($snippet->language ?? 'txt'),
                    config('prezet.snippet_languages.txt'),
                );
            @endphp
            <span
                class="px-3 py-1 rounded-3xl {{ $langConfig['bg'] }} {{ $langConfig['text'] }} border {{ $langConfig['border'] }} text-[10px] font-black uppercase tracking-widest">
                {{ $langConfig['label'] }}
            </span>
        </div>
    </x-prezet.subpage-header>

    <div class="py-12 lg:py-20">
        <div class="max-w-4xl mx-auto px-4">
            <div class="flex justify-between items-center mb-12">
                <a href="{{ route('snippets.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-bold text-zinc-500 hover:text-zinc-900 dark:hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Quay lại danh sách
                </a>

                <div class="flex items-center gap-6">
                    <x-prezet.social-share :url="request()->url()" :title="$snippet->frontmatter->title" />

                    @can('manage-snippets')
                    <a href="{{ route('snippets.edit', $slug) }}"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-3xl bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 font-bold text-xs hover:bg-zinc-200 dark:hover:bg-zinc-700 transition-all hover:cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                        </svg>
                        Sửa
                    </a>
                    @endcan
                </div>
            </div>

            <div
                class="prose prose-zinc dark:prose-invert max-w-none
                prose-pre:rounded-3xl prose-pre:border prose-pre:border-zinc-200 dark:prose-pre:border-zinc-800 prose-pre:bg-zinc-50 dark:prose-pre:bg-zinc-900/50 prose-pre:shadow-sm">
                {!! $body !!}
            </div>
        </div>
    </div>
</x-prezet.template>
