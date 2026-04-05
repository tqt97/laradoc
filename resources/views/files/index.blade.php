<x-prezet.template>
    <div x-data="{
        uploadModal: false,
        shareModal: false,
        selectedFile: null,
        sharePublic: false,
        sharePassword: '',
        shareUrl: '',

        // Upload state
        isUploading: false,
        uploadProgress: 0,
        selectedFileName: '',

        handleFileSelect(event) {
            const file = event.target.files[0];
            if (file) {
                this.selectedFileName = file.name;
            }
        },

        async uploadFile() {
            const fileInput = document.getElementById('file-upload');
            if (!fileInput.files.length) return;

            const file = fileInput.files[0];
            const chunkSize = 1024 * 1024; // 1MB chunks
            const totalChunks = Math.ceil(file.size / chunkSize);
            const tempId = 'temp_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);

            this.isUploading = true;
            this.uploadProgress = 0;
            this.selectedFileName = file.name;

            for (let i = 0; i < totalChunks; i++) {
                const start = i * chunkSize;
                const end = Math.min(file.size, start + chunkSize);
                const chunk = file.slice(start, end);

                const formData = new FormData();
                formData.append('file', chunk);
                formData.append('chunk_index', i);
                formData.append('temp_id', tempId);
                formData.append('_token', '{{ csrf_token() }}');

                try {
                    await new Promise((resolve, reject) => {
                        const xhr = new XMLHttpRequest();
                        xhr.open('POST', '{{ route('files.upload-chunk') }}', true);
                        xhr.onload = () => xhr.status === 200 ? resolve() : reject();
                        xhr.onerror = reject;
                        xhr.send(formData);
                    });
                    this.uploadProgress = Math.round(((i + 1) / totalChunks) * 100);
                } catch (error) {
                    window.showToast('Lỗi khi tải lên phần ' + (i + 1), 'error');
                    this.isUploading = false;
                    return;
                }
            }

            // All chunks uploaded, complete the process
            try {
                const response = await fetch('{{ route('files.upload-complete') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        temp_id: tempId,
                        file_name: file.name,
                        total_chunks: totalChunks,
                        mime_type: file.type || 'application/octet-stream',
                        total_size: file.size
                    })
                });

                if (response.ok) {
                    this.uploadProgress = 100;
                    window.showToast('Tải lên hoàn tất! Đang xử lý...', 'success');
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    throw new Error();
                }
            } catch (error) {
                window.showToast('Lỗi khi hoàn tất tải lên.', 'error');
                this.isUploading = false;
            }
        },

        openShare(file) {
            this.selectedFile = file;
            this.sharePublic = file.is_public;
            this.sharePassword = '';
            this.shareUrl = '{{ url('/s') }}/' + file.share_token;
            this.shareModal = true;
        },

        async saveShare() {
            try {
                const response = await fetch(`/files/${this.selectedFile.id}/share`, {
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

                // Auto copy to clipboard
                await navigator.clipboard.writeText(this.shareUrl);

                // Update local state
                this.selectedFile.is_public = this.sharePublic;

                // Close modal and show reload or just feedback
                this.shareModal = false;
                
                window.showToast('Đã lưu và sao chép liên kết!', 'success');
                setTimeout(() => window.location.reload(), 1000);
            } catch (error) {
                console.error('Error sharing file:', error);
                window.showToast('Lỗi khi lưu cài đặt.', 'error');
            }
        },

        copyShareUrl() {
            navigator.clipboard.writeText(this.shareUrl);
            window.showToast('Đã sao chép liên kết!', 'success');
        }
    }">
        <x-prezet.subpage-header title="Quản lý tệp tin"
            subtitle="Tải lên, xem trước và chia sẻ các tệp văn bản, Markdown hoặc PDF một cách an toàn.">
            <div class="mt-10">
                <x-form.button @click="uploadModal = true" class="!px-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    Tải lên tệp mới
                </x-form.button>
            </div>
        </x-prezet.subpage-header>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @if($files->isNotEmpty())
                    <div class="grid grid-cols-1 gap-4">
                        @foreach($files as $file)
                            <div
                                class="group relative flex items-center justify-between p-4 sm:p-5 rounded-2xl bg-white dark:bg-zinc-950 border border-zinc-100 dark:border-zinc-800 hover:border-primary-500/50 hover:shadow-xl hover:shadow-primary-500/5 transition-all duration-300">
                                <div class="flex items-center gap-4 min-w-0">
                                    <div
                                        class="size-12 rounded-xl bg-zinc-50 dark:bg-zinc-900 flex items-center justify-center text-zinc-400 group-hover:text-primary-500 transition-colors shrink-0">
                                        @if($file->mime_type === 'application/pdf')
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                            </svg>
                                        @else
                                            <x-prezet.icon-file class="size-6" />
                                        @endif
                                    </div>
                                    <div class="flex flex-col min-w-0">
                                        <a href="{{ route('files.show', $file) }}"
                                            class="text-base font-bold text-zinc-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors truncate">
                                            {{ $file->name }}
                                        </a>
                                        <div class="flex items-center gap-3 mt-1">
                                            <span
                                                class="text-xs text-zinc-400 dark:text-zinc-500 uppercase">{{ explode('/', $file->mime_type)[1] ?? $file->mime_type }}</span>
                                            <span class="text-zinc-300 dark:text-zinc-700 text-xs">•</span>
                                            <span
                                                class="text-xs text-zinc-400 dark:text-zinc-500">{{ number_format($file->size / 1024, 1) }}
                                                KB</span>
                                            @if($file->is_public)
                                                <span class="text-zinc-300 dark:text-zinc-700 text-xs">•</span>
                                                <span
                                                    class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-green-50 dark:bg-green-500/10 text-[10px] font-bold text-green-600 dark:text-green-400 uppercase tracking-wider">
                                                    Công khai
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <x-form.button type="button" variant="secondary"
                                        @click="openShare({{ json_encode($file) }})" class="!py-2 !px-4 !rounded-xl">
                                        Chia sẻ
                                    </x-form.button>
                                    <a href="{{ route('files.show', $file) }}"
                                        class="p-2 rounded-xl bg-zinc-100 dark:bg-zinc-800 text-zinc-500 hover:text-primary-500 transition-colors">
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
                @else
                    <div class="py-20 text-center">
                        <div
                            class="size-16 bg-zinc-50 dark:bg-zinc-900/50 rounded-full flex items-center justify-center mx-auto mb-4 text-zinc-300 dark:text-zinc-700 border border-zinc-100 dark:border-zinc-800">
                            <x-prezet.icon-file class="size-8" />
                        </div>
                        <p class="text-zinc-500 dark:text-zinc-400 font-medium">Chưa có tệp tin nào được tải lên.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Upload Modal --}}
        <template x-teleport="body">
            <div x-show="uploadModal" class="fixed inset-0 z-[100] overflow-y-auto" x-cloak>
                <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
                    <div x-show="uploadModal" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0"
                        class="fixed inset-0 bg-zinc-900/80 backdrop-blur-sm transition-opacity"
                        @click="uploadModal = false"></div>

                    <div x-show="uploadModal" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" @click.stop
                        class="relative inline-block align-middle bg-white dark:bg-zinc-900 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full ring-1 ring-zinc-900/5 dark:ring-white/10">
                        <div class="px-8 pt-8 pb-10">
                            <div class="flex items-center justify-between mb-8">
                                <h3 class="text-2xl font-bold text-zinc-900 dark:text-white">Tải lên tệp mới</h3>
                                <button @click="uploadModal = false"
                                    class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors p-2"><svg
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg></button>
                            </div>

                            <div x-show="!isUploading">
                                <form @submit.prevent="uploadFile()" enctype="multipart/form-data" class="space-y-6">
                                    @csrf
                                    <div>
                                        <x-form.label value="Chọn tệp tin (TXT, MD, PDF)" required="true" />
                                        <div
                                            class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-zinc-100 dark:border-zinc-800 border-dashed rounded-3xl hover:border-primary-500/50 transition-colors group">
                                            <div class="space-y-1 text-center">
                                                <svg class="mx-auto h-12 w-12 text-zinc-300 group-hover:text-primary-500 transition-colors"
                                                    stroke="currentColor" fill="none" viewBox="0 0 48 48"
                                                    aria-hidden="true">
                                                    <path
                                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <div class="flex text-sm text-zinc-600 dark:text-zinc-400">
                                                    <label for="file-upload"
                                                        class="relative cursor-pointer bg-transparent rounded-md font-bold text-primary-600 hover:text-primary-500">
                                                        <span x-text="selectedFileName || 'Tải lên một tệp'"></span>
                                                        <input id="file-upload" name="file" type="file" class="sr-only"
                                                            required accept=".txt,.md,.pdf" @change="handleFileSelect($event)">
                                                    </label>
                                                    <p class="pl-1" x-show="!selectedFileName">hoặc kéo và thả</p>
                                                </div>
                                                <p class="text-xs text-zinc-500">TXT, MD, PDF lên đến 30MB</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-4 flex gap-4">
                                        <x-form.button type="button" variant="secondary" @click="uploadModal = false"
                                            class="flex-1">Hủy bỏ</x-form.button>
                                        <x-form.button class="flex-1">Bắt đầu tải lên</x-form.button>
                                    </div>
                                </form>
                            </div>

                            <div x-show="isUploading" class="space-y-6">
                                <div class="text-center">
                                    <div class="mb-4">
                                        <span class="text-zinc-500 text-sm">Đang tải lên: </span>
                                        <span class="font-bold text-zinc-900 dark:text-white" x-text="selectedFileName"></span>
                                    </div>
                                    <div class="w-full bg-zinc-100 dark:bg-zinc-800 rounded-full h-4 overflow-hidden shadow-inner">
                                        <div class="bg-primary-500 h-4 rounded-full transition-all duration-300 shadow-[0_0_10px_rgba(var(--primary-500-rgb),0.5)]"
                                            :style="`width: ${uploadProgress}%` text-align: center; color: white; font-size: 10px; line-height: 1rem;">
                                            <span x-text="uploadProgress + '%'"></span>
                                        </div>
                                    </div>
                                    <p class="mt-4 text-zinc-500 text-sm">Vui lòng không đóng cửa sổ này...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>

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
                        class="relative inline-block align-middle bg-white dark:bg-zinc-900 rounded-3xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-lg sm:w-full ring-1 ring-zinc-900/5 dark:ring-white/10">
                        <div class="px-8 pt-8 pb-10">
                            <div class="flex items-center justify-between mb-8">
                                <h3 class="text-2xl font-bold text-zinc-900 dark:text-white">Cài đặt chia sẻ</h3>
                                <button @click="shareModal = false"
                                    class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors p-2"><svg
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg></button>
                            </div>

                            <div class="space-y-6">
                                <div
                                    class="flex items-center justify-between p-4 rounded-2xl bg-zinc-50 dark:bg-zinc-800/50">
                                    <div>
                                        <h4 class="font-bold text-zinc-900 dark:text-white">Chế độ công khai</h4>
                                        <p class="text-xs text-zinc-500">Bất kỳ ai có liên kết đều có thể xem tệp này.
                                        </p>
                                    </div>
                                    <button @click="sharePublic = !sharePublic"
                                        :class="sharePublic ? 'bg-primary-500' : 'bg-zinc-200 dark:bg-zinc-700'"
                                        class="relative inline-flex h-6 w-11 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out">
                                        <span :class="sharePublic ? 'translate-x-5' : 'translate-x-0'"
                                            class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                    </button>
                                </div>

                                <div x-show="sharePublic" class="space-y-4">
                                    <div>
                                        <x-form.label value="Mật khẩu bảo vệ (tùy chọn)" />
                                        <x-form.input type="password" x-model="sharePassword"
                                            placeholder="Nhập mật khẩu nếu muốn" />
                                    </div>

                                    <div
                                        class="p-4 rounded-2xl bg-zinc-50 dark:bg-zinc-800 border border-zinc-100 dark:border-zinc-700">
                                        <x-form.label value="Liên kết chia sẻ" />
                                        <div class="mt-2 flex gap-2">
                                            <div class="flex-grow">
                                                <input type="text" x-model="shareUrl" readonly
                                                    class="w-full bg-white dark:bg-zinc-900 border-none rounded-xl text-xs py-2 px-3 text-zinc-500 focus:ring-0">
                                            </div>
                                            <button @click="copyShareUrl"
                                                class="shrink-0 p-2 text-primary-600 hover:bg-primary-50 dark:hover:bg-primary-900/20 rounded-xl transition-colors">
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
                                    class="flex-1">Đóng</x-form.button>
                                <x-form.button @click="saveShare" class="flex-1">Lưu thay đổi</x-form.button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</x-prezet.template>
