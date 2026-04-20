<x-story-layout>
    <div class="max-w-4xl mx-auto py-6 md:py-12 px-2 md:px-4">
        <div
            class="relative flex min-h-[85vh] bg-white dark:bg-zinc-900 shadow-2xl rounded-2xl overflow-hidden border border-zinc-200 dark:border-zinc-800">
            <div
                class="w-12 md:w-16 flex-none bg-zinc-50 dark:bg-zinc-800/50 border-r border-zinc-200 dark:border-zinc-800 flex flex-col items-center py-10 md:py-16 gap-4">
                @for ($i = 0; $i < 15; $i++)
                <div class="spiral-ring -mr-4 md:-mr-6 z-20"></div> @endfor
            </div>
            <div class="flex-grow notebook-bg p-6 md:p-16 relative">
                <div class="notebook-margin">
                    <h1 class="text-4xl md:text-5xl font-black text-zinc-900 dark:text-white handwriting mb-10">Nhật ký
                    </h1>
                    <div class="space-y-0">
                        @foreach($stories as $story)
                            <div class="group flex items-center gap-4 md:gap-6">
                                <span
                                    class="text-[10px] md:text-xs font-bold text-zinc-400 dark:text-zinc-600">{{ $story->createdAt->format('d/m') }}</span>
                                <a href="{{ route('stories.show', ['slug' => \Illuminate\Support\Str::after($story->slug, 'stories/')]) }}"
                                    class="text-base md:text-lg text-zinc-800 dark:text-zinc-200 hover:text-primary-600 transition-colors handwriting truncate">
                                    {{ $story->frontmatter->title }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-12 pt-6 border-t border-zinc-200 dark:border-zinc-800">
                        {{ $paginator->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-story-layout>
