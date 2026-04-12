<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-zinc-800 dark:text-zinc-200 leading-tight">
            {{ __('Interview Quizzes') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($topics as $topic)
            <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm sm:rounded-lg border border-zinc-200 dark:border-zinc-800 p-6 flex flex-col">
                <div class="flex-1">
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-2">{{ $topic->name }}</h3>
                    <p class="text-zinc-600 dark:text-zinc-400 text-sm mb-4">{{ $topic->description }}</p>
                    
                    <div class="mb-4">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs font-medium text-zinc-500 dark:text-zinc-400">Progress</span>
                            <span class="text-xs font-medium text-zinc-900 dark:text-white">{{ $topic->stats['percentage'] }}%</span>
                        </div>
                        <div class="w-full bg-zinc-200 dark:bg-zinc-800 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $topic->stats['percentage'] }}%"></div>
                        </div>
                        <div class="mt-1 flex justify-between text-[10px] text-zinc-500">
                            <span>{{ $topic->stats['completed'] }} / {{ $topic->stats['total'] }} questions</span>
                        </div>
                    </div>
                </div>

                <div class="mt-4 flex gap-2">
                    <a href="{{ route('quizzes.show', $topic) }}" class="flex-1 text-center px-4 py-2 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 rounded-lg font-medium text-sm transition hover:opacity-90">
                        Start Learning
                    </a>
                </div>
            </div>
        @empty
            <div class="col-span-full py-12 text-center">
                <p class="text-zinc-500">No quiz topics available yet. Topic count: {{ count($topics) }}</p>
            </div>
        @endforelse
    </div>
</x-app-layout>
