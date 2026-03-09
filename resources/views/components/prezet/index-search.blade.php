@props(['action', 'value' => '', 'placeholder' => 'Tìm kiếm...'])

<div {{ $attributes->merge(['class' => 'mt-10 flex justify-center']) }}>
    <form action="{{ $action }}" method="GET" class="relative w-full max-w-lg group px-4">
        <div
            class="relative flex items-center p-0.5 rounded-4xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-xl focus-within:ring-2 focus-within:ring-primary-500 transition-all">
            <div class="pl-4 text-zinc-400 shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                    stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </div>
            <input type="text" name="q" value="{{ $value }}" placeholder="{{ $placeholder }}"
                class="grow bg-transparent border-none focus:ring-0 text-sm font-medium text-zinc-900 dark:text-white placeholder:text-zinc-400 py-3 px-3 min-w-0" />
            <button type="submit"
                class="bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 font-bold text-xs tracking-widest px-8 py-3 rounded-3xl transition-all shadow-lg shadow-zinc-900/10 dark:shadow-none hover:cursor-pointer hover:bg-primary-600">
                Tìm kiếm
            </button>
        </div>
    </form>
</div>
