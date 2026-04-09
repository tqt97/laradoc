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
        filesToUpload: [], 
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
            <div class="mt-8 w-full max-w-5xl mx-auto px-4">
                {{-- Search & Filter Section --}}
                <form action="{{ route('files.index') }}" method="GET" class="flex flex-col lg:flex-row gap-3 items-stretch bg-white dark:bg-zinc-900/50 p-3 rounded-2xl border border-zinc-200 dark:border-zinc-800 backdrop-blur-sm shadow-xl shadow-zinc-200/20 dark:shadow-none">
                    <div class="relative flex-grow group min-w-0">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Tên tài liệu, tác giả..."
                            class="w-full bg-zinc-50 dark:bg-zinc-950 border-zinc-100 dark:border-zinc-800 rounded-xl py-3 pl-10 pr-4 focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500/50 transition-all text-sm">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-zinc-400 group-focus-within:text-primary-500 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="w-full sm:w-36 relative">
                            <select name="sort" class="w-full bg-zinc-50 dark:bg-zinc-950 border-zinc-100 dark:border-zinc-800 rounded-xl py-3 px-4 focus:ring-2 focus:ring-primary-500/20 transition-all text-sm text-zinc-600 dark:text-zinc-400 appearance-none cursor-pointer">
                                <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Mới nhất</option>
                                <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Cũ nhất</option>
                            </select>
                            <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-zinc-400">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" /></svg>
                            </div>
                        </div>

                        <div class="w-full sm:w-44">
                            <input type="date" name="date" value="{{ request('date') }}"
                                class="w-full bg-zinc-50 dark:bg-zinc-950 border-zinc-100 dark:border-zinc-800 rounded-xl py-3 px-4 focus:ring-2 focus:ring-primary-500/20 transition-all text-sm text-zinc-500">
                        </div>

                        <div class="flex gap-2">
                            <button type="submit" class="flex-1 sm:flex-none bg-primary-500 hover:bg-primary-600 text-white font-bold py-3 px-8 rounded-xl transition-all active:scale-95 text-sm shadow-lg shadow-primary-500/20">
                                Lọc
                            </button>
                            @if(request()->anyFilled(['search', 'date', 'sort']))
                                <a href="{{ route('files.index') }}" class="bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 text-zinc-600 dark:text-zinc-400 font-bold py-3 px-4 rounded-xl transition-all text-sm flex items-center justify-center" title="Xóa lọc">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </form>

                {{-- Action Buttons --}}
                <div class="mt-8 flex flex-wrap gap-4 justify-center">
                    <button @click="uploadModal = true" class="inline-flex items-center gap-2.5 bg-primary-500 hover:bg-primary-600 text-white font-black py-4 px-10 rounded-[1.25rem] transition-all shadow-xl shadow-primary-500/25 hover:-translate-y-0.5 active:scale-95 uppercase tracking-widest text-[10px]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span>Đóng góp tri thức</span>
                    </button>

                    @if(Auth::check() && Auth::user()->hasAnyRole(['admin', 'super-admin']))
                        <a href="{{ route('files.review') }}" class="inline-flex items-center gap-2.5 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 text-zinc-700 dark:text-zinc-300 font-black py-4 px-10 rounded-[1.25rem] transition-all border border-zinc-200 dark:border-zinc-700 uppercase tracking-widest text-[10px]">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span>Duyệt bài chờ</span>
                        </a>
                    @endif
                </div>
            </div>
        </x-prezet.subpage-header>

        <div class="py-16 bg-white dark:bg-zinc-950">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                @if($files->isNotEmpty())
                    {{-- Grid 2 items per row --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-10 gap-y-8">
                        @foreach($files as $file)
                            @php 
                                $isProcessing = $file->status_upload !== \App\Enums\FileUploadStatus::READY; 
                                $isPending = $file->status_moderation === \App\Enums\FileModerationStatus::PENDING;
                                $isAdmin = Auth::check() && Auth::user()->hasAnyRole(['admin', 'super-admin']);
                                $icon = app(\App\Services\FileService::class)->getIconForMime($file->mime_type);
                            @endphp
                            <div class="group relative flex items-start p-6 bg-white dark:bg-zinc-900/30 rounded-[2rem] border border-zinc-100 dark:border-zinc-800/50 hover:border-primary-500/20 hover:bg-zinc-50 dark:hover:bg-zinc-900/50 transition-all duration-500">
                                {{-- Compact Icon --}}
                                <div class="shrink-0 w-12 h-12 rounded-2xl bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-400 group-hover:text-primary-500 group-hover:bg-primary-500/10 transition-all duration-500">
                                    @if($icon === 'book')
                                        <x-icons.book class="size-6" />
                                    @elseif($icon === 'markdown')
                                        <x-icons.markdown class="size-6" />
                                    @else
                                        <x-prezet.icon-file class="size-6" />
                                    @endif
                                </div>

                                {{-- Content --}}
                                <div class="ml-5 flex-grow min-w-0">
                                    <div class="flex items-center gap-2 mb-1.5">
                                        <span class="text-[9px] font-black uppercase tracking-widest text-primary-600 dark:text-primary-400 bg-primary-500/5 px-2 py-0.5 rounded-md">
                                            {{ strtoupper(explode('/', $file->mime_type)[1] ?? 'DOC') }}
                                        </span>
                                        <span class="text-[9px] text-zinc-400 font-bold uppercase tracking-tighter">{{ number_format($file->size / 1024, 0) }} KB</span>
                                        <span class="text-[9px] text-zinc-300 dark:text-zinc-700">•</span>
                                        <span class="text-[9px] text-zinc-400 font-medium">{{ $file->created_at->format('d/m/Y') }}</span>
                                    </div>

                                    @if($isProcessing || ($isPending && !$isAdmin))
                                        <h3 class="text-sm md:text-base font-bold text-zinc-400 dark:text-zinc-600 leading-relaxed">
                                            {{ $file->name }}
                                        </h3>
                                    @else
                                        <a href="{{ route('files.show', $file) }}" class="text-sm md:text-base font-bold text-zinc-900 dark:text-zinc-100 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors leading-relaxed block break-words">
                                            {{ $file->name }}
                                        </a>
                                    @endif
                                    
                                    <div class="mt-3 flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <div class="size-6 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-[10px] font-black text-zinc-500 border border-zinc-200 dark:border-zinc-700">
                                                {{ substr($file->uploader_name, 0, 1) }}
                                            </div>
                                            <div class="flex flex-col leading-none">
                                                <span class="text-[8px] text-zinc-400 uppercase font-black tracking-widest mb-0.5">Tác giả</span>
                                                <span class="text-[10px] font-bold text-zinc-600 dark:text-zinc-400 truncate max-w-[150px]">{{ $file->uploader_name }}</span>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center gap-1">
                                            <button @click="openShare({{ json_encode($file) }})" 
                                                class="p-2 rounded-xl text-zinc-400 hover:text-primary-500 hover:bg-primary-500/5 transition-all {{ ($isProcessing || $isPending) ? 'hidden' : 'active:scale-90' }}"
                                                title="Chia sẻ">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                                                </svg>
                                            </button>
                                            @if(!$isProcessing && (!$isPending || $isAdmin))
                                                <a href="{{ route('files.show', $file) }}" class="p-2 text-zinc-400 hover:text-primary-600 transition-colors active:scale-90" title="Xem chi tiết">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    @if($isPending)
                                        <div class="mt-3 inline-flex items-center px-2 py-0.5 rounded-md bg-amber-500/10 text-amber-600 text-[8px] font-black uppercase tracking-widest border border-amber-500/10">
                                            Chờ phê duyệt
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-16">
                        {{ $files->links() }}
                    </div>
                @else
                    <div class="py-32 text-center">
                        <div class="size-24 bg-zinc-50 dark:bg-zinc-900/50 rounded-[2.5rem] flex items-center justify-center mx-auto mb-8 text-zinc-300 dark:text-zinc-700 border border-zinc-100 dark:border-zinc-800 shadow-inner">
                            <x-icons.book class="size-12" />
                        </div>
                        <h3 class="text-2xl font-bold text-zinc-900 dark:text-white mb-3">Chưa tìm thấy tri thức nào</h3>
                        <p class="text-zinc-500 dark:text-zinc-400 text-sm max-w-sm mx-auto mb-12">Hệ thống không tìm thấy kết quả phù hợp. Thử thay đổi từ khóa hoặc bộ lọc của bạn.</p>
                        <button @click="uploadModal = true" class="bg-zinc-900 dark:bg-zinc-100 text-white dark:text-zinc-900 font-black py-4 px-10 rounded-2xl transition-all hover:scale-105 active:scale-95 uppercase tracking-widest text-[10px]">Đóng góp tài liệu mới</button>
                    </div>
                @endif
            </div>
        </div>

        {{-- Modals --}}
        <template x-teleport="body">
            {{-- Upload Modal --}}
            <div x-show="uploadModal" class="fixed inset-0 z-[100] overflow-y-auto" x-cloak>
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div x-show="uploadModal" x-transition.opacity @click="if(!isUploading) uploadModal = false" class="fixed inset-0 bg-zinc-950/90 backdrop-blur-md"></div>
                    <div x-show="uploadModal" x-transition.scale.origin.bottom class="relative bg-white dark:bg-zinc-900 rounded-[3rem] w-full max-w-xl p-12 shadow-2xl border border-zinc-100 dark:border-zinc-800">
                        <div class="flex items-center justify-between mb-10">
                            <div>
                                <h3 class="text-3xl font-black text-zinc-900 dark:text-white tracking-tight">Đóng góp tri thức</h3>
                                <p class="text-xs text-zinc-500 font-medium mt-1">Chia sẻ tài liệu của bạn với cộng đồng.</p>
                            </div>
                            <button @click="uploadModal = false" x-show="!isUploading" class="p-3 bg-zinc-50 dark:bg-zinc-800 rounded-2xl text-zinc-400 hover:text-zinc-600 transition-colors"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg></button>
                        </div>

                        <div x-show="!isUploading">
                            <form @submit.prevent="uploadFiles()" class="space-y-8">
                                @csrf
                                @guest
                                <div>
                                    <x-form.label value="Danh tính người đóng góp" required="true" class="text-[10px] uppercase font-black tracking-widest text-zinc-400 mb-3" />
                                    <x-form.input x-model="uploaderName" placeholder="Tên hiển thị của bạn" required class="!rounded-2xl !bg-zinc-50 dark:!bg-zinc-950 !border-none !py-4 !px-6" />
                                </div>
                                @endguest

                                <div>
                                    <x-form.label value="Tải lên tài liệu" required="true" class="text-[10px] uppercase font-black tracking-widest text-zinc-400 mb-3" />
                                    <div class="mt-2 flex justify-center px-6 py-16 border-2 border-zinc-100 dark:border-zinc-800 border-dashed rounded-[2.5rem] hover:border-primary-500/50 transition-all bg-zinc-50/50 dark:bg-zinc-950/30 cursor-pointer relative group">
                                        <div class="text-center">
                                            <div class="mb-6 flex justify-center text-zinc-300 group-hover:text-primary-500 transition-all duration-700 group-hover:scale-110">
                                                <x-icons.book class="size-20" />
                                            </div>
                                            <label for="file-upload" class="cursor-pointer font-black text-primary-600 hover:text-primary-500 text-sm">
                                                <span x-text="filesToUpload.length > 0 ? 'Đã chọn ' + filesToUpload.length + ' tệp' : 'Chọn tệp từ máy tính'"></span>
                                                <input id="file-upload" name="file[]" type="file" class="sr-only" required accept=".txt,.md,.pdf" multiple @change="handleFileSelect($event)">
                                            </label>
                                            <p class="mt-3 text-[9px] text-zinc-400 uppercase tracking-widest font-black">PDF, Markdown hoặc Text (Max 30MB)</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-4 flex gap-4">
                                    <button type="button" @click="uploadModal = false" class="flex-1 py-5 rounded-[1.5rem] bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 font-black text-xs uppercase tracking-widest transition-all hover:bg-zinc-200">Hủy bỏ</button>
                                    <button class="flex-1 py-5 rounded-[1.5rem] bg-primary-500 text-white font-black text-xs uppercase tracking-widest shadow-xl shadow-primary-500/25 transition-all hover:bg-primary-600 hover:-translate-y-0.5">Bắt đầu tải lên</button>
                                </div>
                            </form>
                        </div>

                        <div x-show="isUploading" class="space-y-5 max-h-[450px] overflow-y-auto px-1 custom-scrollbar">
                            <template x-for="(item, index) in filesToUpload" :key="index">
                                <div class="p-6 rounded-[2rem] bg-zinc-50 dark:bg-zinc-950 border border-zinc-100 dark:border-zinc-800">
                                    <div class="flex justify-between items-center mb-4">
                                        <div class="flex items-center gap-3">
                                            <div class="p-2 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-100 dark:border-zinc-800"><x-icons.book class="size-4 text-zinc-400" /></div>
                                            <span class="text-sm font-bold text-zinc-900 dark:text-white truncate max-w-[250px]" x-text="item.name"></span>
                                        </div>
                                        <span class="text-[10px] font-black text-primary-500" x-text="item.status === 'completed' ? 'HOÀN TẤT' : item.progress + '%'"></span>
                                    </div>
                                    <div class="h-2 w-full bg-zinc-200 dark:bg-zinc-800 rounded-full overflow-hidden shadow-inner">
                                        <div class="h-full bg-primary-500 transition-all duration-700 ease-out shadow-lg" :style="`width: ${item.progress}%`"></div>
                                    </div>
                                </div>
                            </template>
                            <div class="mt-10 p-5 rounded-2xl bg-primary-50/50 dark:bg-primary-950/20 border border-primary-100 dark:border-primary-900/30">
                                <p class="text-center text-primary-700 dark:text-primary-400 text-[10px] font-bold uppercase tracking-widest animate-pulse">Đang xử lý tri thức của bạn. Vui lòng không đóng cửa sổ này.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Share Modal --}}
            <div x-show="shareModal" class="fixed inset-0 z-[100] overflow-y-auto" x-cloak>
                <div class="flex items-center justify-center min-h-screen p-4">
                    <div x-show="shareModal" x-transition.opacity @click="shareModal = false" class="fixed inset-0 bg-zinc-950/90 backdrop-blur-md"></div>
                    <div x-show="shareModal" x-transition.scale.origin.bottom class="relative bg-white dark:bg-zinc-900 rounded-[3rem] w-full max-w-lg p-12 shadow-2xl border border-zinc-100 dark:border-zinc-800">
                        <div class="flex items-center justify-between mb-10">
                            <div>
                                <h3 class="text-3xl font-black text-zinc-900 dark:text-white tracking-tight">Chia sẻ tri thức</h3>
                                <p class="text-xs text-zinc-500 font-medium mt-1">Lan tỏa kiến thức đến cộng đồng.</p>
                            </div>
                            <button @click="shareModal = false" class="p-3 bg-zinc-50 dark:bg-zinc-800 rounded-2xl text-zinc-400 hover:text-zinc-600 transition-colors"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg></button>
                        </div>

                        <div class="space-y-8">
                            <div class="flex items-center justify-between p-8 rounded-[2rem] bg-zinc-50 dark:bg-zinc-950 border border-zinc-100 dark:border-zinc-800">
                                <div>
                                    <h4 class="font-bold text-base text-zinc-900 dark:text-white">Công khai</h4>
                                    <p class="text-[10px] text-zinc-500 mt-1 uppercase font-black tracking-widest">Ai có link đều có thể truy cập</p>
                                </div>
                                <button @click="sharePublic = !sharePublic" :class="sharePublic ? 'bg-primary-500' : 'bg-zinc-300 dark:bg-zinc-800'" class="relative inline-flex h-8 w-14 rounded-full transition-colors duration-500 border-2 border-transparent">
                                    <span :class="sharePublic ? 'translate-x-6' : 'translate-x-0'" class="inline-block h-7 w-7 transform rounded-full bg-white transition duration-500 shadow-lg"></span>
                                </button>
                            </div>

                            <div x-show="sharePublic" class="space-y-6" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                                <div>
                                    <x-form.label value="Link truy cập tài liệu" class="text-[10px] uppercase font-black tracking-widest text-zinc-400 mb-3" />
                                    <div class="flex gap-3">
                                        <input type="text" x-model="shareUrl" readonly class="flex-grow bg-zinc-50 dark:bg-zinc-950 border-none rounded-2xl py-4 px-6 text-xs font-bold text-zinc-500 shadow-inner">
                                        <button @click="copyShareUrl" class="p-4 bg-primary-500 text-white rounded-2xl shadow-xl shadow-primary-500/25 active:scale-90 transition-all hover:bg-primary-600">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184" /></svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pt-12 flex gap-4">
                            <button @click="shareModal = false" class="flex-1 py-5 rounded-[1.5rem] bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 font-black text-xs uppercase tracking-widest transition-all hover:bg-zinc-200">Đóng</button>
                            <button @click="saveShare" class="flex-1 py-5 rounded-[1.5rem] bg-primary-500 text-white font-black text-xs uppercase tracking-widest shadow-xl shadow-primary-500/25 transition-all hover:bg-primary-600 hover:-translate-y-0.5">Lưu cài đặt</button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</x-prezet.template>
