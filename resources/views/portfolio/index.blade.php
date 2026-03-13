<x-prezet.template>
    @seo($seo)

    {{-- Full Width Hero Section --}}
    <x-slot:fullWidthTop>
        <section class="relative h-[100dvh] w-full overflow-hidden flex items-center justify-center bg-zinc-900">
            <div class="absolute inset-0 z-0">
                <img src="{{ $hero['image'] }}" class="h-full w-full object-cover animate-ken-burns" alt="Hero Image">
                <div class="absolute inset-0 bg-black/30 bg-gradient-to-b from-transparent via-transparent to-white">
                </div>
            </div>

            <div class="relative z-10 text-center px-6 max-w-7xl mx-auto animate-fade-up">
                <div
                    class="inline-flex items-center gap-3 mb-6 md:mb-8 px-5 md:px-6 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white/90 text-[9px] md:text-[10px] font-black uppercase tracking-[0.5em]">
                    <span class="w-1.5 h-1.5 md:w-2 md:h-2 bg-pink-500 rounded-full animate-pulse"></span>
                    Portfolio Nghệ thuật
                </div>

                @php
                    $titleParts = explode(' ', $hero['title'], 2);
                @endphp

                <h1
                    class="text-5xl text-white sm:text-7xl md:text-8xl lg:text-[10rem] font-black tracking-tighter uppercase leading-[0.85] md:leading-[0.85]   mb-8">
                    {{ $titleParts[0] }} <br class="sm:hidden">
                    <span class="text-transparent font-light italic lowercase" style="-webkit-text-stroke: 1px white;">
                        {{ $titleParts[1] ?? '' }}
                    </span>
                </h1>

                <p
                    class="text-center text-white/90 text-lg md:text-2xl lg:text-3xl font-light italic tracking-wide max-w-2xl mx-auto mb-10 md:mb-14">
                    {{ $hero['subtitle'] }}
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-6">
                    <button @click="document.getElementById('about').scrollIntoView({ behavior: 'smooth' })"
                        class="group/btn w-full sm:w-auto inline-flex items-center justify-center gap-3 md:gap-4 px-8 md:px-10   │
