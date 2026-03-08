@php
    /* @var \Illuminate\Support\Collection $ideas */
    /* @var \Illuminate\Support\Collection $categories */
    /* @var array $seo */
@endphp

<x-prezet.template>
    @seo($seo)

    <x-prezet.subpage-header title="Đề xuất chủ đề"
        subtitle="Bạn muốn chúng mình viết về chủ đề gì? Hãy để lại ý tưởng của bạn tại đây nhé.">
        <div class="mt-12 max-w-5xl mx-auto">
            <form action="{{ route('ideas.store') }}" method="POST"
                class="bg-white dark:bg-zinc-900 p-8 rounded-3xl shadow-xl ring-1 ring-zinc-900/5 dark:ring-white/10">
                @csrf
                <div class="space-y-6">
                    <div>
                        <label for="name"
                            class="block text-sm text-left font-bold text-zinc-700 dark:text-zinc-300 mb-2">Ý
                            tưởng của bạn <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" required
                            placeholder="Ví dụ: Hướng dẫn sử dụng React Query với Laravel"
                            class="w-full rounded-3xl bg-zinc-50 dark:bg-zinc-800 border-none focus:ring-2 focus:ring-primary-500 text-sm py-3 px-4 dark:text-white dark:placeholder:text-zinc-500" />
                        @error('name')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div x-data="{
                        open: false,
                        searchTerm: '',
                        setCategory(val) {
                            $refs.categoryInput.value = val;
                            this.searchTerm = val;
                            this.open = false;
                        },
                        get filteredCategories() {
                            if (this.searchTerm === '') return @js($categories);
                            return @js($categories).filter(c => c.toLowerCase().includes(this.searchTerm.toLowerCase()));
                        }
                    }" class="relative">
                        <label for="category"
                            class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-2 text-left">Chủ đề/Danh
                            mục</label>
                        <div class="relative">
                            <input type="text" name="category" id="category" x-ref="categoryInput"
                                x-model="searchTerm" @focus="open = true" @click.away="open = false"
                                placeholder="Ví dụ: Laravel, Frontend..." autocomplete="off"
                                class="w-full rounded-3xl bg-zinc-50 dark:bg-zinc-800 border-none focus:ring-2 focus:ring-primary-500 text-sm py-3 px-4 dark:text-white dark:placeholder:text-zinc-500" />

                            {{-- Custom Dropdown --}}
                            <div x-show="open && filteredCategories.length > 0"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 translate-y-1"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                class="absolute z-50 mt-2 w-full bg-white dark:bg-zinc-900 rounded-3xl shadow-2xl ring-1 ring-zinc-200 dark:ring-zinc-800 overflow-hidden"
                                x-cloak>
                                <div
                                    class="max-h-48 overflow-y-auto p-2 scrollbar-thin scrollbar-thumb-zinc-200 dark:scrollbar-thumb-zinc-800">
                                    <template x-for="cat in filteredCategories" :key="cat">
                                        <button type="button" @click="setCategory(cat)"
                                            class="w-full text-left px-4 py-3 rounded-3xl hover:bg-zinc-50 dark:hover:bg-zinc-800 text-sm font-medium text-zinc-700 dark:text-zinc-300 transition-colors">
                                            <span x-text="cat"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>

                        @if ($categories->isNotEmpty())
                            <div class="mt-4">
                                <p
                                    class="text-[11px] font-bold uppercase1 tracking-widest1 text-zinc-500 mb-2 text-left ml-1">
                                    Gợi ý nhanh</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($categories as $category)
                                        <button type="button" @click="setCategory('{{ $category }}')"
                                            class="px-3 py-1.5 rounded-3xl bg-zinc-100 dark:bg-zinc-800 text-[10px] font-semibold text-zinc-600 dark:text-zinc-400 hover:bg-primary-500 hover:text-white transition-all hover:cursor-pointer">
                                            {{ $category }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @error('category')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="reference"
                            class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-2 text-left">Nguồn tham
                            khảo
                            (URL)</label>
                        <input type="url" name="reference" id="reference" placeholder="https://example.com/topic"
                            class="w-full rounded-3xl bg-zinc-50 dark:bg-zinc-800 border-none focus:ring-2 focus:ring-primary-500 text-sm py-3 px-4 dark:text-white dark:placeholder:text-zinc-500" />
                        @error('reference')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 flex justify-center">
                        <button type="submit"
                            class="bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 font-bold py-4 px-12 rounded-3xl hover:scale-[1.02] active:scale-[0.98] transition-all shadow-lg shadow-zinc-900/10 dark:shadow-none hover:cursor-pointer hover:bg-primary-600">
                            Gửi ý tưởng
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </x-prezet.subpage-header>

    <div class="py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-8 mb-16">
                <h2 class="text-3xl font-black text-zinc-900 dark:text-white tracking-tighter uppercase">
                    Danh sách ý tưởng
                </h2>
                <div class="h-px flex-grow bg-zinc-100 dark:bg-zinc-800"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($ideas as $idea)
                    <div
                        class="bg-zinc-50/50 dark:bg-zinc-900/50 rounded-3xl p-8 border border-zinc-100 dark:border-zinc-800 group hover:bg-white dark:hover:bg-zinc-900 transition-all duration-300">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-3">
                                    @if ($idea->category)
                                        <span
                                            class="px-2.5 py-1 rounded-3xl bg-zinc-100 dark:bg-zinc-800 text-[10px] font-black uppercase tracking-widest text-zinc-500 dark:text-zinc-400">
                                            {{ $idea->category }}
                                        </span>
                                    @endif
                                    <span @class([
                                        'px-2.5 py-1 rounded-3xl text-[10px] font-black uppercase tracking-widest',
                                        'bg-primary-50 text-primary-600 dark:bg-primary-900/30 dark:text-primary-400' =>
                                            $idea->status === 'submitted',
                                        'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400' =>
                                            $idea->status === 'published',
                                    ])>
                                        {{ $idea->status === 'submitted' ? 'Đã gửi' : 'Đã đăng' }}
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold text-zinc-900 dark:text-white mb-2">
                                    {{ $idea->name }}
                                </h3>
                                @if ($idea->reference)
                                    <a href="{{ $idea->reference }}" target="_blank"
                                        class="inline-flex items-center gap-2 text-sm font-medium text-zinc-400 hover:text-primary-500 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                                        </svg>
                                        Nguồn tham khảo
                                    </a>
                                @endif
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-medium text-zinc-400">
                                    Gửi vào {{ $idea->created_at->format('d/m/Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="text-center py-20 bg-zinc-50/50 dark:bg-zinc-900/50 rounded-3xl border border-dashed border-zinc-200 dark:border-zinc-800">
                        <p class="text-zinc-500 dark:text-zinc-400 font-medium italic">Chưa có ý tưởng nào được đóng
                            góp. Hãy là người đầu tiên!</p>
                    </div>
                @endforelse
            </div>

            @if ($ideas->hasPages())
                <div class="mt-16">
                    {{ $ideas->links() }}
                </div>
            @endif
        </div>
    </div>
</x-prezet.template>
