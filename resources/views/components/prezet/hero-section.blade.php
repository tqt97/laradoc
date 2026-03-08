@php
    $hero = config('prezet.hero');
@endphp

<div
    class="relative py-16 lg:py-24 overflow-hidden border-b border-zinc-100 dark:border-zinc-800/50 bg-white dark:bg-zinc-950 font-['Be_Vietnam_Pro']">
    <div class="relative z-10 w-full flex flex-col items-center">

        {{-- Headline Section --}}
        <div class="text-center max-w-7xl mb-16 px-4">
            <h1
                class="text-4xl md:text-5xl lg:text-6xl font-black tracking-tighter text-zinc-900 dark:text-white leading-tight mb-8">
                {{ $hero['headline'] }}
            </h1>

            {{-- Storytelling Quote --}}
            <div class="relative inline-block px-6">
                {{-- Gradient Quote Icon (Left) --}}
                <div class="absolute -top-8 -left-4 size-16 opacity-50 dark:opacity-50 -z-10">
                    <svg fill="url(#quote-gradient)" viewBox="0 0 32 32">
                        <defs>
                            <linearGradient id="quote-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                <stop offset="0%" style="stop-color:var(--color-primary-500)" />
                                <stop offset="100%" style="stop-color:var(--color-indigo-500)" />
                            </linearGradient>
                        </defs>
                        <path d="M10 8v8H6c0 4.418 3.582 8 8 8V24c-6.627 0-12-5.373-12-12V8h8zm18 0v8h-4c0 4.418 3.582 8 8 8V24c-6.627 0-12-5.373-12-12V8h8z" />
                    </svg>
                </div>

                <p class="text-lg md:text-xl text-zinc-500 dark:text-zinc-400 font-medium italic leading-relaxed px-8">
                    {{ $hero['description'] }}
                </p>

                {{-- Gradient Quote Icon (Right) --}}
                <div class="absolute -bottom-8 -right-4 size-16 opacity-50 dark:opacity-50 -z-10 rotate-180">
                    <svg fill="url(#quote-gradient)" viewBox="0 0 32 32">
                        <path d="M10 8v8H6c0 4.418 3.582 8 8 8V24c-6.627 0-12-5.373-12-12V8h8zm18 0v8h-4c0 4.418 3.582 8 8 8V24c-6.627 0-12-5.373-12-12V8h8z" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Modern Feature Grid with Glassmorphism --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl w-full px-4 mb-20">
            @foreach ($hero['features'] as $f)
                <a href="{{ route($f['route']) }}"
                    class="group relative flex flex-row items-center justify-between p-4 rounded-2xl bg-zinc-900/2 dark:bg-white/2 border border-zinc-900/5 dark:border-white/5 transition-all duration-500 hover:bg-white dark:hover:bg-zinc-900 hover:shadow-2xl hover:shadow-primary-500/5 hover:-translate-y-1 overflow-hidden">

                    <div class="flex flex-row items-center gap-5 min-w-0">
                        <div class="relative shrink-0">
                            <div
                                class="absolute inset-0 bg-primary-500/20 blur-xl rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                            <div
                                class="relative size-14 rounded-xl bg-white/40 dark:bg-zinc-800/40 backdrop-blur-xl border border-white/40 dark:border-zinc-700/40 shadow-sm flex items-center justify-center text-primary-500 group-hover:scale-110 group-hover:rotate-3 transition-all duration-500 ring-1 ring-zinc-900/5 dark:ring-white/5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-7">
                                    {!! $f['icon'] !!}
                                </svg>
                            </div>
                        </div>

                        <div class="flex flex-col min-w-0">
                            <span
                                class="text-base font-bold text-zinc-900 dark:text-white mb-0.5">{{ $f['label'] }}</span>
                            <span
                                class="text-[10px] font-bold text-zinc-400 dark:text-zinc-500 truncate">{{ $f['sub'] }}</span>
                        </div>
                    </div>

                    <div
                        class="shrink-0 transition-all duration-500 opacity-0 -translate-x-4 group-hover:opacity-100 group-hover:translate-x-0 mr-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                            stroke="currentColor" class="size-5 text-primary-500">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </div>

                    <div
                        class="absolute -right-4 -bottom-4 size-24 bg-primary-500/5 rounded-full blur-2xl group-hover:bg-primary-500/10 transition-colors">
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Bottom Scroll Indicator --}}
        <a href="#series" class="group flex flex-col items-center gap-3">
            <div
                class="w-6 h-10 rounded-full border-2 border-zinc-200 dark:border-zinc-800 p-1 flex justify-center backdrop-blur-sm">
                <div class="w-1 h-2 bg-zinc-400 dark:bg-zinc-500 rounded-full animate-bounce"></div>
            </div>
            <span
                class="text-[10px] font-black uppercase tracking-[0.3em] text-zinc-400 dark:text-zinc-600 group-hover:text-primary-500 transition-colors duration-300">Di
                chuyển đén bài viết </span>
        </a>
    </div>
</div>
