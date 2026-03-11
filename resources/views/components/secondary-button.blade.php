<button {{ $attributes->merge(['type' => 'button', 'class' => 'relative inline-flex items-center justify-center gap-2 font-bold py-3 px-6 rounded-3xl bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-800 shadow-[0_3px_0_0_#e5e7eb] dark:shadow-[0_3px_0_0_#18181b] hover:translate-y-[1px] hover:bg-zinc-50 hover:shadow-[0_2px_0_0_#e5e7eb] dark:hover:shadow-[0_2px_0_0_#18181b] active:translate-y-[3px] active:shadow-none focus:outline-none focus:ring-2 focus:ring-zinc-300 transition-all duration-100 disabled:opacity-50 select-none antialiased']) }}>
    <span class="flex items-center justify-center gap-2 uppercase tracking-[0.15em] text-[10px] font-black">
        {{ $slot }}
    </span>
</button>