│    py-3 md:py-4 rounded-full bg-white text-[#222222] text-[10px] md:text-xs font-black uppercase tracking-widest transition-all   │
│    hover:bg-pink-500 hover:text-white hover:scale-105 shadow-[0_20px_50px_rgba(0,0,0,0.3)] hover:cursor-pointer">
                        Khám phá ngay
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                            stroke="currentColor"
                            class="size-4 md:size-5 transition-transform group-hover/btn:translate-y-1">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 13.5L12 21m0 0l-7.5-7.5M12 21V3" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Scroll Indicator --}}
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-10 opacity-30 hidden md:block">
                <div class="w-[1px] h-16 bg-gradient-to-b from-white to-transparent"></div>
            </div>
        </section>
    </x-slot:fullWidthTop>

    <div class="bg-white" x-data="{
        showModal: false,
        modalImg: '',
        modalTitle: '',
        currentIndex: 0,
        currentImages: [],
        zoom: false,
        activeCollection: '{{ array_key_first($collections) }}',

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
    }" @keydown.right.window="if(showModal) nextImage()"
        @keydown.left.window="if(showModal) prevImage()" @keydown.escape.window="closeModal()">

        {{-- 1. Discovery Phase: The Persona --}}
        <section id="about" class="py-24 md:py-32 grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-32 items-center">
            <div class="relative group cursor-pointer hover:cursor-pointer">
                <div
                    class="absolute -inset-2 md:-inset-4 border border-[#EAD1D5] rounded-[12px] -z-10 group-hover:rotate-6 group-hover:scale-105 transition-all duration-700">
                </div>
                <div
                    class="absolute -inset-4 md:-inset-8 border border-pink-500/20 rounded-[12px] -z-20 opacity-0 group-hover:opacity-100 group-hover:-rotate-3 transition-all duration-1000">
                </div>
                <div class="overflow-hidden rounded-[4px] relative bg-zinc-100">
                    <img src="{{ $about['portrait'] }}" alt="{{ $about['name'] }}"
                        class="w-full h-[400px] md:h-[600px] object-cover grayscale transition-all duration-1000 group-hover:grayscale-0 group-hover:scale-110">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-pink-500/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-700">
                    </div>
                </div>
            </div>

            <div class="space-y-6 md:space-y-8 animate-fade-right">
                <div class="space-y-2">
                    <span class="text-pink-500 text-xs font-black uppercase tracking-[0.5em] block">Hồ sơ cá
                        nhân</span>
                    <h2 class="text-4xl md:text-6xl font-black tracking-tighter text-[#222222]">Chào bạn, tôi là <span
                            class="text-pink-500">{{ $about['name'] }}</span></h2>
                </div>

                <p class="text-[#777777] text-lg md:text-xl font-light leading-relaxed italic">"{{ $about['bio'] }}"</p>

                <div class="pt-4 md:pt-6 flex items-center gap-8 md:gap-12">
                    <div class="space-y-1">
                        <span class="text-4xl font-black text-pink-500 tracking-tighter">5+</span>
                        <p class="text-[10px] font-black uppercase tracking-widest text-[#777777]">Năm kinh nghiệm</p>
                    </div>
                    <div class="space-y-1">
                        <span class="text-4xl font-black text-pink-500 tracking-tighter">200+</span>
                        <p class="text-[10px] font-black uppercase tracking-widest text-[#777777]">Dự án hoàn thành</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- 2. Proof of Excellence: Highlights --}}
        <section id="featured" class="py-24 md:py-32">
            <div class="mb-12 md:mb-20 text-center space-y-4">
                <div class="space-y-2">
                    <span class="text-pink-500 text-xs font-black uppercase tracking-[0.5em] block">Tác phẩm nổi
                        bật</span>
                    <h2 class="text-4xl md:text-6xl font-black tracking-tighter text-[#222222]">Khoảnh khắc <span
                            class="text-pink-500">Tuyển chọn</span></h2>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:h-[550px]">
                @foreach ($featured as $index => $img)
                    <div class="relative overflow-hidden rounded-[4px] group/featured h-[400px] md:h-full cursor-pointer hover:cursor-pointer camera-focus-hover"
                        @click="openModal('{{ $img['url'] }}', '{{ $img['title'] }}', {{ json_encode($featured) }}, {{ $index }})">
                        <img src="{{ $img['url'] }}"
                            class="h-full w-full object-cover transition-transform duration-500 ease-out group-hover/featured:scale-105 group-hover/featured:brightness-110">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover/featured:opacity-100 transition-all duration-500 ease-out">
                        </div>
                        <div
                            class="absolute bottom-8 left-8 translate-y-6 opacity-0 transition-all duration-500 ease-out group-hover/featured:translate-y-0 group-hover/featured:opacity-100">
                            <span
                                class="text-[#EAD1D5] text-[10px] font-black uppercase tracking-widest block mb-1">{{ $img['category'] }}</span>
                            <h3 class="text-white text-3xl font-black tracking-tight">{{ $img['title'] }}</h3>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- 3. The Depth: Stories & Meaning --}}
        <section id="stories" class="py-24 md:py-32">
            <div class="space-y-2">
                <span class="text-pink-500 text-xs font-black uppercase tracking-[0.5em] block">Kể chuyện qua
                    ảnh</span>
                <h2 class="text-4xl md:text-6xl font-black tracking-tighter text-[#222222]">Những <span
                        class="text-pink-500">Câu chuyện</span> ngắn</h2>
            </div>
            <p
                class="mt-4 text-[#777777] text-base md:text-lg font-light leading-relaxed italic border-l-2 border-pink-500 pl-6">
                Mỗi tác phẩm là một chương trong hành trình cảm xúc, nơi ánh sáng và bóng tối đan xen để kể lại những
                khoảnh khắc đời thường nhất.</p>

            <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 md:gap-8">
                @foreach ($stories as $story)
                    <div
                        class="story-card-container h-[400px] md:h-[450px] group cursor-pointer hover:cursor-pointer perspective-1000">
                        <div
                            class="story-card-inner relative w-full h-full transition-transform duration-[1000ms] ease-in-out transform-style-3d group-hover:rotate-y-180">
                            {{-- Front Side --}}
                            <div
                                class="story-card-front absolute inset-0 w-full h-full backface-hidden overflow-hidden rounded-[8px] shadow-lg camera-focus-hover">
                                <img src="{{ $story['url'] }}" alt="{{ $story['title'] }}"
                                    class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition-all duration-700">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                                </div>
                                <div class="absolute bottom-6 left-6 right-6">
                                    <h3 class="text-white text-xl font-black tracking-tight uppercase">
                                        {{ $story['title'] }}</h3>
                                    <div
                                        class="w-10 h-0.5 bg-pink-500 mt-2 group-hover:w-full transition-all duration-700">
                                    </div>
                                </div>
                            </div>

                            {{-- Back Side --}}
                            <div
                                class="story-card-back absolute inset-0 w-full h-full backface-hidden rotate-y-180 bg-[#EAD1D5] p-8 flex flex-col justify-center items-center text-center rounded-[8px] shadow-xl border-l-4 border-pink-500">
                                <div class="space-y-4">
                                    <span
                                        class="w-12 h-12 flex items-center justify-center rounded-full bg-pink-500/20 text-pink-500 mx-auto">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                                        </svg>
                                    </span>
                                    <h3 class="text-[#222222] text-2xl font-black tracking-tight uppercase">
                                        {{ $story['title'] }}</h3>
                                    <p class="text-[#222222]/70 text-sm font-light leading-relaxed italic">
                                        "{{ $story['desc'] }}"</p>
                                    <div class="pt-4">
                                        <button
                                            @click.stop="openModal('{{ $story['images'][0]['url'] }}', '{{ $story['images'][0]['title'] }}', {{ json_encode($story['images']) }}, 0)"
                                            class="px-6 py-2 bg-[#222222] text-white text-[10px] font-black uppercase tracking-widest rounded-full hover:bg-pink-500 transition-colors hover:cursor-pointer">
                                            View Story
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- 4. Deep Exploration: Full Collections --}}
        <section id="collections" class="py-24 md:py-32" x-data="{ showPicker: false }">
            <div class="space-y-8 md:space-y-12">
                <div class="mb-12 md:mb-20 text-center space-y-4">
                    <div class="space-y-2">
                        <span class="text-pink-500 text-xs font-black uppercase tracking-[0.5em] block">Danh mục tác
                            phẩm</span>
                        <h2 class="text-4xl md:text-6xl font-black tracking-tighter text-[#222222]">Bộ sưu tập <span
                                class="text-pink-500">Nghệ thuật</span></h2>
                    </div>
                </div>

                <div
                    class="sticky top-0 z-40 bg-white/80 backdrop-blur-md py-4 md:py-6 -mx-4 px-4 border-b border-[#EAD1D5]/30">
                    <div class="max-w-7xl mx-auto flex items-center gap-3 md:gap-4">
                        <button @click="showPicker = !showPicker"
                            class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 flex items-center justify-center rounded-full bg-[#222222] text-white hover:bg-pink-500 transition-colors hover:cursor-pointer shadow-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor" class="size-4 md:size-5"
                                :class="showPicker ? 'rotate-45' : ''">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </button>

                        <div class="relative flex-1 overflow-hidden">
                            <div class="flex gap-2 overflow-x-auto scrollbar-hide pb-1 md:pb-2 mask-fade-edges">
                                @foreach ($collections as $category => $data)
                                    <button @click="activeCollection = '{{ $category }}'; showPicker = false"
                                        :class="activeCollection === '{{ $category }}' ?
                                            'bg-pink-500 text-white shadow-md' :
                                            'bg-zinc-100 text-[#777777] hover:bg-zinc-200'"
                                        class="flex-shrink-0 px-4 md:px-6 py-2 md:py-2.5 rounded-full text-[9px] md:text-[10px] font-black uppercase tracking-widest transition-all duration-500 hover:cursor-pointer">
                                        {{ $data['name_vn'] }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div x-show="showPicker" x-transition
                        class="absolute top-full left-0 right-0 bg-white shadow-2xl border-t border-zinc-100 p-8 z-50 rounded-b-3xl">
                        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 max-w-7xl mx-auto">
                            @foreach ($collections as $category => $data)
                                <button @click="activeCollection = '{{ $category }}'; showPicker = false"
                                    class="group/pick relative h-32 rounded-xl overflow-hidden hover:cursor-pointer">
                                    <img src="{{ $data['images'][0]['url'] }}"
                                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover/pick:scale-110">
                                    <div
                                        class="absolute inset-0 bg-black/40 group-hover/pick:bg-pink-500/60 transition-colors flex items-center justify-center p-4">
                                        <span
                                            class="text-white text-[10px] font-black uppercase tracking-widest text-center">{{ $data['name_vn'] }}</span>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative min-h-[600px]">
                @foreach ($collections as $category => $data)
                    <div x-show="activeCollection === '{{ $category }}'" x-transition class="space-y-12">
                        <div class="max-w-2xl mx-auto text-center">
                            <p class="text-[#777777] text-xl font-light italic leading-relaxed">"{{ $data['desc'] }}"
                            </p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-4 auto-rows-[300px] gap-6">
                            @foreach ($data['images'] as $idx => $img)
                                <div class="{{ $img['size'] }} relative overflow-hidden rounded-[4px] cursor-pointer hover:cursor-pointer shadow-sm group/item camera-focus-hover"
                                    @click="openModal('{{ $img['url'] }}', '{{ $img['title'] }}', {{ json_encode($data['images']) }}, {{ $idx }})">
                                    <img src="{{ $img['url'] }}"
                                        class="h-full w-full object-cover transition-transform duration-700 group-hover/item:scale-110">
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 group-hover/item:opacity-100 transition-all duration-500 flex flex-col justify-end p-8">
                                        <h3 class="text-center text-white text-2xl font-black uppercase italic">
                                            {{ $img['title'] }}</h3>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- 5. Human Element: The Process --}}
        <section id="process" class="py-24 md:py-32 bg-zinc-50 -mx-4 md:-mx-12 lg:-mx-32 px-4 md:px-12 lg:px-32">
            <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12 md:gap-20 items-center">
                    <div class="lg:col-span-2 space-y-6 md:space-y-8">
                        <div class="space-y-2">
                            <span class="text-pink-500 text-xs font-black uppercase tracking-[0.5em] block">Quy trình
                                sáng tạo</span>
                            <h2 class="text-4xl md:text-6xl font-black tracking-tighter text-[#222222]">Khoảnh khắc
                                <span class="text-pink-500">Phía sau</span>
                            </h2>
                        </div>
                        <p class="text-[#777777] text-lg md:text-xl font-light leading-relaxed italic">"Phía sau mỗi
                            tác phẩm là sự tỉ mỉ trong từng khâu chuẩn bị, từ việc thấu hiểu khách hàng đến việc tinh
                            chỉnh từng tia sáng."</p>
                        <div class="pt-4 md:pt-8">
                            <div class="flex items-center gap-6">
                                <div class="w-16 md:w-20 h-[1px] bg-pink-500"></div>
                                <span
                                    class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-pink-500">Xem
                                    cách tôi làm việc</span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="relative h-[450px] md:h-[600px] flex items-center justify-center overflow-hidden md:overflow-visible mt-12 lg:mt-0">
                        @foreach ($polaroids as $idx => $item)
                            @php
                                $positions = [
                                    ['l' => '0%', 't' => '5%'],
                                    ['l' => '40%', 't' => '0%'],
                                    ['l' => '10%', 't' => '40%'],
                                    ['l' => '50%', 't' => '35%'],
                                ];
                                $pos = $positions[$idx % 4];
                            @endphp
                            <div class="absolute w-[180px] md:w-[240px] p-3 md:p-4 bg-white shadow-xl transition-all duration-500 hover:z-50 hover:scale-110 hover:rotate-0 {{ $item['angle'] }} cursor-pointer hover:cursor-pointer"
                                style="left: {{ $pos['l'] }}; top: {{ $pos['t'] }};">
                                <img src="{{ $item['url'] }}"
                                    class="w-full aspect-square object-cover mb-3 md:mb-4">
                                <p class="font-serif italic text-zinc-500 text-center text-[10px] md:text-sm">
                                    {{ $item['title'] }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        {{-- 6. Technical Mastery: Comparison --}}
        <section id="comparison" class="py-24 md:py-32">
            <div class="max-w-7xl mx-auto">
                <div class="space-y-2">
                    <span class="text-pink-500 text-xs font-black uppercase tracking-[0.5em] block">Kỹ thuật hậu
                        kỳ</span>
                    <h2 class="text-4xl md:text-6xl font-black tracking-tighter text-[#222222]">Nghệ thuật <span
                            class="text-pink-500">Chỉnh sửa</span></h2>
                </div>
                <p
                    class="mt-4 text-[#777777] text-base md:text-lg font-light leading-relaxed italic border-l-2 border-pink-500 pl-6">
                    "Hậu kỳ là nơi linh hồn của bức ảnh được đánh thức. Như tinh chỉnh từng sắc độ để kể lại câu
                    chuyện theo cách chân thực nhất."</p>

                <div class="mt-12 relative w-full aspect-[16/9] overflow-hidden rounded-[8px] shadow-2xl cursor-col-resize select-none"
                    x-data="{ position: 50, active: false }" @mousedown="active = true" @mouseup="active = false"
                    @mouseleave="active = false"
                    @mousemove="if(active) position = (($event.pageX - $el.getBoundingClientRect().left) / $el.offsetWidth) * 100">
                    <img src="{{ $comparison['after'] }}" class="absolute inset-0 w-full h-full object-cover">
                    <img src="{{ $comparison['before'] }}" class="absolute inset-0 w-full h-full object-cover"
                        :style="`clip-path: inset(0 ${100 - position}% 0 0)`">
                    <div class="absolute inset-y-0 w-1 bg-white shadow-xl z-20" :style="`left: ${position}%`">
                        <div
                            class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-12 h-12 bg-white rounded-full shadow-2xl flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="3" stroke="currentColor" class="size-5 text-pink-500">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- 7. Accomplishments: Exhibitions & Milestones --}}
        {{-- <section id="exhibitions" class="py-32 bg-zinc-950 -mx-4 md:-mx-12 lg:-mx-32 px-4 md:px-12 lg:px-32">
            <div class="mb-20 text-center space-y-4">
                <div class="space-y-2">
                    <span class="text-pink-500 text-xs font-black uppercase tracking-[0.5em] block text-white/60">Hành trình nghệ thuật</span>
                    <h2 class="text-5xl md:text-6xl font-black tracking-tighter text-white">Triển lãm & <span class="text-pink-500">Dấu ấn</span></h2>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 md:row-span-2 gap-6 h-auto md:h-[800px]">
                @foreach ($exhibitions as $idx => $ex)
                    <div class="{{ $ex['class'] }} relative overflow-hidden rounded-[4px] group/exhibition cursor-pointer shadow-xl camera-focus-hover"
                         @click="openModal('{{ $ex['url'] }}', '{{ $ex['title'] }}', {{ json_encode($exhibitions) }}, {{ $idx }})">
                        <img src="{{ $ex['url'] }}" class="w-full h-full object-cover transition-transform duration-1000 group-hover/exhibition:scale-110">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover/exhibition:opacity-100 transition-opacity flex flex-col justify-end p-8">
                            <span class="text-pink-500 text-[10px] font-black uppercase mb-2">{{ $ex['location'] }}</span>
                            <h3 class="text-white text-3xl font-black tracking-tighter">{{ $ex['title'] }}</h3>
                        </div>
                    </div>
                @endforeach
            </div>
        </section> --}}

        {{-- 8. Social Proof: Testimonials --}}
        <section id="testimonials" class="py-24 md:py-32 overflow-hidden bg-white">
            <div class="max-w-7xl mx-auto px-4">
                <div class="mb-12 md:mb-20 text-center space-y-4">
                    <div class="space-y-2">
                        <span class="text-pink-500 text-xs font-black uppercase tracking-[0.5em] block">Đánh giá từ
                            khách hàng</span>
                        <h2 class="text-4xl md:text-6xl font-black tracking-tighter text-[#222222]">Cảm nhận <span
                                class="text-pink-500">Chân thực</span></h2>
                    </div>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 md:gap-12">
                    @foreach ($testimonials as $t)
                        <div class="space-y-6 md:space-y-8 p-8 md:p-12 bg-zinc-50 rounded-[20px] relative">
                            <svg class="absolute top-6 right-6 md:top-8 md:right-8 size-10 md:size-12 text-pink-500/20"
                                fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M14.017 21L14.017 18C14.017 16.8954 14.9124 16 16.017 16H19.017C19.5693 16 20.017 15.5523 20.017 15V9C20.017 8.44772 19.5693 8 19.017 8H15.017C14.4647 8 14.017 8.44772 14.017 9V11C14.017 11.5523 13.5693 12 13.017 12H12.017V4H22.017V15C22.017 18.3137 19.3307 21 16.017 21H14.017ZM2.01697 21L2.01697 18C2.01697 16.8954 2.9124 16 4.01697 16H7.01697C7.56925 16 8.01697 15.5523 8.01697 15V9C8.01697 8.44772 7.56925 8 7.01697 8H3.01697C2.46468 8 2.01697 8.44772 2.01697 9V11C2.01697 11.5523 1.56925 12 1.01697 12H0.0169678V4H10.017V15C10.017 18.3137 7.33068 21 4.01697 21H2.01697Z" />
                            </svg>
                            <p class="text-lg md:text-xl font-light italic leading-relaxed text-[#222222]">
                                "{{ $t['content'] }}"</p>
                            <div class="pt-4 border-t border-[#EAD1D5]">
                                <h4 class="font-black text-[#222222] uppercase tracking-tighter">{{ $t['author'] }}
                                </h4>
                                <p class="text-[9px] md:text-[10px] font-bold text-pink-500 uppercase tracking-widest">
                                    {{ $t['role'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- 9. The Offer: Services --}}
        <section id="services" class="py-24 md:py-32">
            <div class="mb-12 md:mb-20 text-center space-y-4">
                <div class="space-y-2">
                    <span class="text-pink-500 text-xs font-black uppercase tracking-[0.5em] block">Dịch vụ chuyên
                        nghiệp</span>
                    <h2 class="text-4xl md:text-6xl font-black tracking-tighter text-[#222222]">Hợp tác cùng <span
                            class="text-pink-500">Như</span></h2>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-10">
                @foreach ($services as $index => $service)
                    <div
                        class="relative group/service p-10 md:p-12 bg-white border border-[#EAD1D5] rounded-[32px] overflow-hidden transition-all duration-700 hover:shadow-[0_40px_80px_-15px_rgba(188,138,144,0.15)] hover:-translate-y-2">
                        <div
                            class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 text-9xl font-black text-zinc-50 group-hover/service:text-pink-50/50 transition-colors duration-700 select-none -z-10">
                            {{ $index + 1 }}
                        </div>

                        <div
                            class="w-16 h-16 mb-8 rounded-2xl bg-[#EAD1D5]/20 flex items-center justify-center text-pink-500 group-hover/service:bg-pink-500 group-hover/service:text-white transition-all duration-500 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $service['icon'] }}" />
                            </svg>
                        </div>

                        <h3 class="text-3xl font-black tracking-tighter text-[#222222] mb-4">{{ $service['title'] }}
                        </h3>
                        <p class="text-[#777777] text-lg font-light leading-relaxed mb-8 italic">
                            "{{ $service['desc'] }}"</p>

                        <div class="pt-4 border-t border-zinc-100">
                            <a href="#contact"
                                class="inline-flex items-center gap-3 text-[10px] font-black uppercase tracking-widest text-pink-500 hover:gap-5 transition-all hover:cursor-pointer">
                                Liên hệ tư vấn
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- 10. Final Call to Action: Contact --}}
        <section id="contact"
            class="my-24 md:my-32 py-24 md:py-32 bg-zinc-100/50 -mx-4 px-6 md:-mx-12 md:px-12 lg:-mx-32 lg:px-32 rounded-[32px] md:rounded-[64px] text-[#222222] relative overflow-hidden group border border-[#EAD1D5]/30">
            <div
                class="absolute top-0 right-0 w-96 h-96 bg-pink-500/5 rounded-full -translate-y-1/2 translate-x-1/2 blur-[100px] pointer-events-none">
            </div>
            <div
                class="absolute bottom-0 left-0 w-64 h-64 bg-white rounded-full translate-y-1/2 -translate-x-1/2 blur-[80px] pointer-events-none">
            </div>

            <div class="relative z-10 max-w-6xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                    <div class="space-y-8 text-center lg:text-left">
                        <div class="space-y-4">
                            <span class="text-pink-500 text-xs font-black uppercase tracking-[0.5em] block">Kết nối
                                cùng tôi</span>
                            <h2 class="text-5xl md:text-7xl font-black tracking-tighter leading-tight uppercase">
                                Ghi lại <span class="text-pink-500 italic">câu chuyện</span><br>của bạn ngay.
                            </h2>
                        </div>
                        <p class="text-[#777777] text-xl font-light italic max-w-xl mx-auto lg:mx-0">
                            "Đừng ngần ngại liên hệ để chúng ta có thể cùng nhau tạo nên những tác phẩm nghệ thuật tuyệt
                            vời nhất."
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="{{ $socials['zalo'] }}" target="_blank"
                            class="flex items-center gap-6 p-6 rounded-[24px] bg-gradient-to-br from-white to-pink-50 border border-pink-100 hover:border-pink-300 hover:scale-[1.02] transition-all duration-500 group/link hover:cursor-pointer shadow-sm hover:shadow-pink-200/50">
                            <div
                                class="w-12 h-12 flex items-center justify-center rounded-xl bg-white group-hover/link:bg-pink-500 group-hover/link:text-white transition-all duration-500 shadow-sm border border-pink-50">
                                <span class="text-xl font-black italic">Z</span>
                            </div>
                            <div class="flex flex-col">
                                <span
                                    class="text-[9px] font-black uppercase tracking-widest text-pink-400/80 group-hover/link:text-pink-600 transition-colors">Messenger</span>
                                <span class="text-lg font-black uppercase tracking-tight text-zinc-800">Zalo</span>
                            </div>
                        </a>

                        <a href="{{ $socials['facebook'] }}" target="_blank"
                            class="flex items-center gap-6 p-6 rounded-[24px] bg-gradient-to-br from-white to-pink-50 border border-pink-100 hover:border-pink-300 hover:scale-[1.02] transition-all duration-500 group/link hover:cursor-pointer shadow-sm hover:shadow-pink-200/50">
                            <div
                                class="w-12 h-12 flex items-center justify-center rounded-xl bg-white group-hover/link:bg-pink-500 group-hover/link:text-white transition-all duration-500 shadow-sm border border-pink-50">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                    class="size-6">
                                    <path
                                        d="M9.19795 21.5H13.198V13.403H16.746L17.246 9.56H13.198V7.583C13.198 6.53 13.448 5.72 14.742 5.72H17.246V2.403C16.811 2.348 15.617 2.25 14.12 2.25C11 2.25 9.19795 4.14 9.19795 7.14V9.56H6.19795V13.403H9.19795V21.5Z" />
                                </svg>
                            </div>
                            <div class="flex flex-col">
                                <span
                                    class="text-[9px] font-black uppercase tracking-widest text-pink-400/80 group-hover/link:text-pink-600 transition-colors">Social</span>
                                <span class="text-lg font-black uppercase tracking-tight text-zinc-800">Facebook</span>
                            </div>
                        </a>

                        <a href="{{ $socials['instagram'] }}" target="_blank"
                            class="flex items-center gap-6 p-6 rounded-[24px] bg-gradient-to-br from-white to-pink-50 border border-pink-100 hover:border-pink-300 hover:scale-[1.02] transition-all duration-500 group/link hover:cursor-pointer shadow-sm hover:shadow-pink-200/50">
                            <div
                                class="w-12 h-12 flex items-center justify-center rounded-xl bg-white group-hover/link:bg-pink-500 group-hover/link:text-white transition-all duration-500 shadow-sm border border-pink-50">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                    class="size-6">
                                    <path
                                        d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                                </svg>
                            </div>
                            <div class="flex flex-col">
                                <span
                                    class="text-[9px] font-black uppercase tracking-widest text-pink-400/80 group-hover/link:text-pink-600 transition-colors">Visual
                                    Story</span>
                                <span
                                    class="text-lg font-black uppercase tracking-tight text-zinc-800">Instagram</span>
                            </div>
                        </a>

                        <a href="mailto:{{ $socials['email'] }}"
                            class="flex items-center gap-6 p-6 rounded-[24px] bg-gradient-to-br from-white to-pink-50 border border-pink-100 hover:border-pink-300 hover:scale-[1.02] transition-all duration-500 group/link hover:cursor-pointer shadow-sm hover:shadow-pink-200/50">
                            <div
                                class="w-12 h-12 flex items-center justify-center rounded-xl bg-white group-hover/link:bg-pink-500 group-hover/link:text-white transition-all duration-500 shadow-sm border border-pink-50">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="2" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                </svg>
                            </div>
                            <div class="flex flex-col overflow-hidden">
                                <span
                                    class="text-[9px] font-black uppercase tracking-widest text-pink-400/80 group-hover/link:text-pink-600 transition-colors">Direct
                                    Email</span>
                                <span
                                    class="text-sm font-black truncate max-w-full tracking-tight text-zinc-800">{{ $socials['email'] }}</span>
                            </div>
                        </a>
                    </div>
                </div>

                <div
                    class="mt-20 pt-10 border-t border-[#EAD1D5]/50 w-full flex flex-col md:flex-row justify-between items-center gap-6">
                    <p class="text-[#777777] text-[9px] font-black uppercase tracking-widest">&copy;
                        {{ date('Y') }} {{ $about['name'] }}</p>
                    <div class="flex gap-6">
                        <a href="#"
                            class="text-[#777777] text-[9px] font-black uppercase tracking-widest hover:text-pink-500 transition-colors">Privacy</a>
                        <a href="#"
                            class="text-[#777777] text-[9px] font-black uppercase tracking-widest hover:text-pink-500 transition-colors">Terms</a>
                    </div>
                </div>
            </div>
        </section>

        {{-- Cinematic & Abstract: Atmospheric Extras --}}
        {{-- <section id="cinematic" class="py-32 overflow-hidden bg-zinc-950 -mx-4 md:-mx-12 lg:-mx-32 px-4 md:px-12 lg:px-32">
            <div class="flex gap-4 animate-scroll whitespace-nowrap">
                @foreach (array_merge($cinematic, $cinematic) as $img)
                    <div class="inline-block w-[300px] md:w-[600px] h-[400px] relative group/cine overflow-hidden rounded-[4px] border-x-8 border-zinc-900">
                        <img src="{{ $img['url'] }}" class="w-full h-full object-cover grayscale group-hover/cine:grayscale-0 transition-all duration-1000">
                    </div>
                @endforeach
            </div>
        </section> --}}

        {{-- Lightbox --}}
        <div x-show="showModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 md:p-12">
            <div class="absolute inset-0 bg-zinc-950/98 backdrop-blur-3xl" @click="closeModal()"></div>
            <div x-show="showModal" x-transition
                class="relative flex h-full max-w-6xl w-full flex-col overflow-hidden bg-transparent pointer-events-none">
                <div
                    class="absolute top-0 left-0 right-0 z-20 flex items-center justify-between p-4 md:p-6 pointer-events-none">
                    <div
                        class="bg-white/5 backdrop-blur-md px-4 md:px-5 py-2 rounded-full border border-white/10 pointer-events-auto">
                        <span class="text-[9px] md:text-[10px] font-black uppercase tracking-[0.3em] text-white/60"
                            x-text="`${currentIndex + 1} / ${currentImages.length}`"></span>
                    </div>
                    <button @click="closeModal()"
                        class="pointer-events-auto flex h-10 w-10 md:h-12 md:w-12 items-center justify-center rounded-full bg-white/5 text-white/80 hover:bg-white hover:text-zinc-950 transition-all hover:cursor-pointer">
                        <svg class="size-4 md:size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div
                    class="relative flex-1 flex items-center justify-center group/modal pointer-events-auto overflow-hidden">
                    <img :src="modalImg" :class="zoom ? 'max-h-[95vh] scale-110' : 'max-h-[80vh] scale-100'"
                        @click="zoom = !zoom" class="object-contain transition-all duration-1000 cursor-zoom-in">
                    <button @click="prevImage()"
                        class="absolute left-8 top-1/2 -translate-y-1/2 flex h-16 w-16 items-center justify-center rounded-full bg-white/5 text-white/40 hover:text-white transition-all opacity-0 group-hover/modal:opacity-100 hover:cursor-pointer">
                        <svg class="size-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </button>
                    <button @click="nextImage()"
                        class="absolute right-8 top-1/2 -translate-y-1/2 flex h-16 w-16 items-center justify-center rounded-full bg-white/5 text-white/40 hover:text-white transition-all opacity-0 group-hover/modal:opacity-100 hover:cursor-pointer">
                        <svg class="size-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                </div>
                <div class="py-12 text-center pointer-events-auto">
                    <h2 class="text-2xl md:text-3xl font-black tracking-tighter text-white uppercase"
                        x-text="modalTitle"></h2>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] {
            display: none !important;
        }

        @keyframes ken-burns {
            0% {
                transform: scale(1);
            }

            100% {
                transform: scale(1.1);
            }
        }

        .animate-ken-burns {
            animation: ken-burns 30s ease-out forwards;
        }

        @keyframes fade-up {
            0% {
                opacity: 0;
                transform: translateY(40px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-up {
            animation: fade-up 1.5s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        }

        @keyframes fade-right {
            0% {
                opacity: 0;
                transform: translateX(-40px);
            }

            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .animate-fade-right {
            animation: fade-right 1.5s cubic-bezier(0.2, 0.8, 0.2, 1) forwards;
        }

        .camera-focus-hover::after {
            content: '';
            position: absolute;
            inset: 0;
            border: 1px solid #BC8A90;
            pointer-events: none;
            z-index: 20;
            opacity: 0;
            transition: all 0.5s ease-out;
            clip-path: polygon(0 0, 40px 0, 40px 1px, 1px 1px, 1px 40px, 0 40px, calc(100% - 40px) 0, 100% 0, 100% 40px, calc(100% - 2px) 40px, calc(100% - 1px) 40px, calc(100% - 1px) 1px, calc(100% - 40px) 1px, 0 calc(100% - 40px), 0 100%, 40px 100%, 40px calc(100% - 1px), 1px calc(100% - 1px), 1px calc(100% - 40px), 100% calc(100% - 40px), 100% 100%, calc(100% - 40px) 100%, calc(100% - 40px) calc(100% - 1px), calc(100% - 1px) calc(100% - 1px), calc(100% - 1px) calc(100% - 40px));
        }

        .camera-focus-hover::before {
            content: '+';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(0.5);
            color: #BC8A90;
            font-size: 2rem;
            font-weight: 200;
            opacity: 0;
            transition: all 0.5s ease-out;
            z-index: 21;
            pointer-events: none;
        }

        .group:hover.camera-focus-hover::after,
        .group\/item:hover.camera-focus-hover::after,
        .group\/featured:hover.camera-focus-hover::after,
        .story-card-container:hover .camera-focus-hover::after {
            opacity: 1;
            inset: 15px;
        }

        .group:hover.camera-focus-hover::before,
        .group\/item:hover.camera-focus-hover::before,
        .group\/featured:hover.camera-focus-hover::before,
        .story-card-container:hover .camera-focus-hover::before {
            opacity: 1;
            transform: translate(-50%, -50%) scale(1);
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .mask-fade-edges {
            mask-image: linear-gradient(to right, transparent, black 5%, black 95%, transparent);
        }

        @keyframes scroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(calc(-600px * 4 - 1rem * 4));
            }
        }

        .animate-scroll {
            animation: scroll 40s linear infinite;
        }

        .perspective-1000 {
            perspective: 1000px;
        }

        .transform-style-3d {
            transform-style: preserve-3d;
        }

        .backface-hidden {
            backface-visibility: hidden;
        }

        .rotate-y-180 {
            transform: rotateY(180deg);
        }

        .group:hover .story-card-inner {
            transform: rotateY(-180deg);
        }
    </style>
</x-prezet.template>
