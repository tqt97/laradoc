<x-prezet.template>
    <x-prezet.subpage-header :title="$file->name" :subtitle="'Xem trước tệp ' . (explode('/', $file->mime_type)[1] ?? $file->mime_type)">
        <div class="mt-10 flex gap-4">
            <x-form.button href="{{ route('files.index') }}" variant="secondary" class="!px-6">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Quay lại
            </x-form.button>
            <x-form.button href="{{ asset('storage/' . $file->path) }}" download="{{ $file->name }}" target="_blank" class="!px-6">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                </svg>
                Tải xuống
            </x-form.button>
        </div>
    </x-prezet.subpage-header>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-zinc-950 rounded-3xl border border-zinc-100 dark:border-zinc-800 p-4 sm:p-8 shadow-sm">
                {!! $content !!}
            </div>
        </div>
    </div>
</x-prezet.template>
