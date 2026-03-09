@props(['href', 'active' => false])

<a href="{{ $href }}"
    {{ $attributes->merge([
        'class' =>
            'text-sm font-semibold transition-colors ' .
            ($active
                ? 'text-primary-600 dark:text-primary-500'
                : 'text-zinc-600 dark:text-zinc-400 hover:text-primary-500 dark:hover:text-primary-500'),
    ]) }}>
    {{ $slot }}
</a>
