@props(['value', 'required' => false])

<label {{ $attributes->merge(['class' => 'block text-sm text-left font-bold text-zinc-700 dark:text-zinc-300 mb-2']) }}>
    {{ $value ?? $slot }}
    @if ($required)
        <span class="text-red-500 ml-0.5">*</span>
    @endif
</label>
