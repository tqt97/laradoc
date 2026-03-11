<x-prezet.template>
    @isset($header)
        <header class="bg-white dark:bg-zinc-950 border-b border-zinc-200 dark:border-zinc-800 py-10 mb-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    <div class="py-10">
        {{ $slot }}
    </div>
</x-prezet.template>
