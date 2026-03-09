<button x-show="scrolled" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-8" @click="window.scrollTo({top: 0, behavior: 'smooth'})"
    class="fixed bottom-6 right-6 z-40 size-10 sm:size-12 rounded-full bg-white dark:bg-zinc-800 text-zinc-900 dark:text-white shadow-2xl flex items-center justify-center group outline-none ring-1 ring-zinc-200 dark:ring-zinc-700 hover:cursor-pointer">
    <svg class="absolute inset-0 w-full h-full -rotate-90" viewBox="0 0 100 100">
        <circle class="text-zinc-100 dark:text-zinc-700/50" stroke-width="6" stroke="currentColor" fill="transparent"
            r="44" cx="50" cy="50" />
        <circle class="text-primary-500 dark:text-primary-500 transition-all duration-100" stroke-width="6"
            :stroke-dasharray="2 * Math.PI * 44" :stroke-dashoffset="2 * Math.PI * 44 * (1 - progress / 100)" stroke-linecap="round"
            stroke="currentColor" fill="transparent" r="44" cx="50" cy="50" />
    </svg>
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"
        class="size-4 sm:size-5 relative z-10 group-hover:-translate-y-1 transition-transform text-primary-500">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" />
    </svg>
</button>
