<x-prezet.template>
    @seo($seo)

    <x-prezet.subpage-header title="Chuỗi bài viết"
        subtitle="Tổng hợp các bài viết theo lộ trình, giúp bạn nắm vững kiến thức một cách bài bản và hệ thống.">
        <x-prezet.index-search :action="route('prezet.series.index')" :value="$search ?? ''" placeholder="Tìm kiếm chuỗi bài viết..." />
    </x-prezet.subpage-header>

    <div class="py-12 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            @foreach ($series as $item)
                <x-prezet.series-card :series="$item" />
            @endforeach
        </div>

        @if ($series->isEmpty())
            <div
                class="text-center py-24 bg-zinc-50 dark:bg-zinc-900/50 rounded-3xl border-2 border-dashed border-zinc-200 dark:border-zinc-800">
                <div class="mb-6 flex justify-center">
                    <div class="size-16 rounded-3xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center">
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
