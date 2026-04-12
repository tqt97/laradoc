<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('quizzes.index') }}" class="text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-zinc-800 dark:text-zinc-200 leading-tight">
                {{ $topic->name }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        @if(session('message'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 rounded-lg">
                {{ session('message') }}
            </div>
        @endif

        <div class="bg-white dark:bg-zinc-900 overflow-hidden shadow-sm sm:rounded-xl border border-zinc-200 dark:border-zinc-800 p-8">
            <h3 class="text-2xl font-bold text-zinc-900 dark:text-white mb-4">Topic Overview</h3>
            <p class="text-zinc-600 dark:text-zinc-400 mb-8 leading-relaxed">
                {{ $topic->description }}
            </p>

            <div class="mb-10 grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-lg text-center">
                    <span class="block text-2xl font-bold text-zinc-900 dark:text-white">{{ $stats['total'] }}</span>
                    <span class="text-xs text-zinc-500 uppercase tracking-wider">Total Questions</span>
                </div>
                <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-lg text-center">
                    <span class="block text-2xl font-bold text-zinc-900 dark:text-white">{{ $stats['completed'] }}</span>
                    <span class="text-xs text-zinc-500 uppercase tracking-wider">Mastered</span>
                </div>
                <div class="bg-zinc-50 dark:bg-zinc-800/50 p-4 rounded-lg text-center">
                    <span class="block text-2xl font-bold text-zinc-900 dark:text-white">{{ $stats['percentage'] }}%</span>
                    <span class="text-xs text-zinc-500 uppercase tracking-wider">Completion</span>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Study Mode -->
                <div class="border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 hover:border-blue-500 dark:hover:border-blue-500 transition group">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h4 class="text-lg font-bold text-zinc-900 dark:text-white mb-2">Study Mode (Flashcards)</h4>
                    <p class="text-zinc-500 dark:text-zinc-400 text-sm mb-6">Review questions one-by-one with hidden answers. Perfect for active recall.</p>
                    <a href="{{ route('quizzes.study', $topic) }}" class="inline-flex items-center px-6 py-3 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 rounded-lg font-medium transition hover:opacity-90">
                        Start Studying
                    </a>
                </div>

                <!-- Quiz Mode -->
                <div class="border border-zinc-200 dark:border-zinc-800 rounded-xl p-6 hover:border-purple-500 dark:hover:border-purple-500 transition group">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 rounded-lg flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                    <h4 class="text-lg font-bold text-zinc-900 dark:text-white mb-2">Quiz Mode (Multiple Choice)</h4>
                    <p class="text-zinc-500 dark:text-zinc-400 text-sm mb-6">Test your knowledge with multiple choice options and get immediate results.</p>
                    <a href="{{ route('quizzes.quiz', $topic) }}" class="inline-flex items-center px-6 py-3 bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 rounded-lg font-medium transition hover:opacity-90">
                        Take Quiz
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
