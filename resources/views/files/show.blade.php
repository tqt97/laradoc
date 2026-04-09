<x-layouts.preview :title="$file->name">
    <div x-data="{
        shareModal: false,
        sharePublic: {{ $file->is_public ? 'true' : 'false' }},
        sharePassword: '',
        shareUrl: '{{ route('files.shared', $file->share_token) }}',

        async saveShare() {
            try {
                const response = await fetch(`/files/{{ $file->slug }}/share`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        is_public: this.sharePublic,
                        password: this.sharePassword
                    })
                });
                const data = await response.json();
                this.shareUrl = data.share_url;
                await navigator.clipboard.writeText(this.shareUrl);
                this.shareModal = false;
                window.showToast('Đã lưu và sao chép liên kết!', 'success');
            } catch (error) {
                window.showToast('Lỗi khi lưu cài đặt.', 'error');
            }
        },

        copyShareUrl() {
            navigator.clipboard.writeText(this.shareUrl);
            window.showToast('Đã sao chép liên kết!', 'success');
        }
    }">
        <x-slot:actions>
            <div class="flex items-center gap-2">
                <x-form.button @click="shareModal = true" variant="secondary" class="!px-3 !py-1.5 !rounded-xl !text-xs">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                    </svg>
                    Chia sẻ
                </x-form.button>

                <x-form.button href="{{ asset('storage/' . $file->path) }}" download="{{ $file->name }}" target="_blank" class="!px-3 !py-1.5 !rounded-xl !text-xs">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-3.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                    Tải xuống
                </x-form.button>
            </div>
        </x-slot:actions>

        <div class="h-full">
            {!! $content !!}
        </div>

        {{-- Share Modal --}}
        <template x-teleport="body">
            <div x-show="shareModal" class="fixed inset-0 z-[100] overflow-y-auto" x-cloak>
                <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
                    <div x-show="shareModal" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-zinc-900/80 backdrop-blur-sm transition-opacity"
                        @click="shareModal = false"></div>

                    <div x-show="shareModal" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" @click.stop
                        class="relative inline-block align-middle bg-white dark:bg-zinc-900 rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full ring-1 ring-zinc-900/5 dark:ring-white/10">
                        <div class="px-8 pt-8 pb-10">
                            <div class="flex items-center justify-between mb-8">
                                <h3 class="text-2xl font-bold text-zinc-900 dark:text-white">Chia sẻ tri thức</h3>
                                <button @click="shareModal = false"
                                    class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors p-2"><svg
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg></button>
                            </div>

                            <div class="space-y-6">
                                <div
                                    class="flex items-center justify-between p-6 rounded-3xl bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-100 dark:border-zinc-800">
                                    <div>
                                        <h4 class="font-bold text-zinc-900 dark:text-white">Công khai tài liệu</h4>
                                        <p class="text-xs text-zinc-500">Cho phép mọi người truy cập qua liên kết.</p>
                                    </div>
                                    <button @click="sharePublic = !sharePublic"
                                        :class="sharePublic ? 'bg-primary-500' : 'bg-zinc-200 dark:bg-zinc-700'"
                                        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out">
                                        <span :class="sharePublic ? 'translate-x-5' : 'translate-x-0'"
                                            class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                    </button>
                                </div>

                                <div x-show="sharePublic" class="space-y-4" x-transition>
                                    <div>
                                        <x-form.label value="Mật khẩu bảo vệ (Không bắt buộc)" />
                                        <x-form.input type="password" x-model="sharePassword"
                                            placeholder="••••••••" class="!rounded-2xl" />
                                    </div>

                                    <div
                                        class="p-6 rounded-3xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-100 dark:border-zinc-700">
                                        <x-form.label value="Liên kết truy cập" />
                                        <div class="mt-3 flex gap-2">
                                            <div class="flex-grow">
                                                <input type="text" x-model="shareUrl" readonly
                                                    class="w-full bg-white dark:bg-zinc-900 border-none rounded-xl text-xs py-3 px-4 text-zinc-500 focus:ring-0">
                                            </div>
                                            <button @click="copyShareUrl"
                                                class="shrink-0 p-3 bg-primary-500 text-white rounded-xl transition-all hover:bg-primary-600 active:scale-95 shadow-lg shadow-primary-500/20">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                    stroke-width="2" stroke="currentColor" class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-8 flex gap-4">
                                <x-form.button type="button" variant="secondary" @click="shareModal = false"
                                    class="flex-1 !py-4 !rounded-2xl">Đóng</x-form.button>
                                <x-form.button @click="saveShare" class="flex-1 !py-4 !rounded-2xl">Lưu thiết lập</x-form.button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</x-layouts.preview>
