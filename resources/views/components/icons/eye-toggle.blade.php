@props([
    'show' => 'show',
])

<button type="button" aria-label="Toggle password visibility"
    {{ $attributes->merge([
        'class' => 'absolute inset-y-0 right-0 flex items-center px-3 text-gray-400 hover:text-gray-700 transition',
    ]) }}
    @click="{{ $show }} = !{{ $show }}">
    <!-- Eye -->
    <svg x-show="!{{ $show }}" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-7.5 9.75-7.5S21.75 12 21.75 12
            18 19.5 12 19.5 2.25 12 2.25 12z" />
        <circle cx="12" cy="12" r="3" />
    </svg>

    <!-- Eye Slash -->
    <svg x-show="{{ $show }}" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M10.58 10.58A3 3 0 0012 15a3 3 0 002.42-4.42
            M9.88 5.1A9.77 9.77 0 0112 4.5c6 0 9.75 7.5 9.75 7.5
            a16.89 16.89 0 01-4.02 5.14M6.1 6.1A16.88 16.88 0 002.25 12
            S6 19.5 12 19.5c1.61 0 3.09-.38 4.4-1.05" />
    </svg>
</button>
