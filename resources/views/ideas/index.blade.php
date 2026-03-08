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
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1">
                            <label for="user_name" class="block text-sm text-left font-bold text-zinc-700 dark:text-zinc-300 mb-2">Họ tên của bạn (Tùy chọn)</label>
                            <input type="text" name="user_name" id="user_name"
                                placeholder="Ví dụ: Nguyễn Văn A"
                                class="w-full rounded-3xl bg-zinc-50 dark:bg-zinc-800 border-none focus:ring-2 focus:ring-primary-500 text-sm py-3 px-4 dark:text-white dark:placeholder:text-zinc-500" />
                            @error('user_name')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label for="name" class="block text-sm text-left font-bold text-zinc-700 dark:text-zinc-300 mb-2">Ý
                                tưởng của bạn *</label>
                            <input type="text" name="name" id="name" required
                                placeholder="Ví dụ: Hướng dẫn sử dụng React Query với Laravel"
                                class="w-full rounded-3xl bg-zinc-50 dark:bg-zinc-800 border-none focus:ring-2 focus:ring-primary-500 text-sm py-3 px-4 dark:text-white dark:placeholder:text-zinc-500" />
                            @error('name')
                                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div x-data="{
                        open: false,
                        searchTerm: '',
                        setCategory(val) {
                            const current = $refs.categoryInput.value.trim();
                            if (current) {
                                // If already has content, append with comma
                                const categories = current.split(',').map(c => c.trim());
                                if (!categories.includes(val)) {
                                    $refs.categoryInput.value = current + ', ' + val;
                                }
                            } else {
                                $refs.categoryInput.value = val;
                            }
                            this.searchTerm = '';
                            this.open = false;
                        },
                        get filteredCategories() {
                            if (this.searchTerm === '') return @js($categories);
                            return @js($categories).filter(c => c.toLowerCase().includes(this.searchTerm.toLowerCase()));
                        }
                    }" class="relative">
                        <label for="category"
                            class="block text-sm font-bold text-zinc-700 dark:text-zinc-300 mb-2 text-left">
                            Chủ đề/Danh mục (Cách nhau bằng dấu phẩy)
                        </label>
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
                                            class="w-full text-left px-4 py-3 rounded-xl hover:bg-zinc-50 dark:hover:bg-zinc-800 text-sm font-medium text-zinc-700 dark:text-zinc-300 transition-colors">
                                            <span x-text="cat"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>

                        @if ($categories->isNotEmpty())
                            <div class="mt-4">
                                <p
                                    class="text-[10px] font-black uppercase tracking-widest text-zinc-400 mb-2 text-left ml-1">
                                    Gợi ý nhanh</p>
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($categories->take(10) as $cat)
                                        <button type="button" @click="setCategory('{{ $cat }}')"
                                            class="px-3 py-1.5 rounded-3xl bg-zinc-100 dark:bg-zinc-800 text-[10px] font-bold text-zinc-500 dark:text-zinc-400 hover:bg-primary-500 hover:text-white transition-all">
                                            {{ $cat }}
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
                            khảo (Cách nhau bằng dấu phẩy)</label>
                        <input type="text" name="reference" id="reference"
                            placeholder="https://example.com/topic1, https://example.com/topic2"
                            class="w-full rounded-3xl bg-zinc-50 dark:bg-zinc-800 border-none focus:ring-2 focus:ring-primary-500 text-sm py-3 px-4 dark:text-white dark:placeholder:text-zinc-500" />
                        @error('reference')
                            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 flex justify-center">
                        <button type="submit"
                            class="bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 font-bold py-3 px-12 rounded-3xl transition-all shadow-lg shadow-zinc-900/10 dark:shadow-none hover:cursor-pointer hover:bg-primary-600">
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

            <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
                @forelse($ideas as $idea)
                    <div
                        class="group relative flex flex-col rounded-3xl bg-zinc-50/50 dark:bg-zinc-900/50 border border-zinc-100 dark:border-zinc-800 transition-all duration-500 hover:bg-white dark:hover:bg-zinc-900 hover:shadow-sm hover:shadow-primary-500/5 overflow-hidden">

                        <div class="p-8 flex flex-col h-full space-y-6">
                            {{-- Header: Title & Status --}}
                            <div class="flex items-start justify-between gap-4">
                                <h3
                                    class="text-2xl font-bold text-zinc-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors leading-tight">
                                    {{ $idea->name }}
                                </h3>
                                <span @class([
                                    'shrink-0 px-2.5 py-1 rounded-full text-[9px] font-black uppercase tracking-widest ring-1 mt-1',
                                    'bg-primary-50 text-primary-600 ring-primary-200 dark:bg-primary-900/20 dark:text-primary-400 dark:ring-primary-800' =>
                                        $idea->status === 'submitted',
                                    'bg-emerald-50 text-emerald-600 ring-emerald-200 dark:bg-emerald-900/20 dark:text-emerald-400 dark:ring-emerald-800' =>
                                        $idea->status === 'published',
                                ])>
                                    {{ $idea->status === 'submitted' ? 'Đang chờ' : 'Đã đăng' }}
                                </span>
                            </div>

                            {{-- Categories: Full width wrapping --}}
                            @if ($idea->category)
                                <div class="flex flex-wrap gap-2">
                                    @foreach (explode(',', $idea->category) as $cat)
                                        <span
                                            class="px-2.5 py-1 rounded-xl bg-white dark:bg-zinc-800 text-[10px] font-bold uppercase tracking-wider text-zinc-500 dark:text-zinc-400 ring-1 ring-zinc-200 dark:ring-zinc-700">
                                            {{ trim($cat) }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            {{-- Submitter & Meta --}}
                            <div
                                class="flex flex-wrap items-center justify-between gap-4 py-4 border-y border-zinc-100 dark:border-zinc-800/50">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="size-8 rounded-full bg-zinc-100 dark:bg-zinc-800 flex items-center justify-center text-zinc-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                        </svg>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-[9px] font-black uppercase tracking-widest text-zinc-400">Đề
                                            xuất bởi</span>
                                        <span class="text-xs font-bold text-zinc-700 dark:text-zinc-300">
                                            {{ $idea->user_name ?: 'Ẩn danh' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="flex flex-col text-right">
                                    <span class="text-[9px] font-black uppercase tracking-widest text-zinc-400">Ngày
                                        gửi</span>
                                    <span class="text-xs font-bold text-zinc-500 dark:text-zinc-400">
                                        {{ $idea->created_at->format('d/m/Y') }}
                                    </span>
                                </div>
                            </div>

                            {{-- References --}}
                            @if ($idea->reference)
                                <div class="space-y-3">
                                    <p class="text-[10px] font-black uppercase tracking-widest text-zinc-400">Nguồn tham
                                        khảo</p>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach (explode(',', $idea->reference) as $ref)
                                            @php $trimmedRef = trim($ref); @endphp
                                            @if (filter_var($trimmedRef, FILTER_VALIDATE_URL))
                                                <a href="{{ $trimmedRef }}" target="_blank"
                                                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-primary-50/50 dark:bg-primary-900/10 text-[10px] font-bold text-primary-600 dark:text-primary-400 border border-primary-100 dark:border-primary-900/30 hover:bg-primary-500 hover:text-white dark:hover:bg-primary-500 dark:hover:text-white transition-all max-w-45">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"
                                                        class="size-3">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                                                    </svg>
                                                    <span
                                                        class="truncate">{{ parse_url($trimmedRef, PHP_URL_HOST) ?: $trimmedRef }}</span>
                                                </a>
                                            @else
                                                <span
                                                    class="text-[10px] font-bold text-zinc-500 italic bg-zinc-100/50 dark:bg-zinc-800/50 px-3 py-1.5 rounded-xl border border-zinc-200 dark:border-zinc-700">{{ $trimmedRef }}</span>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-full text-center py-20 bg-zinc-50/50 dark:bg-zinc-900/50 rounded-3xl border border-dashed border-zinc-200 dark:border-zinc-800">
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
