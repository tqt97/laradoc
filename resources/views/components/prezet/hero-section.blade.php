<div
    class="relative flex flex-col items-center justify-center text-center py-20 md:py-16 lg:py-20 overflow-hidden dark:border-zinc-800/50 bg-white dark:bg-zinc-950">

    {{-- Modern Background Elements --}}
    <div class="absolute inset-0 z-0">
        <div
            class="absolute top-0 left-1/4 w-96 h-96 bg-primary-500/10 dark:bg-primary-500/5 rounded-full blur-[128px] animate-pulse">
        </div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-indigo-500/10 dark:bg-indigo-500/5 rounded-full blur-[128px] animate-pulse"
            style="animation-delay: 2s"></div>
        <div
            class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-[0.03] dark:opacity-[0.05] brightness-100 contrast-150">
        </div>
    </div>

    <div class="relative z-10 max-w-7xl px-4 w-full">
        {{-- Glassy Badge --}}
        <div
            class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-zinc-900/5 dark:bg-white/5 border border-zinc-900/10 dark:border-white/10 backdrop-blur-md mb-10 bg-linear-to-r from-zinc-50 via-primary-50 to-primary-100">
            <span class="relative flex h-2 w-2">
                <span
                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-300 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-primary-500"></span>
            </span>
            <span class="text-[10px] font-semibold text-zinc-600 dark:text-zinc-400 ">Blog cá
                nhân & Portfolio</span>
        </div>

        <h1
            class="text-4xl md:text-5xl lg:text-6xl font-black tracking-tight text-zinc-900 dark:text-white leading-[1.1] mb-10">
            Lưu trữ & Chia sẻ
            <br />
            <span
                class="text-transparent bg-clip-text bg-linear-to-r from-zinc-800 via-primary-400 to-primary-500 dark:from-primary-400 dark:via-primary-400 dark:to-primary-300 animate-gradient-x">
                Kiến thức lập trình.
            </span>
        </h1>

        <div class="max-w-xl mx-auto mb-16">
            <p class="text-lg md:text-xl text-zinc-500 dark:text-zinc-400 leading-relaxed font-medium">
                Nơi <span class="text-zinc-900 dark:text-white font-bold italic">Kinh nghiệm</span> thực chiến hội
                tụ cùng
                <span class="relative inline-block">
                    <span class="relative z-10 font-bold text-zinc-900 dark:text-white">Tư duy hệ thống.</span>
                    <span
                        class="absolute bottom-1 left-0 w-full h-2 bg-primary-500/10 dark:bg-primary-500/20 -z-10"></span>
                </span>
            </p>
        </div>

        {{-- Feature Grid with Glassmorphism --}}
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-20 max-w-5xl mx-auto px-4">
            <a href="{{ route('prezet.articles') }}"
                class="group/item relative p-6 md:p-8 rounded-3xl bg-zinc-900/5 dark:bg-white/5 border border-zinc-900/10 dark:border-white/10 backdrop-blur-xl transition-all duration-500 hover:bg-primary-500/10 hover:border-primary-500/30 hover:-translate-y-px hover:shadow-2xl hover:shadow-primary-500/10 group">
                <div
                    class="size-12 md:size-14 rounded-3xl bg-white dark:bg-zinc-900 shadow-sm flex items-center justify-center mb-5 mx-auto text-primary-500 group-hover/item:scale-110 group-hover/item:rotate-3 transition-all duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 md:size-7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <span
                    class="text-xs md:text-sm font-semibold text-zinc-900 dark:text-white group-hover:text-primary-600">Bài
                    viết</span>
            </a>

            <a href="{{ route('prezet.series.index') }}"
                class="group/item relative p-6 md:p-8 rounded-3xl bg-zinc-900/5 dark:bg-white/5 border border-zinc-900/10 dark:border-white/10 backdrop-blur-xl transition-all duration-500 hover:bg-primary-500/10 hover:border-primary-500/30 hover:-translate-y-px hover:shadow-2xl hover:shadow-primary-500/10 group">
                <div
                    class="size-12 md:size-14 rounded-3xl bg-white dark:bg-zinc-900 shadow-sm flex items-center justify-center mb-5 mx-auto text-primary-500 group-hover/item:scale-110 group-hover/item:-rotate-3 transition-all duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 md:size-7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <span
                    class="text-xs md:text-sm font-semibold text-zinc-900 dark:text-white group-hover:text-primary-600">Chuỗi
                    bài viết</span>
            </a>

            <a href="{{ route('links.index') }}"
                class="group/item relative p-6 md:p-8 rounded-3xl bg-zinc-900/5 dark:bg-white/5 border border-zinc-900/10 dark:border-white/10 backdrop-blur-xl transition-all duration-500 hover:bg-primary-500/10 hover:border-primary-500/30 hover:-translate-y-px hover:shadow-2xl hover:shadow-primary-500/10 group">
                <div
                    class="size-12 md:size-14 rounded-3xl bg-white dark:bg-zinc-900 shadow-sm flex items-center justify-center mb-5 mx-auto text-primary-500 group-hover/item:scale-110 group-hover/item:rotate-3 transition-all duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 md:size-7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                    </svg>
                </div>
                <span
                    class="text-xs md:text-sm font-semibold text-zinc-900 dark:text-white group-hover:text-primary-600">Lưu
                    trữ</span>
            </a>

            <a href="{{ route('snippets.index') }}"
                class="group/item relative p-6 md:p-8 rounded-3xl bg-zinc-900/5 dark:bg-white/5 border border-zinc-900/10 dark:border-white/10 backdrop-blur-xl transition-all duration-500 hover:bg-primary-500/10 hover:border-primary-500/30 hover:-translate-y-px hover:shadow-2xl hover:shadow-primary-500/10 group">
                <div
                    class="size-12 md:size-14 rounded-3xl bg-white dark:bg-zinc-900 shadow-sm flex items-center justify-center mb-5 mx-auto text-primary-500 group-hover/item:scale-110 group-hover/item:-rotate-3 transition-all duration-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6 md:size-7">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" />
                    </svg>
                </div>
                <span
                    class="text-xs md:text-sm font-semibold text-zinc-900 dark:text-white group-hover:text-primary-600">Snippets</span>
            </a>
        </div>

        <a href="#series" class="group relative inline-flex flex-col items-center">
            {{-- Enhanced Mouse Scroll --}}
            <div class="flex flex-col items-center gap-4">
                <div
                    class="w-6 h-10 rounded-full border-2 border-zinc-300 dark:border-zinc-800 p-1 flex justify-center backdrop-blur-sm">
                    <div class="w-1 h-2 bg-zinc-400 dark:bg-zinc-500 rounded-full animate-bounce"></div>
                </div>
                <div class="flex flex-col items-center">
                    <span
                        class="text-sm font-semibold text-zinc-400 dark:text-zinc-600 group-hover:text-primary-500 transition-colors duration-300">Khám
                        phá bài viết</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                        stroke="currentColor" class="size-3 text-primary-400 dark:text-zinc-700 mt-1 animate-pulse">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>
            </div>
        </a>
    </div>
</div>
