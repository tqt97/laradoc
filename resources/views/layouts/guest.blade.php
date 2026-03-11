<x-prezet.template>
    <div class="min-h-[calc(100vh-200px)] flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <div>
            <a href="/">
                <x-prezet.logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-10 py-10 bg-white dark:bg-zinc-900 shadow-xl overflow-hidden sm:rounded-3xl border border-zinc-200/50 dark:border-zinc-800/50">
            {{ $slot }}
        </div>
    </div>
</x-prezet.template>
