<div
    class="relative flex flex-col items-center justify-center text-center py-16 md:py-24 overflow-hidden border-b border-zinc-100 dark:border-zinc-800/50 bg-white dark:bg-zinc-950">

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

    <div class="relative z-10 max-w-7xl px-4">
        {{-- Glassy Badge --}}
        <div
            class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-zinc-900/5 dark:bg-white/5 border border-zinc-900/10 dark:border-white/10 backdrop-blur-md mb-8">
            <span class="relative flex h-2 w-2">
                <span
                    class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-primary-500"></span>
            </span>
            <span class="text-[10px] font-black uppercase tracking-[0.2em] text-zinc-600 dark:text-zinc-400">Blog cá
                nhân & Portfolio</span>
        </div>

        <h1 class="text-5xl md:text-6xl font-black tracking-tight text-zinc-900 dark:text-white leading-[1.1] mb-8">
            Ghi chép & Chia sẻ<br />
            <span
                class="text-transparent bg-clip-text bg-gradient-to-br from-zinc-400 to-zinc-600 dark:from-zinc-500 dark:to-zinc-800">Kiến
                thức lập trình.</span>
        </h1>

        <div class="relative inline-block group">
            <div
                class="absolute -inset-4 rounded-[2rem] bg-zinc-900/5 dark:bg-white/5 opacity-0 group-hover:opacity-100 blur-xl transition-opacity duration-500">
            </div>

            <a href="#latest-posts" class="relative flex flex-col items-center">
                <p
                    class="text-lg md:text-xl text-zinc-500 dark:text-zinc-400 leading-relaxed font-medium mb-12 max-w-xl mx-auto">
                    Nơi <span class="text-zinc-900 dark:text-white font-bold italic">Kinh nghiệm</span> thực chiến hội
                    tụ cùng
                    <span class="relative inline-block">
                        <span class="relative z-10 font-bold text-zinc-900 dark:text-white">Tư duy hệ thống.</span>
                        <span
                            class="absolute bottom-1 left-0 w-full h-2 bg-primary-500/10 dark:bg-primary-500/20 -z-10"></span>
                    </span>
                </p>

                {{-- Enhanced Mouse Scroll --}}
                <div class="flex flex-col items-center gap-4">
                    <div
                        class="w-6 h-10 rounded-full border-2 border-zinc-200 dark:border-zinc-800 p-1 flex justify-center backdrop-blur-sm">
                        <div class="w-1 h-2 bg-zinc-400 dark:bg-zinc-500 rounded-full animate-bounce"></div>
                    </div>
                    <div class="flex flex-col items-center">
                        <span
                            class="text-[10px] font-semibold uppercase1 tracking-[0.2em] text-zinc-400 dark:text-zinc-600 group-hover:text-primary-500 transition-colors duration-300">Khám
                            phá bài viết</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor" class="size-3 text-zinc-300 dark:text-zinc-700 mt-1 animate-pulse">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
