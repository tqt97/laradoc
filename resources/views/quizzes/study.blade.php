<x-app-layout>
    <div class="min-h-[calc(100vh-200px)] flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8" x-data="{ flipped: false }">
        
        <!-- Header / Progress -->
        <div class="max-w-2xl w-full mb-8 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <a href="{{ route('quizzes.show', $topic) }}" class="text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <span class="text-sm font-medium text-zinc-500 uppercase tracking-widest">{{ $topic->name }}</span>
            </div>
            <div class="flex items-center gap-3">
                <div class="w-32 bg-zinc-200 dark:bg-zinc-800 rounded-full h-1.5">
                    <div class="bg-blue-600 h-1.5 rounded-full" style="width: {{ $stats['percentage'] }}%"></div>
                </div>
                <span class="text-xs font-bold text-zinc-900 dark:text-white">{{ $stats['percentage'] }}%</span>
            </div>
        </div>

        <!-- Flashcard -->
        <div class="max-w-2xl w-full perspective-1000">
            <div class="relative w-full min-h-[400px] transition-transform duration-500 transform-style-3d cursor-pointer" 
                 :class="{ 'rotate-y-180': flipped }"
                 @click="flipped = !flipped">
                
                <!-- Front (Question) -->
                <div class="absolute inset-0 backface-hidden bg-white dark:bg-zinc-900 rounded-2xl shadow-xl border border-zinc-200 dark:border-zinc-800 p-12 flex flex-col items-center justify-center text-center">
                    <div class="absolute top-6 left-6">
                        <span class="px-2 py-1 bg-zinc-100 dark:bg-zinc-800 text-[10px] font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400 rounded">
                            Question
                        </span>
                    </div>
                    <h3 class="text-2xl sm:text-3xl font-bold text-zinc-900 dark:text-white leading-tight">
                        {{ $question->question }}
                    </h3>
                    <p class="mt-8 text-sm text-zinc-400 animate-pulse">Click to reveal answer</p>
                </div>

                <!-- Back (Answer) -->
                <div class="absolute inset-0 backface-hidden rotate-y-180 bg-white dark:bg-zinc-900 rounded-2xl shadow-xl border border-zinc-200 dark:border-zinc-800 p-8 sm:p-12 overflow-y-auto">
                    <div class="absolute top-6 left-6">
                        <span class="px-2 py-1 bg-green-100 dark:bg-green-900/30 text-[10px] font-bold uppercase tracking-wider text-green-600 dark:text-green-400 rounded">
                            Answer
                        </span>
                    </div>
                    
                    <div class="mt-4">
                        <div class="mb-6">
                            <h4 class="text-xs font-bold text-zinc-400 uppercase tracking-widest mb-2">Short Answer</h4>
                            <p class="text-xl font-semibold text-zinc-900 dark:text-white">{{ $question->short_answer }}</p>
                        </div>

                        <div class="mb-6">
                            <h4 class="text-xs font-bold text-zinc-400 uppercase tracking-widest mb-2">Detailed Explanation</h4>
                            <div class="prose prose-zinc dark:prose-invert max-w-none text-zinc-600 dark:text-zinc-400">
                                {!! nl2br(e($question->detailed_explanation)) !!}
                            </div>
                        </div>

                        @if($question->example)
                        <div class="mb-6">
                            <h4 class="text-xs font-bold text-zinc-400 uppercase tracking-widest mb-2">Example</h4>
                            <pre class="bg-zinc-50 dark:bg-zinc-800 p-4 rounded-lg text-sm font-mono text-zinc-800 dark:text-zinc-200 overflow-x-auto">{{ $question->example }}</pre>
                        </div>
                        @endif

                        @if($question->common_mistakes)
                        <div class="mb-6">
                            <h4 class="text-xs font-bold text-red-400 uppercase tracking-widest mb-2">Common Mistakes</h4>
                            <p class="text-sm text-zinc-600 dark:text-zinc-400 italic">
                                {{ $question->common_mistakes }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons (Shown after reveal) -->
        <div class="max-w-2xl w-full mt-12 grid grid-cols-2 gap-4" x-show="flipped" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
            <form action="{{ route('quizzes.progress', $question) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="forgot">
                <button type="submit" class="w-full py-4 bg-white dark:bg-zinc-900 border border-red-200 dark:border-red-900 text-red-600 dark:text-red-400 rounded-xl font-bold hover:bg-red-50 dark:hover:bg-red-900/10 transition flex flex-col items-center">
                    <span>I forgot this</span>
                    <span class="text-[10px] font-medium opacity-60">Show again soon</span>
                </button>
            </form>

            <form action="{{ route('quizzes.progress', $question) }}" method="POST">
                @csrf
                <input type="hidden" name="status" value="known">
                <button type="submit" class="w-full py-4 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 rounded-xl font-bold hover:opacity-90 transition flex flex-col items-center">
                    <span>I knew this</span>
                    <span class="text-[10px] font-medium opacity-60 text-zinc-400 dark:text-zinc-500">Perfect recall</span>
                </button>
            </form>
        </div>

        <!-- Hint if not revealed -->
        <p class="mt-8 text-zinc-500 text-sm" x-show="!flipped">
            Press <kbd class="px-2 py-1 bg-zinc-100 dark:bg-zinc-800 rounded border border-zinc-300 dark:border-zinc-700 font-sans">Space</kbd> or click to flip
        </p>
    </div>

    <style>
        .perspective-1000 {
            perspective: 1000px;
        }
        .transform-style-3d {
            transform-style: preserve-3d;
        }
        .backface-hidden {
            backface-visibility: hidden;
        }
        .rotate-y-180 {
            transform: rotateY(180deg);
        }
    </style>

    <script>
        document.addEventListener('keydown', (e) => {
            if (e.code === 'Space') {
                e.preventDefault();
                const el = document.querySelector('[x-data]');
                if (el) el.__x.$data.flipped = !el.__x.$data.flipped;
            }
        });
    </script>
</x-app-layout>
