<x-prezet.template>
    @seo($seo)

    <div class="min-h-screen bg-white text-zinc-900" x-data="{ 
        viewMode: 'collections',
        activeTab: 'all',
        showModal: false,
        modalImg: '',
        modalTitle: '',
        currentIndex: 0,
        currentImages: [],
        zoom: false,

        openModal(url, title, images, index) {
            this.modalImg = url;
            this.modalTitle = title;
            this.currentImages = images;
            this.currentIndex = index;
            this.showModal = true;
            this.zoom = false;
            document.body.style.overflow = 'hidden';
        },
        closeModal() {
            this.showModal = false;
            document.body.style.overflow = 'auto';
        },
        nextImage() {
            this.currentIndex = (this.currentIndex + 1) % this.currentImages.length;
            this.modalImg = this.currentImages[this.currentIndex].url;
            this.modalTitle = this.currentImages[this.currentIndex].title;
            this.zoom = false;
        },
        prevImage() {
            this.currentIndex = (this.currentIndex - 1 + this.currentImages.length) % this.currentImages.length;
            this.modalImg = this.currentImages[this.currentIndex].url;
            this.modalTitle = this.currentImages[this.currentIndex].title;
            this.zoom = false;
        }
    }" @keydown.right.window="if(showModal) nextImage()" @keydown.left.window="if(showModal) prevImage()" @keydown.escape.window="closeModal()">
        
        <div class="relative overflow-hidden border-b border-pink-50 py-20 text-center">
            <h1 class="mb-8 bg-gradient-to-br from-zinc-900 via-pink-600 to-zinc-800 bg-clip-text text-6xl font-black tracking-tighter text-transparent lg:text-8xl">
                Tầm nhìn Nghệ thuật
            </h1>
        <div class="mx-auto max-w-7xl px-4 py-20">
            {{-- COLLECTIONS MODE --}}
            <div x-show="viewMode === 'collections'" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 translate-y-12">
                <div class="space-y-32">
                    @foreach($collections as $category => $data)
                        <section class="group">
                            <div class="mb-12 flex flex-col items-end justify-between gap-8 lg:flex-row">
                                <div class="max-w-xl">
                                    <span class="mb-4 block text-[10px] font-black uppercase tracking-[0.4em] text-pink-500">{{ $category }}</span>
                                    <h2 class="mb-4 text-5xl font-black tracking-tighter">Bộ sưu tập {{ $category }}</h2>
                                    <p class="text-lg font-medium italic text-zinc-500">{{ $data['desc'] }}</p>
                                </div>
                                <button @click="viewMode = 'single'; activeTab = '{{ $category }}'" class="group/btn inline-flex items-center gap-3 rounded-2xl bg-zinc-900 px-8 py-4 text-xs font-black uppercase tracking-widest text-white transition-all hover:bg-pink-500 hover:shadow-2xl hover:shadow-pink-500/40">
                                    Xem toàn bộ
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="size-4 transition-transform group-hover/btn:translate-x-1">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                    </svg>
                                </button>
                            </div>

                            <div class="grid h-[600px] grid-cols-1 gap-8 md:grid-cols-12">
                                <div class="relative col-span-1 overflow-hidden rounded-[3rem] shadow-2xl transition-all duration-700 md:col-span-8 group/img art-corners glow-border" 
                                     @click="openModal('{{ $data['images'][0]['url'] }}', '{{ $data['images'][0]['title'] }}', {{ json_encode($data['images']) }}, 0)">
                                    <img src="{{ $data['images'][0]['url'] }}" class="h-full w-full object-cover transition-transform duration-1000 group-hover/img:scale-110">
                                    <div class="absolute inset-0 bg-pink-900/20 opacity-0 transition-opacity group-hover/img:opacity-100"></div>
                                    <div class="absolute bottom-10 left-10 translate-y-4 opacity-0 transition-all duration-500 group-hover/img:translate-y-0 group-hover/img:opacity-100 pointer-events-none">
                                        <h3 class="text-3xl font-black text-white tracking-tighter">{{ $data['images'][0]['title'] }}</h3>
                                    </div>
                                </div>
                                <div class="col-span-1 grid grid-rows-2 gap-8 md:col-span-4">
                                    @foreach(array_slice($data['images'], 1, 2) as $idx => $img)
                                        <div class="relative overflow-hidden rounded-[2.5rem] shadow-xl transition-all duration-700 group/sub art-corners glow-border" 
                                             @click="openModal('{{ $img['url'] }}', '{{ $img['title'] }}', {{ json_encode($data['images']) }}, {{ $idx + 1 }})">
                                            <img src="{{ $img['url'] }}" class="h-full w-full object-cover transition-transform duration-1000 group-hover/sub:scale-110">
                                            <div class="absolute inset-0 bg-pink-900/20 opacity-0 transition-opacity group-hover/sub:opacity-100"></div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </section>
                    @endforeach
                </div>
            </div>

            {{-- SINGLE PHOTOS MODE (BENTO) --}}
            <div x-show="viewMode === 'single'" x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 scale-95">
                <div class="grid grid-cols-1 gap-8 md:grid-cols-4 auto-rows-[350px]">
                    @foreach($collections as $category => $data)
                        @foreach($data['images'] as $idx => $img)
                            <div 
                                x-show="activeTab === 'all' || activeTab === '{{ $category }}'"
                                x-transition:enter="transition ease-out duration-500"
                                x-transition:enter-start="opacity-0 scale-90 translate-y-8"
                                class="{{ $img['size'] }} group relative cursor-pointer overflow-hidden rounded-[2.5rem] bg-pink-50 shadow-sm transition-all duration-700 hover:-translate-y-2 hover:shadow-2xl hover:shadow-pink-500/20 art-corners glow-border"
                                @click="openModal('{{ $img['url'] }}', '{{ $img['title'] }}', {{ json_encode($data['images']) }}, {{ $idx }})"
                            >
                                <img src="{{ $img['url'] }}" class="h-full w-full object-cover transition-all duration-1000 group-hover:scale-110 group-hover:opacity-60 group-hover:blur-sm">
                                
                                <div class="absolute inset-0 flex flex-col justify-end bg-gradient-to-t from-pink-950 via-pink-950/20 to-transparent p-10 opacity-0 transition-all duration-500 group-hover:opacity-100">
                                    <span class="mb-3 text-[10px] font-black uppercase tracking-[0.3em] text-pink-400">{{ $category }}</span>
                                    <h3 class="text-2xl font-black leading-tight text-white">{{ $img['title'] }}</h3>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Sophisticated Modal --}}
        <div x-show="showModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 lg:p-12">
            <div class="absolute inset-0 bg-white/95 backdrop-blur-2xl" @click="closeModal()"></div>
            
            <div x-show="showModal" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 scale-90" class="relative flex h-full max-w-6xl w-full flex-col overflow-hidden rounded-[3.5rem] border border-pink-100 bg-pink-50 shadow-2xl">
                
                {{-- Modal Header --}}
                <div class="absolute top-0 left-0 right-0 z-20 flex items-center justify-between p-8 pointer-events-none">
                    <div class="rounded-full bg-white/80 px-6 py-2 backdrop-blur-md shadow-lg pointer-events-auto">
                        <span class="text-xs font-black uppercase tracking-widest text-zinc-900" x-text="`${currentIndex + 1} / ${currentImages.length}`"></span>
                    </div>
                    <button @click="closeModal()" class="pointer-events-auto flex h-14 w-14 items-center justify-center rounded-full bg-white/80 text-zinc-900 shadow-xl transition-all hover:bg-white backdrop-blur-md">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Image Container --}}
                <div class="relative flex-1 overflow-hidden bg-black flex items-center justify-center group/modal">
                    <img :src="modalImg" :class="zoom ? 'scale-150 cursor-zoom-out' : 'scale-100 cursor-zoom-in'" 
                         @click="zoom = !zoom"
                         class="max-h-full max-w-full object-contain transition-transform duration-500 ease-in-out">
                    
                    {{-- Navigation Buttons --}}
                    <button @click="prevImage()" class="absolute left-8 top-1/2 -translate-y-1/2 flex h-16 w-16 items-center justify-center rounded-full bg-white/20 text-white backdrop-blur-sm transition-all hover:bg-white/40 opacity-0 group-hover/modal:opacity-100 transition-opacity">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="size-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </button>
                    <button @click="nextImage()" class="absolute right-8 top-1/2 -translate-y-1/2 flex h-16 w-16 items-center justify-center rounded-full bg-white/20 text-white backdrop-blur-sm transition-all hover:bg-white/40 opacity-0 group-hover/modal:opacity-100 transition-opacity">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="size-8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                </div>

                {{-- Modal Footer --}}
                <div class="bg-gradient-to-t from-white via-white/95 to-white/80 p-12 text-center backdrop-blur-md">
                    <h2 class="text-4xl font-black tracking-tighter text-zinc-900" x-text="modalTitle"></h2>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }

        {{-- Glowing Border Effect --}}
        .glow-border {
            position: relative;
        }
        .glow-border::before {
            content: '';
            position: absolute;
            inset: -2px;
            background: linear-gradient(90deg, transparent, #ec4899, transparent);
            background-size: 200% 100%;
            z-index: -1;
            opacity: 0;
            transition: opacity 0.5s;
            animation: border-flow 3s linear infinite;
        }
        .group:hover.glow-border::before {
            opacity: 1;
        }

        @keyframes border-flow {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }

        {{-- Artistic Staggered Corners --}}
        .art-corners::after {
            content: '';
            position: absolute;
            inset: 20px;
            border: 2px solid rgba(236, 72, 153, 0.3);
            pointer-events: none;
            z-index: 10;
            transition: all 0.7s cubic-bezier(0.4, 0, 0.2, 1);
            clip-path: polygon(
                0 0, 30px 0, 30px 2px, 2px 2px, 2px 30px, 0 30px,
                calc(100% - 30px) 0, 100% 0, 100% 30px, calc(100% - 2px) 30px, calc(100% - 2px) 2px, calc(100% - 30px) 2px,
                0 calc(100% - 30px), 0 100%, 30px 100%, 30px calc(100% - 2px), 2px calc(100% - 2px), 2px calc(100% - 30px),
                100% calc(100% - 30px), 100% 100%, calc(100% - 30px) 100%, calc(100% - 30px) calc(100% - 2px), calc(100% - 2px) calc(100% - 2px), calc(100% - 2px) calc(100% - 30px)
            );
        }

        .group:hover.art-corners::after {
            inset: 10px;
            border-color: rgba(236, 72, 153, 1);
            transform: scale(1.05);
        }
    </style>
</x-prezet.template>