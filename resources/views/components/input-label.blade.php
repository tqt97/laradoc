@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-base uppercase1 tracking-[0.15em]1 text-gray-800 dark:text-gray-50 mb-1.5 ml-1']) }}>
    {{ $value ?? $slot }}
</label>
