<x-prezet.template>
    <x-prezet.subpage-header title="Duyệt Tài liệu mới"
        subtitle="Phê duyệt các đóng góp tri thức từ cộng đồng.">
        <div class="mt-10 flex gap-4">
            <x-form.button href="{{ route('files.index') }}" variant="secondary" class="!px-6 !py-3 !rounded-2xl">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Quay lại Thư viện
            </x-form.button>
        </div>
    </x-prezet.subpage-header>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if($files->isNotEmpty())
                <div class="grid grid-cols-1 gap-4">
                    @foreach($files as $file)
                        @php 
                            $icon = app(\App\Services\FileService::class)->getIconForMime($file->mime_type);
                        @endphp
                        <div
                            class="group relative flex flex-col md:flex-row md:items-center justify-between p-6 rounded-[2rem] bg-white dark:bg-zinc-950 border border-zinc-100 dark:border-zinc-800 transition-all duration-300 gap-6 hover:shadow-xl">
                            <div class="flex items-center gap-6 min-w-0">
                                <div
                                    class="size-16 rounded-2xl bg-zinc-50 dark:bg-zinc-900 flex items-center justify-center text-zinc-400 shrink-0">
                                    @if($icon === 'book')
                                        <x-icons.book class="size-8" />
                                    @elseif($icon === 'markdown')
                                        <x-icons.markdown class="size-8" />
                                    @else
                                        <x-prezet.icon-file class="size-8" />
                                    @endif
                                </div>
                                <div class="flex flex-col min-w-0">
                                    <div class="flex items-center gap-3">
                                        <h3 class="text-lg font-bold text-zinc-900 dark:text-white truncate">
                                            {{ $file->name }}
                                        </h3>
                                        <span class="px-2 py-0.5 rounded-lg bg-amber-50 dark:bg-amber-500/10 text-[10px] font-bold text-amber-600 dark:text-amber-400 uppercase tracking-wider">
                                            {{ $file->status_moderation->label() }}
                                        </span>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-3 mt-1">
                                        <span class="text-xs text-zinc-500 font-medium">Bởi: <span class="text-zinc-900 dark:text-zinc-300 font-bold">{{ $file->uploader_name }}</span></span>
                                        <span class="text-zinc-300 dark:text-zinc-700 text-xs">•</span>
                                        <span class="text-xs text-zinc-400 dark:text-zinc-500 uppercase">{{ explode('/', $file->mime_type)[1] ?? 'DOC' }}</span>
                                        <span class="text-zinc-300 dark:text-zinc-700 text-xs">•</span>
                                        <span class="text-xs text-zinc-400 dark:text-zinc-500">{{ number_format($file->size / 1024, 1) }} KB</span>
                                        <span class="text-zinc-300 dark:text-zinc-700 text-xs">•</span>
                                        <span class="text-xs text-zinc-400 dark:text-zinc-500">{{ $file->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                <form action="{{ route('files.approve', $file) }}" method="POST" class="inline">
                                    @csrf
                                    <x-form.button type="submit" class="!py-3 !px-6 !rounded-xl !text-xs !bg-green-600 hover:!bg-green-700 shadow-lg shadow-green-500/20">
                                        Duyệt ngay
                                    </x-form.button>
                                </form>
                                <form action="{{ route('files.reject', $file) }}" method="POST" class="inline">
                                    @csrf
                                    <x-form.button type="submit" variant="secondary" class="!py-3 !px-6 !rounded-xl !text-xs text-red-600 border-red-100 hover:bg-red-50">
                                        Từ chối
                                    </x-form.button>
                                </form>
                                <a href="{{ route('files.show', $file) }}" target="_blank"
                                    class="p-3 rounded-xl bg-zinc-50 dark:bg-zinc-900 text-zinc-500 hover:text-primary-500 transition-colors" title="Xem nội dung">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                        stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $files->links() }}
                </div>
            @else
                <div class="py-20 text-center">
                    <div
                        class="size-20 bg-zinc-50 dark:bg-zinc-900/50 rounded-full flex items-center justify-center mx-auto mb-6 text-zinc-300 dark:text-zinc-700 border border-zinc-100 dark:border-zinc-800 shadow-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-2">Đã hoàn thành duyệt bài</h3>
                    <p class="text-zinc-500 dark:text-zinc-400 font-medium">Hiện không có tài liệu nào đang chờ phê duyệt.</p>
                </div>
            @endif
        </div>
    </div>
</x-prezet.template>
