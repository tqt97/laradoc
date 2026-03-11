@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-[10px] uppercase tracking-[0.15em] text-zinc-500 dark:text-zinc-400 mb-1.5 ml-1']) }}>
    {{ $value ?? $slot }}
</label>
