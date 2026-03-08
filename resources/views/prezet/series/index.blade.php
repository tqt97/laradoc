<x-prezet.template>
    @seo($seo)

    <x-prezet.subpage-header title="Chuỗi bài viết"
        subtitle="Tổng hợp các bài viết theo lộ trình, giúp bạn nắm vững kiến thức một cách bài bản và hệ thống." />

    <div class="py-12 lg:py-24">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($series as $item)
                <div
                    class="group relative flex flex-col bg-white dark:bg-zinc-900 rounded-3xl p-8 transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 ring-1 ring-zinc-200 dark:ring-zinc-800">
                    <div class="flex-grow">
                        <div class="flex items-center gap-4 mb-6">
                            <span
                                class="inline-flex items-center justify-center size-12 rounded-2xl bg-primary-50 dark:bg-primary-900/20 text-primary-600 dark:text-primary-400 font-bold text-lg ring-1 ring-primary-100 dark:ring-primary-900/50 group-hover:scale-110 transition-transform duration-300">
                                {{ $item->postCount }}
                            </span>
                            <span class="text-xs font-bold uppercase tracking-widest text-zinc-400 dark:text-zinc-500">
                                Bài viết
                            </span>
                        </div>

                        <h3
                            class="text-2xl font-bold text-zinc-900 dark:text-white mb-4 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
                            {{ $item->data->frontmatter->title ?? $item->title }}
                        </h3>

                        <p class="text-zinc-500 dark:text-zinc-400 text-sm leading-relaxed line-clamp-3 mb-8">
                            {{ $item->data->frontmatter->excerpt ?? 'Khám phá chuỗi bài viết chi tiết về ' . ($item->data->frontmatter->title ?? $item->title) }}
                        </p>
                    </div>

                    <div
                        class="pt-6 border-t border-zinc-100 dark:border-zinc-800 flex items-center justify-between mt-auto">
                        <span class="text-xs font-bold text-zinc-400 dark:text-zinc-500 flex items-center gap-2">
                            <x-prezet.icon-calendar class="size-3.5" />
                            {{ $item->data->createdAt->format('d/m/yy') }}
                        </span>

                        <a href="{{ route('prezet.series.show', $item->slug . '/index') }}"
                            class="inline-flex items-center gap-2 text-sm font-bold text-primary-600 dark:text-primary-400 hover:gap-3 transition-all duration-300">
                            Bắt đầu đọc
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>

                    {{-- Link Overlay --}}
                    <a href="{{ route('prezet.series.show', $item->slug . '/index') }}"
                        class="absolute inset-0 rounded-3xl" aria-label="{{ $item->title }}"></a>
                </div>
            @endforeach
        </div>

        @if ($series->isEmpty())
            <div
                class="text-center py-24 bg-zinc-50 dark:bg-zinc-900/50 rounded-3xl border-2 border-dashed border-zinc-200 dark:border-zinc-800">
                <div class="mb-6 flex justify-center">
                    <div class="size-16 rounded-2xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-8 text-zinc-400">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                </div>
                <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-2">Chưa có chuỗi bài viết nào</h3>
                <p class="text-zinc-500 dark:text-zinc-400">Nội dung đang được cập nhật, vui lòng quay lại sau.</p>
            </div>
        @endif
    </div>
</x-prezet.template>
