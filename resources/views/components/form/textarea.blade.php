@props(['disabled' => false, 'error' => null, 'rows' => 4])

<div>
    <textarea {{ $disabled ? 'disabled' : '' }} rows="{{ $rows }}" {!! $attributes->merge([
        'class' =>
            'w-full rounded-3xl bg-zinc-50 dark:bg-zinc-800 border-none focus:ring-2 focus:ring-primary-500 text-sm py-3 px-4 dark:text-white dark:placeholder:text-zinc-500 transition-all shadow-sm focus:shadow-md',
    ]) !!}>{{ $slot }}</textarea>
    @if ($error)
        <p class="mt-1 text-xs text-red-500 font-medium ml-1">{{ $error }}</p>
    @endif
</div>
