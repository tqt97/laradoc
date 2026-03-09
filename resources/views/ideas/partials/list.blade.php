<div class="space-y-4">
    @forelse($ideas as $idea)
        <div id="idea-card-{{ $idea->id }}" @class([
            'group relative flex flex-col md:flex-row items-center gap-6 p-6 rounded-3xl border transition-all duration-300 hover:shadow-xl hover:shadow-primary-500/5 overflow-hidden',
            'bg-primary-50/40 border-primary-100 dark:bg-primary-900/10 dark:border-primary-900/30' =>
                $idea->is_voted,
            'bg-zinc-50/80 border-zinc-100 dark:bg-zinc-900/50 dark:border-zinc-800' => !$idea->is_voted,
        ])>

            {{-- Vote Section --}}
            <div
                class="flex flex-col items-center justify-center p-2 rounded-2xl bg-zinc-50 dark:bg-zinc-800/50 min-w-[70px]">
                <button id="vote-btn-{{ $idea->id }}" @click="toggleVote({{ $idea->id }})"
                    @class([
                        'p-2 rounded-xl transition-all active:scale-90 hover:cursor-pointer',
                        'text-primary-500 bg-primary-50 dark:bg-primary-500/10' => $idea->is_voted,
                        'text-zinc-400 hover:text-primary-500 hover:bg-primary-50 dark:hover:bg-primary-500/10' => !$idea->is_voted,
                    ])>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                    </svg>
                </button>
                <span id="vote-count-{{ $idea->id }}" class="text-lg font-black text-zinc-700 dark:text-zinc-200">
                    {{ $idea->votes_count }}
                </span>
            </div>

            {{-- Info Section --}}
            <div class="flex-grow min-w-0 space-y-2 cursor-pointer"
                @click="openDetail({{ json_encode(array_merge($idea->toArray(), ['formatted_date' => $idea->created_at->format('d/m/Y'), 'is_voted' => $idea->is_voted])) }})">
                <div class="flex flex-wrap items-center gap-3">
                    <h3
                        class="text-lg font-bold text-zinc-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors leading-tight truncate max-w-4xl whitespace-pre-wrap1 text-left">
                        {{ trim(Str::limit($idea->name, 100)) }}</h3>
                </div>
                @if ($idea->category)
                    <div class="flex flex-wrap gap-1">
                        @foreach (explode(',', $idea->category) as $cat)
                            <span
                                class="px-2 py-0.5 rounded-lg bg-zinc-100 dark:bg-zinc-800 text-[9px] font-black uppercase tracking-wider text-zinc-500 dark:text-zinc-400">
                                {{ trim($cat) }}
                            </span>
                        @endforeach
                    </div>
                @endif

                <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-[11px] font-bold text-zinc-400">
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="size-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                        <span class="text-zinc-600 dark:text-zinc-300">{{ $idea->user_name ?: 'Ẩn danh' }}</span>
                        @if ($idea->email)
                            <span class="opacity-50">•</span>
                            <span>{{ $idea->email }}</span>
                        @endif
                    </div>
                    <div class="flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="size-3.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span>{{ $idea->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Action Section --}}
            <div class="flex items-center gap-4 shrink-0">
                <button
                    @click="openDetail({{ json_encode(array_merge($idea->toArray(), ['formatted_date' => $idea->created_at->format('d/m/Y'), 'is_voted' => $idea->is_voted])) }})"
                    class="px-4 py-2 rounded-2xl bg-zinc-50 dark:bg-zinc-800 text-xs font-bold text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-all hover:cursor-pointer">
                    Chi tiết
                </button>
                <span @class([
                    'px-2.5 py-1 rounded-full text-[9px] font-black uppercase tracking-widest ring-1',
                    'bg-primary-50 text-primary-600 ring-primary-200 dark:bg-primary-900/20 dark:text-primary-400 dark:ring-primary-800' =>
                        $idea->status === 'submitted',
                    'bg-emerald-50 text-emerald-600 ring-emerald-200 dark:bg-emerald-900/20 dark:text-emerald-400 dark:ring-emerald-800' =>
                        $idea->status === 'published',
                ])>
                    {{ $idea->status === 'submitted' ? 'Đang chờ' : 'Đã đăng' }}
                </span>
            </div>
        </div>
    @empty
        <div
            class="col-span-full text-center py-20 bg-white dark:bg-zinc-900 rounded-3xl border border-dashed border-zinc-200 dark:border-zinc-800">
            <p class="text-zinc-500 dark:text-zinc-400 font-medium italic">Không tìm thấy ý tưởng nào phù hợp.</p>
        </div>
    @endforelse
</div>

@if ($ideas->hasPages())
    <div class="mt-16">
        {{ $ideas->links() }}
    </div>
@endif
