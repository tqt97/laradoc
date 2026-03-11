<button {{ $attributes->merge(['type' => 'submit', 'class' => 'relative inline-flex items-center justify-center gap-2 font-bold py-3 px-6 rounded-3xl bg-red-500 text-white shadow-[0_3px_0_0_#b91c1c] hover:bg-red-600 hover:translate-y-[1px] hover:shadow-[0_2px_0_0_#b91c1c] active:translate-y-[3px] active:shadow-none focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-100 disabled:opacity-50 select-none antialiased']) }}>
    <span class="flex items-center justify-center gap-2 uppercase tracking-[0.15em] text-[10px] font-black">
        {{ $slot }}
    </span>
</button>
