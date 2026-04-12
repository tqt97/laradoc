<x-app-layout>
    <div class="min-h-[calc(100vh-200px)] flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8" x-data="{ 
        selected: null, 
        revealed: false,
        correctOption: '{{ $question->correct_option }}',
        isCorrect() {
            return this.selected === this.correctOption;
        }
    }">
        
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
                    <div class="bg-purple-600 h-1.5 rounded-full" style="width: {{ $stats['percentage'] }}%"></div>
                </div>
                <span class="text-xs font-bold text-zinc-900 dark:text-white">{{ $stats['percentage'] }}%</span>
            </div>
        </div>

        <!-- Quiz Card -->
        <div class="max-w-2xl w-full bg-white dark:bg-zinc-900 rounded-2xl shadow-xl border border-zinc-200 dark:border-zinc-800 p-8 sm:p-12 transition-all duration-300">
            <div class="mb-8">
                <span class="px-2 py-1 bg-purple-100 dark:bg-purple-900/30 text-[10px] font-bold uppercase tracking-wider text-purple-600 dark:text-purple-400 rounded">
                    Multiple Choice
                </span>
                <h3 class="mt-4 text-2xl font-bold text-zinc-900 dark:text-white leading-tight">
                    {{ $question->question }}
                </h3>
            </div>

            <div class="space-y-3">
                @foreach($question->options as $key => $option)
                <button 
                    @click="if(!revealed) selected = '{{ $key }}'"
                    :disabled="revealed"
                    class="w-full text-left p-4 rounded-xl border-2 transition-all duration-200 flex items-center justify-between group"
                    :class="{
                        'border-zinc-100 dark:border-zinc-800 hover:border-zinc-300 dark:hover:border-zinc-700': selected !== '{{ $key }}' && !revealed,
                        'border-blue-500 bg-blue-50 dark:bg-blue-900/10': selected === '{{ $key }}' && !revealed,
                        'border-green-500 bg-green-50 dark:bg-green-900/10': revealed && '{{ $key }}' === correctOption,
                        'border-red-500 bg-red-50 dark:bg-red-900/10': revealed && selected === '{{ $key }}' && selected !== correctOption,
                        'opacity-50': revealed && '{{ $key }}' !== correctOption && selected !== '{{ $key }}'
                    }">
                    <div class="flex items-center gap-4">
                        <span class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-sm"
                              :class="{
                                  'bg-zinc-100 dark:bg-zinc-800 text-zinc-500': selected !== '{{ $key }}' || revealed,
                                  'bg-blue-500 text-white': selected === '{{ $key }}' && !revealed,
                                  'bg-green-500 text-white': revealed && '{{ $key }}' === correctOption,
                                  'bg-red-500 text-white': revealed && selected === '{{ $key }}' && selected !== correctOption,
                              }">
                            {{ $key }}
                        </span>
                        <span class="font-medium text-zinc-700 dark:text-zinc-300">{{ $option }}</span>
                    </div>
                    
                    <template x-if="revealed && '{{ $key }}' === correctOption">
                        <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    </template>
                </button>
                @endforeach
            </div>

            <!-- Feedback Area -->
            <div class="mt-8 pt-8 border-t border-zinc-100 dark:border-zinc-800" x-show="revealed" x-transition>
                <div class="mb-6">
                    <h4 class="text-xs font-bold text-zinc-400 uppercase tracking-widest mb-2">Explanation</h4>
                    <p class="text-zinc-600 dark:text-zinc-400 leading-relaxed">
                        {{ $question->detailed_explanation }}
                    </p>
                </div>

                <form action="{{ route('quizzes.progress', $question) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" :value="isCorrect() ? 'known' : 'incorrect'">
                    <button type="submit" class="w-full py-4 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 rounded-xl font-bold hover:opacity-90 transition">
                        Next Question
                    </button>
                </form>
            </div>

            <div class="mt-8" x-show="!revealed">
                <button 
                    @click="revealed = true"
                    :disabled="!selected"
                    class="w-full py-4 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 rounded-xl font-bold hover:opacity-90 transition disabled:opacity-50 disabled:cursor-not-allowed">
                    Check Answer
                </button>
            </div>
        </div>
    </div>
</x-app-layout>
