@props(['type' => 'submit', 'variant' => 'primary', 'href' => null])

@php
    $baseClasses =
        'relative inline-flex items-center justify-center gap-2 font-bold py-3 px-6 rounded-3xl transition-all duration-100 disabled:opacity-50 group hover:cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 select-none antialiased';

    $variants = [
        'primary' => [
            'button' =>
                'bg-primary-500 text-white shadow-[0_3px_0_0_#c2410c] hover:bg-primary-600 hover:translate-y-[1px] hover:shadow-[0_2px_0_0_#c2410c] active:translate-y-[3px] active:shadow-none focus:ring-primary-500',
        ],
        'secondary' => [
            'button' =>
                'bg-white dark:bg-zinc-900 text-zinc-900 dark:text-white border border-zinc-200 dark:border-zinc-800 shadow-[0_3px_0_0_#e5e7eb] dark:shadow-[0_3px_0_0_#18181b] hover:translate-y-[1px] hover:bg-zinc-50 hover:shadow-[0_2px_0_0_#e5e7eb] dark:hover:shadow-[0_2px_0_0_#18181b] active:translate-y-[3px] active:shadow-none focus:ring-zinc-300',
        ],
        'danger' => [
            'button' =>
                'bg-red-500 text-white shadow-[0_3px_0_0_#b91c1c] hover:bg-red-600 hover:translate-y-[1px] hover:shadow-[0_2px_0_0_#b91c1c] active:translate-y-[3px] active:shadow-none focus:ring-red-500',
        ],
    ];

    $v = $variants[$variant] ?? $variants['primary'];
@endphp

@if($href)
    <a {{ $attributes->merge(['href' => $href, 'class' => $baseClasses . ' ' . $v['button']]) }}>
        <span class="flex items-center justify-center gap-2 uppercase tracking-[0.15em] text-[10px] font-black">
            {{ $slot }}
        </span>
    </a>
@else
    <button {{ $attributes->merge(['type' => $type, 'class' => $baseClasses . ' ' . $v['button']]) }}>
        <span class="flex items-center justify-center gap-2 uppercase tracking-[0.15em] text-[10px] font-black">
            {{ $slot }}
        </span>
    </button>
@endif
