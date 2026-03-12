<x-prezet.template>
    @seo($seo)

    <div class="py-12 lg:py-20" x-data="{
        activeCategory: 'all',
        showModal: false,
        modalImage: '',
        modalTitle: '',
        modalLink: '',
        openModal(url, title, link) {
            this.modalImage = url;
            this.modalTitle = title;
            this.modalLink = link;
            this.showModal = true;
            document.body.style.overflow = 'hidden';
        },
        closeModal() {
            this.showModal = false;
            document.body.style.overflow = 'auto';
        }
    }">
        {{-- Header Section --}}
        <div class="mb-16 text-center">
            <h1 class="mb-4 text-5xl font-black tracking-tight text-zinc-900 dark:text-white lg:text-7xl">
                Visual <span class="text-primary-500">Gallery</span>
            </h1>
            <p class="mx-auto max-w-2xl text-lg text-zinc-500 dark:text-zinc-400">
                Khám phá kho lưu trữ hình ảnh qua các bài viết và dự án kỹ thuật.
            </p>
        </div>

        {{-- Filter Section --}}
        <div class="mb-12 flex flex-wrap items-center justify-center gap-3">
            <button @click="activeCategory = 'all'"
                :class="activeCategory === 'all' ? 'bg-primary-500 text-white' :
                    'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-200 dark:hover:bg-zinc-700'"
                class="rounded-full px-6 py-2 text-sm font-bold transition-all duration-300">
                Tất cả
            </button>
            @foreach ($categories->keys() as $category)
                <button @click="activeCategory = '{{ $category }}'"
                    :class="activeCategory === '{{ $category }}' ? 'bg-primary-500 text-white' :
                        'bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400 hover:bg-zinc-200 dark:hover:bg-zinc-700'"
                    class="rounded-full px-6 py-2 text-sm font-bold transition-all duration-300">
                    {{ $category }}
                </button>
            @endforeach
        </div>

        {{-- Gallery Grid --}}
        <div class="grid grid-cols-1 gap-16 lg:grid-cols-2">
            @foreach ($categories as $categoryName => $images)
                @foreach ($images as $image)
                    <div x-show="activeCategory === 'all' || activeCategory === '{{ $categoryName }}'"
                        x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0 scale-95 translate-y-8"
                        x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                        class="group relative aspect-[1.91/1] overflow-hidden rounded-[2.5rem] bg-zinc-900 shadow-2xl transition-all duration-700 hover:-translate-y-4 hover:shadow-primary-500/20">
                        
                        {{-- Image with blur effect on hover --}}
                        <img src="{{ $image->url }}" alt="{{ $image->title }}"
                            class="h-full w-full object-cover transition-all duration-1000 group-hover:scale-110 group-hover:blur-md group-hover:opacity-40"
                            loading="lazy">

                        {{-- Improved Overlay with top-to-bottom layout --}}
                        <div
                            class="absolute inset-0 bg-zinc-950/80 opacity-0 backdrop-blur-md transition-all duration-500 group-hover:opacity-100 flex flex-col justify-between p-10">
                            
                            {{-- Top Content --}}
                            <div class="-translate-y-4 transition-transform duration-700 group-hover:translate-y-0">
                                <span
                                    class="mb-3 inline-flex items-center rounded-full bg-primary-500 px-3 py-1 text-[10px] font-black uppercase tracking-[0.2em] text-white shadow-lg shadow-primary-500/40">
                                    {{ $image->category }}
                                </span>
                                <h3 class="text-2xl font-black text-white leading-tight drop-shadow-2xl line-clamp-3">
                                    {{ $image->title }}
                                </h3>
                            </div>

                            {{-- Bottom Content --}}
                            <div class="translate-y-4 transition-transform duration-700 group-hover:translate-y-0">
                                <div class="flex items-center gap-4">
                                    <button
                                        @click="openModal('{{ $image->url }}', '{{ $image->title }}', '{{ $image->link }}')"
                                        class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/20 text-white backdrop-blur-2xl transition-all hover:bg-white/30 active:scale-90 ring-1 ring-white/30 shadow-2xl">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607zM10.5 7.5v6m3-3h-6" />
                                        </svg>
                                    </button>
                                    <a href="{{ $image->link }}"
                                        class="flex h-12 flex-1 items-center justify-center gap-2 rounded-2xl bg-white text-xs font-black uppercase tracking-widest text-zinc-900 transition-all hover:bg-primary-500 hover:text-white active:scale-95 shadow-2xl">
                                        Xem bài viết
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>

        {{-- Lightbox Modal --}}
        <div x-show="showModal" x-cloak x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-[100] flex items-center justify-center p-4 lg:p-12"
            @keydown.escape.window="closeModal()">
            {{-- Backdrop --}}
            <div class="absolute inset-0 bg-zinc-950/95 backdrop-blur-xl" @click="closeModal()"></div>

            {{-- Modal Content --}}
            <div x-show="showModal" x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 scale-90 translate-y-12"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                class="relative max-w-6xl w-full overflow-hidden rounded-[2rem] bg-zinc-900 shadow-2xl ring-1 ring-white/10">
                <button @click="closeModal()"
                    class="absolute right-6 top-6 z-10 flex h-12 w-12 items-center justify-center rounded-full bg-black/50 text-white backdrop-blur-md transition-all hover:bg-black/80">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="flex flex-col lg:flex-row">
                    <div class="lg:w-3/4 bg-black flex items-center justify-center">
                        <img :src="modalImage" :alt="modalTitle" class="max-h-[80vh] w-full object-contain">
                    </div>
                    <div class="lg:w-1/4 p-8 flex flex-col justify-between bg-zinc-900 border-l border-white/5">
                        <div>
                            <h2 class="text-2xl font-black text-white mb-4" x-text="modalTitle"></h2>
                            <div class="h-1 w-12 bg-primary-500 rounded-full mb-6"></div>
                        </div>
                        <a :href="modalLink"
                            class="inline-flex items-center justify-center gap-2 rounded-2xl bg-primary-500 px-6 py-4 text-sm font-black uppercase tracking-widest text-white transition-all hover:bg-primary-600 active:scale-95 shadow-xl shadow-primary-500/20">
                            Đến bài viết
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</x-prezet.template>
