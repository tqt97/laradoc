@props(['disabled' => false, 'error' => null])

<div class="relative">
    <select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
        'class' =>
            'w-full rounded-3xl bg-zinc-50 dark:bg-zinc-800 border-none focus:ring-2 focus:ring-primary-500 text-sm py-3 px-4 dark:text-white dark:placeholder:text-zinc-500 transition-all shadow-sm focus:shadow-md appearance-none',
    ]) !!}>
        {{ $slot }}
    </select>
    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-zinc-400">
        <svg class="h-4 w-4 fill-current" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
        </svg>
    </div>
    @if ($error)
        <p class="mt-1 text-xs text-red-500 font-medium ml-1">{{ $error }}</p>
    @endif
</div>
