@php
    /* @var array $seo */
    /* @var \Illuminate\Pagination\LengthAwarePaginator $links */
@endphp

<x-prezet.template>
    @seo($seo)

    <div x-data="{ createModal: false, deleteModal: false, deleteUrl: '' }">
        <x-prezet.subpage-header title="Liên kết đã lưu"
            subtitle="Nơi lưu trữ và chia sẻ những liên kết hữu ích, tài liệu và công cụ thú vị.">
            <div class="mt-10">
                <button @click="createModal = true"
                    class="inline-flex items-center gap-2 px-6 py-3 rounded-2xl bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 font-bold text-sm shadow-xl hover:scale-[1.02] active:scale-[0.98] transition-all group hover:cursor-pointer hover:bg-primary-600 dark:hover:bg-primary-500 dark:hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke="currentColor" class="size-4 group-hover:rotate-90 transition-transform duration-300">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Thêm liên kết mới
                </button>
            </div>
        </x-prezet.subpage-header>

        <div id="articles" class="py-12 lg:py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{-- Links List --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @forelse($links as $link)
                        <div x-data="{ open: false, editing: false }" class="relative w-full min-w-0">
                            <!-- View Mode -->
                            <div x-show="!editing" class="group relative flex items-center gap-2 w-full">
                                <a href="{{ $link->url }}" target="_blank" @mouseenter="open = true"
                                    @mouseleave="open = false"
                                    class="flex-grow flex items-center justify-between p-4 sm:p-5 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-100 dark:border-zinc-800 hover:border-primary-500/50 hover:shadow-xl hover:shadow-primary-500/5 transition-all duration-300 min-w-0">
                                    <div class="flex items-center gap-3 sm:gap-4 min-w-0">
                                        <div
                                            class="size-10 rounded-xl bg-zinc-50 dark:bg-zinc-800 flex items-center justify-center text-zinc-400 group-hover:text-primary-500 transition-colors shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor" class="size-5">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                                            </svg>
                                        </div>
                                        <div class="flex flex-col min-w-0 overflow-hidden">
                                            <span
                                                class="text-sm sm:text-base font-bold text-zinc-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors truncate">
                                                {{ $link->title }}
                                            </span>
                                            <span
                                                class="text-[10px] sm:text-xs text-zinc-400 dark:text-zinc-500 truncate">
                                                {{ parse_url($link->url, PHP_URL_HOST) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-zinc-300 dark:text-zinc-700 shrink-0 ml-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="size-4 sm:size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                                        </svg>
                                    </div>
                                </a>

                                {{-- Action Buttons --}}
                                <div class="flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button @click="editing = true"
                                        class="p-2 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-zinc-500 hover:text-primary-500 transition-colors hover:cursor-pointer"
                                        title="Sửa">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>
                                    </button>
                                    <button type="button"
                                        @click="deleteUrl = '{{ route('links.destroy', $link) }}'; deleteModal = true"
                                        class="p-2 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-zinc-500 hover:text-red-500 transition-colors hover:cursor-pointer"
                                        title="Xóa">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m14.74 9-.34 12m-4.74 0-.34-12m4.74 0h1.174m-4.74 0H9.26m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.108 0 0 0-7.5 0" />
                                        </svg>
                                    </button>
                                </div>

                                {{-- Preview Image --}}
                                @if ($link->og_image)
                                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
                                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                                        x-transition:leave="transition ease-in duration-150"
                                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                                        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
                                        class="absolute left-1/2 -translate-x-1/2 bottom-full mb-4 z-[70] w-80 p-2 bg-white dark:bg-zinc-800 rounded-2xl shadow-2xl ring-1 ring-zinc-200 dark:ring-zinc-700 pointer-events-none">
                                        <img src="{{ $link->og_image }}"
                                            class="w-full h-auto aspect-video object-cover rounded-xl shadow-sm"
                                            alt="Preview" onerror="this.parentElement.style.display='none'">
                                    </div>
                                @endif
                            </div>

                            <!-- Edit Mode -->
                            <div x-show="editing" x-cloak
                                class="p-5 rounded-2xl bg-zinc-50 dark:bg-zinc-800/50 border border-primary-500/30">
                                <form action="{{ route('links.update', $link) }}" method="POST" class="space-y-4">
                                    @csrf
                                    @method('PUT')
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="space-y-1">
                                            <label
                                                class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">Tiêu
                                                đề</label>
                                            <input type="text" name="title" value="{{ $link->title }}" required
                                                class="w-full px-3 py-2 rounded-lg bg-white dark:bg-zinc-900 border-zinc-200 dark:border-zinc-700 text-sm focus:ring-2 focus:ring-primary-500 outline-none dark:text-white" />
                                        </div>
                                        <div class="space-y-1">
                                            <label
                                                class="text-[10px] font-bold uppercase tracking-wider text-zinc-500">URL</label>
                                            <input type="url" name="url" value="{{ $link->url }}" required
                                                class="w-full px-3 py-2 rounded-lg bg-white dark:bg-zinc-900 border-zinc-200 dark:border-zinc-700 text-sm focus:ring-2 focus:ring-primary-500 outline-none dark:text-white" />
                                        </div>
                                    </div>
                                    <div class="flex justify-end gap-2">
                                        <button type="button" @click="editing = false"
                                            class="px-4 py-2 rounded-lg text-xs font-bold text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300 transition-colors hover:cursor-pointer">
                                            Hủy
                                        </button>
                                        <button type="submit"
                                            class="px-4 py-2 rounded-lg bg-primary-600 text-white text-xs font-bold shadow-md hover:bg-primary-700 transition-colors hover:cursor-pointer">
                                            Cập nhật
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="py-20 text-center">
                            <div
                                class="size-16 bg-zinc-50 dark:bg-zinc-900 rounded-full flex items-center justify-center mx-auto mb-4 text-zinc-300 dark:text-zinc-700">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                                </svg>
                            </div>
                            <p class="text-zinc-500 dark:text-zinc-400 font-medium">Chưa có liên kết nào được lưu trữ.
                            </p>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                @if ($links->hasPages())
                    <div class="mt-12 border-t border-zinc-100 dark:border-zinc-800 pt-8">
                        {{ $links->links() }}
                    </div>
                @endif
            </div>

            {{-- Create Link Modal --}}
            <template x-teleport="body">
                <div x-show="createModal" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title"
                    role="dialog" aria-modal="true" x-cloak>
                    <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
                        {{-- Backdrop --}}
                        <div x-show="createModal" x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="fixed inset-0 bg-zinc-900/80 backdrop-blur-sm transition-opacity"
                            @click="createModal = false" aria-hidden="true"></div>

                        {{-- Modal Content --}}
                        <div x-show="createModal" x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave="ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" @click.stop
                            class="relative inline-block align-middle bg-white dark:bg-zinc-900 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full border border-zinc-200 dark:border-zinc-800">

                            <div class="px-8 pt-8 pb-6">
                                <div class="flex items-center justify-between mb-8">
                                    <h3 class="text-2xl font-bold text-zinc-900 dark:text-white" id="modal-title">
                                        Thêm liên kết mới
                                    </h3>
                                    <button @click="createModal = false"
                                        class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors hover:cursor-pointer hover:bg-zinc-100 dark:hover:bg-zinc-800 rounded-md p-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6 18 18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <form action="{{ route('links.store') }}" method="POST" class="space-y-6">
                                    @csrf
                                    <div class="space-y-4">
                                        <div class="space-y-2">
                                            <label for="modal_url"
                                                class="text-sm font-bold text-zinc-700 dark:text-zinc-300 ml-1">Đường
                                                dẫn
                                                (URL) <span class="text-red-500">*</span></label>
                                            <input type="url" name="url" id="modal_url" required
                                                placeholder="https://example.com"
                                                class="mt-1 w-full px-4 py-3 rounded-2xl bg-zinc-50 dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700 text-sm focus:ring-2 focus:ring-primary-500 transition-all outline-none dark:text-white"
                                                autofocus />
                                        </div>
                                        <div class="space-y-2">
                                            <label for="modal_title"
                                                class="text-sm font-bold text-zinc-700 dark:text-zinc-300 ml-1">Tiêu đề
                                                (Tùy chọn)</label>
                                            <input type="text" name="title" id="modal_title"
                                                placeholder="Nhập tiêu đề hoặc để trống"
                                                class="mt-1 w-full px-4 py-3 rounded-2xl bg-zinc-50 dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700 text-sm focus:ring-2 focus:ring-primary-500 transition-all outline-none dark:text-white" />
                                        </div>
                                    </div>

                                    <div class="pt-4 flex gap-3">
                                        <button type="button" @click="createModal = false"
                                            class="flex-1 px-6 py-3 rounded-2xl border border-zinc-200 dark:border-zinc-700 text-zinc-600 dark:text-zinc-400 font-bold text-sm hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-all hover:cursor-pointer">
                                            Hủy bỏ
                                        </button>
                                        <button type="submit"
                                            class="flex-1 px-6 py-3 rounded-2xl bg-primary-500 dark:bg-white text-white dark:text-zinc-900 font-bold text-sm shadow-xl hover:scale-[1.02] active:scale-[0.98] transition-all hover:cursor-pointer hover:bg-primary-600 dark:hover:bg-primary-500 dark:hover:text-white">
                                            Lưu liên kết
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </template>

            {{-- Delete Confirmation Modal --}}
            <template x-teleport="body">
                <div x-show="deleteModal" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title"
                    role="dialog" aria-modal="true" x-cloak>
                    <div
                        class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                        {{-- Backdrop --}}
                        <div x-show="deleteModal" x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                            x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            class="fixed inset-0 bg-zinc-900/80 backdrop-blur-sm transition-opacity"
                            @click="deleteModal = false" aria-hidden="true"></div>

                        {{-- This element is to trick the browser into centering the modal contents. --}}
                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                            aria-hidden="true">&#8203;</span>

                        {{-- Modal Content --}}
                        <div x-show="deleteModal" x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave="ease-in duration-200"
                            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" @click.stop
                            class="relative inline-block align-middle bg-white dark:bg-zinc-900 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full border border-zinc-200 dark:border-zinc-800">

                            <div class="px-8 pt-8 pb-8">
                                <div class="sm:flex sm:items-start">
                                    <div
                                        class="mx-auto flex-shrink-0 flex items-center justify-center h-14 w-14 rounded-2xl bg-red-100 dark:bg-red-500/10 sm:mx-0">
                                        <svg class="h-8 w-8 text-red-600 dark:text-red-500"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                        </svg>
                                    </div>
                                    <div class="mt-4 text-center sm:mt-0 sm:ml-6 sm:text-left">
                                        <h3 class="text-2xl font-bold text-zinc-900 dark:text-white" id="modal-title">
                                            Xác nhận xóa
                                        </h3>
                                        <div class="mt-3">
                                            <p
                                                class="text-sm text-zinc-500 dark:text-zinc-400 font-medium leading-relaxed">
                                                Bạn có chắc chắn muốn xóa liên kết này không? Hành động này không thể
                                                hoàn
                                                tác.
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-10 flex flex-col-reverse sm:flex-row sm:justify-end gap-3">
                                    <button type="button" @click="deleteModal = false"
                                        class="w-full sm:w-auto px-6 py-3 rounded-2xl border border-zinc-200 dark:border-zinc-700 text-zinc-600 dark:text-zinc-400 font-bold text-sm hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-all hover:cursor-pointer">
                                        Hủy bỏ
                                    </button>
                                    <form :action="deleteUrl" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="w-full sm:w-auto px-10 py-3 rounded-2xl bg-red-600 text-white font-bold text-sm shadow-xl hover:bg-red-700 hover:scale-[1.02] active:scale-[0.98] transition-all hover:cursor-pointer">
                                            Xóa liên kết
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </template>
        </div>
</x-prezet.template>
