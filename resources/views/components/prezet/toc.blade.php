@props(['headings' => []])

<div {{ $attributes->merge(['class' => '']) }} x-data="{ isDrawerOpen: false }">
    <!-- Floating Toggle Button -->
    <button
        @click="isDrawerOpen = !isDrawerOpen"
        class="fixed right-0 top-1/2 -translate-y-1/2 z-40 bg-white dark:bg-zinc-900 border border-r-0 border-zinc-200 dark:border-zinc-800 rounded-l-2xl p-2 shadow-xl hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-all duration-300 group hover:cursor-pointer"
        aria-label="Toggle Table of Contents"
    >
        <div class="flex flex-col items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                class="size-5 text-primary-500 group-hover:scale-110 transition-transform">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-3.75 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
            </svg>
            <span class="[writing-mode:vertical-lr] rotate-180 text-[10px] font-bold uppercase tracking-widest text-zinc-500 dark:text-zinc-400">
                Mục lục
            </span>
        </div>
    </button>

    <!-- Overlay -->
    <div
        x-show="isDrawerOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="isDrawerOpen = false"
        class="fixed inset-0 bg-zinc-900/20 backdrop-blur-sm z-40"
        x-cloak
    ></div>

    <!-- Drawer Panel -->
    <div
        x-show="isDrawerOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed right-0 top-0 h-full w-80 bg-white dark:bg-zinc-900 shadow-2xl z-50 border-l border-zinc-200 dark:border-zinc-800 flex flex-col"
        x-cloak
    >
        <!-- Drawer Header -->
        <div class="p-6 border-b border-zinc-100 dark:border-zinc-800 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                    class="size-4 text-primary-500">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-3.75 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                </svg>
                <h2 class="font-bold text-xs tracking-[0.2em] text-zinc-900 dark:text-zinc-100 uppercase">
                    Mục lục bài viết
                </h2>
            </div>
            <button @click="isDrawerOpen = false" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Drawer Content (Scrollable) -->
        <div class="flex-1 overflow-y-auto p-6 custom-scrollbar">
            <ol role="list" class="space-y-0 text-xs border-l border-zinc-100 dark:border-zinc-800">
                @foreach ($headings as $h2)
                    <li class="relative">
                        <div x-show="activeHeading === '{{ $h2['id'] }}'"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-x-1"
                            x-transition:enter-end="opacity-100 translate-x-0"
                            class="absolute -left-px top-0 h-full w-0.5 bg-primary-500"></div>

                        <a href="#{{ $h2['id'] }}"
                            :class="activeHeading === '{{ $h2['id'] }}' ?
                                'text-primary-600 dark:text-primary-400 font-bold bg-primary-50/50 dark:bg-primary-900/10' :
                                'text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-200'"
                            x-on:click.prevent="scrollToHeading('{{ $h2['id'] }}'); isDrawerOpen = false"
                            class="block pl-4 py-2 transition-all duration-200 leading-relaxed rounded-r-lg">
                            {{ $h2['title'] }}
                        </a>

                        @if (!empty($h2['children']))
                            <ol role="list" class="mt-px space-y-0">
                                @foreach ($h2['children'] as $h3)
                                    <li class="relative">
                                        <div x-show="activeHeading === '{{ $h3['id'] }}'"
                                            x-transition:enter="transition ease-out duration-200"
                                            x-transition:enter-start="opacity-0 -translate-x-1"
                                            x-transition:enter-end="opacity-100 translate-x-0"
                                            class="absolute -left-px top-0 h-full w-0.5 bg-primary-500/50">
                                        </div>

                                        <a href="#{{ $h3['id'] }}"
                                            :class="activeHeading === '{{ $h3['id'] }}' ?
                                                'text-primary-600 dark:text-primary-400 font-bold bg-primary-50/30 dark:bg-primary-900/5' :
                                                'text-zinc-500 hover:text-zinc-700 dark:text-zinc-500 dark:hover:text-zinc-300'"
                                            x-on:click.prevent="scrollToHeading('{{ $h3['id'] }}'); isDrawerOpen = false"
                                            class="block pl-8 py-2 text-xs transition-all duration-200 leading-relaxed rounded-r-lg">
                                            {{ $h3['title'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ol>
                        @endif
                    </li>
                @endforeach
            </ol>
        </div>

        <!-- Drawer Footer -->
        <div class="p-6 border-t border-zinc-100 dark:border-zinc-800 bg-zinc-50/50 dark:bg-zinc-900/50">
            <p class="text-[10px] text-zinc-400 text-center font-medium uppercase tracking-tighter">
                Sử dụng các mục để điều hướng nhanh
            </p>
        </div>
    </div>
</div>
