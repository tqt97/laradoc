
<x-story-layout>
    @if($previousStory)
    <a href="{{ route('stories.show', ['slug' => $previousStory->relativeSlug]) }}" class="page-turn-tab tab-left hidden md:flex">
        <svg class="size-8 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
    </a>
    @endif
    @if($nextStory)
    <a href="{{ route('stories.show', ['slug' => $nextStory->relativeSlug]) }}" class="page-turn-tab tab-right hidden md:flex">
        <svg class="size-8 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path d="M8.25 4.5l7.5 7.5-7.5 7.5" /></svg>
    </a>
    @endif

    <div class="max-w-4xl mx-auto py-6 md:py-12 px-2 md:px-4">
        <div class="relative flex min-h-[85vh] bg-white dark:bg-zinc-900 shadow-2xl rounded-2xl overflow-hidden border border-zinc-200 dark:border-zinc-800">
            <div class="w-12 md:w-16 flex-none bg-zinc-50 dark:bg-zinc-800/50 border-r border-zinc-200 dark:border-zinc-800 flex flex-col items-center py-10 md:py-16 gap-4">
                @for ($i = 0; $i < 15; $i++) <div class="spiral-ring -mr-4 md:-mr-6 z-20"></div> @endfor
            </div>

            <div class="grow notebook-bg p-6 md:p-8 relative">
                <div class="notebook-margin">
                    <article>
                        <header class="mb-10">
                            <h1 class="text-3xl md:text-5xl font-black text-zinc-900 dark:text-white mb-6 handwriting leading-tight">{{ $story->frontmatter->title }}</h1>
                            <p class="text-lg text-zinc-500 italic handwriting">{{ $story->createdAt->format('F d, Y') }}</p>
                        </header>
                        <div class="prose prose-zinc dark:prose-invert max-w-none handwriting prose-p:text-xl">
                            {!! $body !!}
                        </div>
                    </article>

                    <div class="mt-16 pt-8 border-t border-zinc-200 dark:border-zinc-800 flex justify-between md:hidden">
                        @if($previousStory)<a href="{{ route('stories.show', ['slug' => $previousStory->relativeSlug]) }}" class="text-sm font-bold handwriting">← Trước</a>@endif
                        @if($nextStory)<a href="{{ route('stories.show', ['slug' => $nextStory->relativeSlug]) }}" class="text-sm font-bold handwriting">Tiếp →</a>@endif
                    </div>
                </div>
            </div>
        </div>
        <button x-show="scrolled" x-cloak @click="window.scrollTo({top: 0, behavior: 'smooth'})"
            class="back-to-top p-4 rounded-full bg-white dark:bg-zinc-900 shadow-2xl border border-zinc-200 dark:border-zinc-800 text-primary-500 hover:text-primary-600 transition-all active:scale-95 z-50">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="size-6">
                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"/>
            </svg>
        </button>

    </div>
</x-story-layout>

