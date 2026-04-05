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
        filesToUpload: [], // { name, size, type, progress, status, id }
        uploaderName: '{{ Auth::user()?->name ?? '' }}',

        handleFileSelect(event) {
            const files = Array.from(event.target.files);
            this.filesToUpload = files.map(f => ({
                file: f,
                name: f.name,
                size: f.size,
                type: f.type || 'application/octet-stream',
                progress: 0,
                status: 'pending',
                id: null
            }));
        },

        async uploadFiles() {
            if (this.filesToUpload.length === 0) return;
            this.isUploading = true;

            for (let i = 0; i < this.filesToUpload.length; i++) {
                const item = this.filesToUpload[i];
                item.status = 'creating';

                try {
                    const createResponse = await fetch('{{ route('files.create-virtual') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            name: item.name,
                            size: item.size,
                            mime_type: item.type,
                            uploader_name: this.uploaderName
                        })
                    });
                    const createData = await createResponse.json();
                    item.id = createData.file.id;
                    item.status = 'uploading';

                    const chunkSize = 1024 * 1024; // 1MB chunks
                    const totalChunks = Math.ceil(item.size / chunkSize);
                    const tempId = 'temp_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);

                    for (let j = 0; j < totalChunks; j++) {
                        const start = j * chunkSize;
                        const end = Math.min(item.size, start + chunkSize);
                        const chunk = item.file.slice(start, end);

                        const formData = new FormData();
                        formData.append('file', chunk);
                        formData.append('chunk_index', j);
                        formData.append('temp_id', tempId);
                        formData.append('_token', '{{ csrf_token() }}');

                        await new Promise((resolve, reject) => {
                            const xhr = new XMLHttpRequest();
                            xhr.open('POST', '{{ route('files.upload-chunk') }}', true);
                            xhr.onload = () => xhr.status === 200 ? resolve() : reject();
                            xhr.onerror = reject;
                            xhr.send(formData);
                        });
                        item.progress = Math.round(((j + 1) / totalChunks) * 100);
                    }

                    await fetch('{{ route('files.upload-complete') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            file_id: item.id,
                            temp_id: tempId,
                            total_chunks: totalChunks
                        })
                    });

                    item.status = 'completed';
                    item.progress = 100;

                } catch (error) {
                    item.status = 'error';
                }
            }

            this.isUploading = false;
            this.uploadModal = false;
            window.location.reload();
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
                const response = await fetch(`/files/${this.selectedFile.slug}/share`, {
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
                this.selectedFile.is_public = this.sharePublic;
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
        <x-prezet.subpage-header title="Thư viện Tài liệu"
            subtitle="Khám phá, đọc và chia sẻ kiến thức từ cộng đồng.">
            <div class="mt-10 flex flex-col md:flex-row gap-4 items-center">
                <form action="{{ route('files.index') }}" method="GET" class="relative w-full md:w-96 group">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Tìm kiếm sách, tác giả..."
                        class="w-full bg-white dark:bg-zinc-900 border-zinc-200 dark:border-zinc-800 rounded-2xl py-3 pl-12 pr-4 focus:ring-primary-500 focus:border-primary-500 transition-all shadow-sm group-hover:shadow-md">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-zinc-400 group-focus-within:text-primary-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </div>
                </form>

                <div class="flex gap-3">
                    <x-form.button @click="uploadModal = true" class="!px-6 !py-3 !rounded-2xl shadow-lg shadow-primary-500/20">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Đóng góp tài liệu
                    </x-form.button>

                    @if(Auth::check() && Auth::user()->hasRole('admin'))
                        <x-form.button href="{{ route('files.review') }}" variant="secondary" class="!px-6 !py-3 !rounded-2xl">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            Duyệt bài
                        </x-form.button>
                    @endif
                </div>
            </div>
        </x-prezet.subpage-header>

        <div class="py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                @if($files->isNotEmpty())
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($files as $file)
                            @php 
                                $isProcessing = $file->status_upload !== \App\Enums\FileUploadStatus::READY; 
                                $isPending = $file->status_moderation === \App\Enums\FileModerationStatus::PENDING;
                                $isRejected = $file->status_moderation === \App\Enums\FileModerationStatus::REJECTED;
                                $isAdmin = Auth::check() && Auth::user()->hasRole('admin');
                                $icon = app(\App\Services\FileService::class)->getIconForMime($file->mime_type);
                            @endphp
                            <div class="group flex flex-col bg-white dark:bg-zinc-950 border border-zinc-100 dark:border-zinc-800 rounded-3xl overflow-hidden transition-all duration-300 hover:shadow-2xl hover:shadow-zinc-200/50 dark:hover:shadow-primary-900/10 hover:-translate-y-1 {{ ($isProcessing || $isPending) ? 'opacity-75' : '' }}">
                                <div class="relative aspect-[4/3] bg-zinc-50 dark:bg-zinc-900 flex items-center justify-center p-8">
                                    <div class="text-zinc-300 dark:text-zinc-700 group-hover:text-primary-500 transition-colors duration-500">
                                        @if($icon === 'book')
                                            <x-icons.book class="size-20" />
                                        @elseif($icon === 'markdown')
                                            <x-icons.markdown class="size-20" />
                                        @else
                                            <x-prezet.icon-file class="size-20" />
                                        @endif
                                    </div>
                                    
                                    @if($isPending)
                                        <div class="absolute top-4 right-4 px-2 py-1 rounded-lg bg-amber-500/10 backdrop-blur-md text-amber-600 text-[10px] font-bold uppercase tracking-wider border border-amber-500/20">
                                            Chờ duyệt
                                        </div>
                                    @endif

                                    @if($isProcessing)
                                        <div class="absolute inset-0 bg-white/60 dark:bg-zinc-950/60 backdrop-blur-[2px] flex flex-col items-center justify-center gap-3">
                                            <div class="size-10 border-4 border-primary-500/20 border-t-primary-500 rounded-full animate-spin"></div>
                                            <span class="text-[10px] font-bold text-zinc-600 dark:text-zinc-400 uppercase tracking-widest animate-pulse">
                                                {{ $file->status_upload->label() }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-6 flex flex-col flex-1">
                                    <div class="flex-1 min-h-[3.5rem] relative">
                                        @if($isProcessing || ($isPending && !$isAdmin))
                                            <h3 class="text-lg font-bold text-zinc-400 dark:text-zinc-600 line-clamp-2 group-hover:line-clamp-none transition-all duration-300 leading-tight" title="{{ $file->name }}">
                                                {{ $file->name }}
                                            </h3>
                                        @else
                                            <a href="{{ route('files.show', $file) }}" class="text-lg font-bold text-zinc-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-all duration-300 line-clamp-2 group-hover:line-clamp-none leading-tight" title="{{ $file->name }}">
                                                {{ $file->name }}
                                            </a>
                                        @endif
                                        
                                        <div class="mt-3 flex items-center gap-2">
                                            <div class="size-6 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-[10px] font-bold text-zinc-500 uppercase">
                                                {{ substr($file->uploader_name, 0, 1) }}
                                            </div>
                                            <span class="text-xs text-zinc-500 truncate">Bởi <span class="font-semibold text-zinc-700 dark:text-zinc-300">{{ $file->uploader_name }}</span></span>
                                        </div>
                                    </div>

                                    <div class="mt-6 pt-6 border-t border-zinc-50 dark:border-zinc-900 flex items-center justify-between">
                                        <div class="flex flex-col">
                                            <span class="text-[10px] text-zinc-400 uppercase font-bold tracking-wider">{{ strtoupper(explode('/', $file->mime_type)[1] ?? 'DOC') }}</span>
                                            <span class="text-[10px] text-zinc-500">{{ number_format($file->size / 1024, 1) }} KB</span>
                                        </div>

                                        <div class="flex gap-1">
                                            <button @click="openShare({{ json_encode($file) }})" 
                                                class="p-2 rounded-xl bg-zinc-50 dark:bg-zinc-900 text-zinc-400 hover:text-primary-500 hover:bg-primary-50 dark:hover:bg-primary-900/20 transition-all {{ ($isProcessing || $isPending) ? 'cursor-not-allowed' : '' }}"
                                                :disabled="{{ ($isProcessing || $isPending) ? 'true' : 'false' }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                                                </svg>
                                            </button>
                                            
                                            @if(!$isProcessing && (!$isPending || $isAdmin))
                                                <a href="{{ route('files.show', $file) }}" class="p-2 rounded-xl bg-primary-500 text-white shadow-lg shadow-primary-500/20 hover:bg-primary-600 transition-all">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.967 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.967 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-12">
                        {{ $files->links() }}
                    </div>
                @else
                    <div class="py-20 text-center">
                        <div class="size-20 bg-zinc-50 dark:bg-zinc-900/50 rounded-full flex items-center justify-center mx-auto mb-6 text-zinc-300 dark:text-zinc-700 border border-zinc-100 dark:border-zinc-800 shadow-inner">
                            <x-icons.book class="size-10" />
                        </div>
                        <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-2">Thư viện đang trống</h3>
                        <p class="text-zinc-500 dark:text-zinc-400 font-medium max-w-sm mx-auto">Chưa có tài liệu nào phù hợp với tìm kiếm của bạn hoặc thư viện chưa có nội dung.</p>
                        <div class="mt-8">
                            <x-form.button @click="uploadModal = true" variant="secondary">Tải lên tài liệu đầu tiên</x-form.button>
                        </div>
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
                        @click="if(!isUploading) uploadModal = false"></div>

                    <div x-show="uploadModal" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" @click.stop
                        class="relative inline-block align-middle bg-white dark:bg-zinc-900 rounded-[2rem] text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-xl sm:w-full ring-1 ring-zinc-900/5 dark:ring-white/10">
                        <div class="px-8 pt-8 pb-10">
                            <div class="flex items-center justify-between mb-8">
                                <h3 class="text-2xl font-bold text-zinc-900 dark:text-white">Đóng góp tri thức</h3>
                                <button @click="uploadModal = false" x-show="!isUploading"
                                    class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors p-2"><svg
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg></button>
                            </div>

                            <div x-show="!isUploading">
                                <form @submit.prevent="uploadFiles()" enctype="multipart/form-data" class="space-y-6">
                                    @csrf
                                    @guest
                                    <div>
                                        <x-form.label value="Tên tác giả / Người đóng góp" required="true" />
                                        <x-form.input x-model="uploaderName" placeholder="Nhập tên của bạn" required class="!rounded-2xl" />
                                    </div>
                                    @endguest

                                    <div>
                                        <x-form.label value="Chọn tài liệu (PDF, Markdown, Text)" required="true" />
                                        <div
                                            class="mt-2 flex justify-center px-6 pt-10 pb-10 border-2 border-zinc-100 dark:border-zinc-800 border-dashed rounded-[2rem] hover:border-primary-500/50 transition-colors group bg-zinc-50/50 dark:bg-zinc-900/30">
                                            <div class="space-y-2 text-center">
                                                <div class="flex justify-center text-zinc-300 group-hover:text-primary-500 transition-colors duration-500">
                                                    <x-icons.book class="size-16" />
                                                </div>
                                                <div class="flex text-sm text-zinc-600 dark:text-zinc-400 justify-center">
                                                    <label for="file-upload"
                                                        class="relative cursor-pointer bg-transparent rounded-md font-bold text-primary-600 hover:text-primary-500">
                                                        <span x-text="filesToUpload.length > 0 ? 'Đã chọn ' + filesToUpload.length + ' tài liệu' : 'Chọn tệp từ máy tính'"></span>
                                                        <input id="file-upload" name="file[]" type="file" class="sr-only"
                                                            required accept=".txt,.md,.pdf" multiple @change="handleFileSelect($event)">
                                                    </label>
                                                </div>
                                                <p class="text-[10px] text-zinc-400 uppercase tracking-widest font-bold">Tối đa 30MB mỗi tệp</p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-4 flex gap-4">
                                        <x-form.button type="button" variant="secondary" @click="uploadModal = false"
                                            class="flex-1 !py-4 !rounded-2xl">Hủy</x-form.button>
                                        <x-form.button class="flex-1 !py-4 !rounded-2xl">Bắt đầu tải lên</x-form.button>
                                    </div>
                                </form>
                            </div>

                            <div x-show="isUploading" class="space-y-4 max-h-[400px] overflow-y-auto px-1">
                                <template x-for="(item, index) in filesToUpload" :key="index">
                                    <div class="p-5 rounded-3xl bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-100 dark:border-zinc-700">
                                        <div class="flex justify-between items-center mb-3">
                                            <div class="flex items-center gap-3">
                                                <div class="text-zinc-400"><x-icons.book class="size-5" /></div>
                                                <span class="text-sm font-bold text-zinc-900 dark:text-white truncate max-w-[250px]" x-text="item.name"></span>
                                            </div>
                                            <span class="text-[10px] font-bold text-primary-500" x-text="item.status === 'completed' ? 'HOÀN TẤT' : (item.status === 'error' ? 'LỖI' : item.progress + '%')"></span>
                                        </div>
                                        <div class="relative w-full bg-zinc-200 dark:bg-zinc-700 rounded-full h-1.5 overflow-hidden">
                                            <div class="bg-primary-500 h-full rounded-full transition-all duration-500 ease-out"
                                                :class="item.status === 'error' ? 'bg-red-500' : (item.status === 'completed' ? 'bg-green-500' : 'bg-primary-500')"
                                                :style="`width: ${item.progress}%`">
                                            </div>
                                        </div>
                                    </div>
                                </template>
                                <div class="mt-8 p-4 rounded-2xl bg-primary-50 dark:bg-primary-900/10 border border-primary-100 dark:border-primary-900/20">
                                    <p class="text-center text-primary-700 dark:text-primary-400 text-xs font-medium">Hệ thống đang lưu trữ và xử lý tri thức của bạn. Vui lòng giữ cửa sổ này mở.</p>
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
</x-prezet.template>
