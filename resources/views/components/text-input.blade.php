@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full rounded-3xl bg-zinc-50 dark:bg-zinc-800 border-none focus:ring-2 focus:ring-primary-500 text-sm py-3 px-4 dark:text-white dark:placeholder:text-zinc-500 transition-all shadow-sm focus:shadow-md']) }}>
