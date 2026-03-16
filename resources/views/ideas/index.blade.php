@php
    /* @var \Illuminate\Support\Collection $ideas */
    /* @var \Illuminate\Support\Collection $categories */
    /* @var array $seo */
@endphp

<x-prezet.template>
    @seo($seo)

    <x-prezet.subpage-header title="Đề xuất ý tưởng"
        subtitle="Bạn muốn chúng mình viết về chủ đề gì? Hãy để lại ý tưởng của bạn tại đây nhé.">
        <div class="mt-12 max-w-5xl mx-auto" x-data="{
            formData: {
                user_name: '',
                email: '',
                name: '',
                category: '',
                reference: ''
            },
            rememberEmail: false,
            loading: false,
            init() {
                const savedEmail = localStorage.getItem('idea_submitter_email');
                if (savedEmail) {
                    this.formData.email = savedEmail;
                    this.rememberEmail = true;
                }
                const savedName = localStorage.getItem('idea_submitter_name');
                if (savedName) {
                    this.formData.user_name = savedName;
                }
            },
            async submitIdea() {
                if (this.loading) return;
                this.loading = true;

                if (this.rememberEmail) {
                    localStorage.setItem('idea_submitter_email', this.formData.email);
                    localStorage.setItem('idea_submitter_name', this.formData.user_name);
                } else {
                    localStorage.removeItem('idea_submitter_email');
                    localStorage.removeItem('idea_submitter_name');
                }

                try {
                    const response = await fetch('{{ route('ideas.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify(this.formData)
                    });

                    const data = await response.json();

                    if (response.ok) {
                        window.showToast(data.message, 'success');
                        this.formData.name = '';
                        this.formData.category = '';
                        this.formData.reference = '';
                        if (!this.rememberEmail) {
                            this.formData.user_name = '';
                            this.formData.email = '';
                        }
                        // Refresh the list to show the newest idea
                        this.$dispatch('idea-created');
                    } else {
                        if (data.errors) {
                            const firstError = Object.values(data.errors)[0][0];
                            window.showToast(firstError, 'error');
                        } else {
                            window.showToast(data.message || 'Đã có lỗi xảy ra', 'error');
                        }
                    }
                } catch (error) {
                    window.showToast('Không thể kết nối đến máy chủ', 'error');
                } finally {
                    this.loading = false;
                }
            },
            setCategory(val) {
                const current = this.formData.category.split(',').map(c => c.trim()).filter(c => c !== '');
                if (!current.includes(val)) {
                    current.push(val);
                }
                this.formData.category = current.join(', ');
                this.$dispatch('category-selected');
            }
        }">
            <x-form.card>
                <form @submit.prevent="submitIdea()">
                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-form.label for="user_name" value="Họ tên của bạn (Tùy chọn)" />
                                <x-form.input type="text" name="user_name" id="user_name" x-model="formData.user_name"
                                    placeholder="Ví dụ: Nguyễn Văn A" />
                            </div>
                            <div>
                                <x-form.label for="email" value="Email của bạn (Để nhận cảm ơn)" />
                                <x-form.input type="email" name="email" id="email" x-model="formData.email"
                                    placeholder="email@example.com" />
                            </div>
                        </div>

                        <div class="flex items-center gap-2 px-1">
                            <input type="checkbox" id="remember_email" x-model="rememberEmail"
                                class="rounded border-zinc-300 text-primary-600 shadow-sm focus:ring-primary-500 dark:bg-zinc-800 dark:border-zinc-700">
                            <label for="remember_email"
                                class="text-xs font-medium text-zinc-500 dark:text-zinc-400 cursor-pointer">Ghi nhớ
                                thông tin cho lần sau</label>
                        </div>

                        <div>
                            <x-form.label for="name" value="Ý tưởng của bạn" :required="true" />
                            <x-form.textarea name="name" id="name" required x-model="formData.name"
                                rows="3" placeholder="Mô tả chi tiết ý tưởng của bạn tại đây..." />
                        </div>

                        <div x-data="{
                            open: false,
                            searchTerm: '',
                            get filteredCategories() {
                                let term = this.searchTerm.trim();
                                if (term.includes(',')) {
                                    term = term.split(',').pop().trim();
                                }
                                if (term === '') return @js($categories);
                                return @js($categories).filter(c => c.toLowerCase().includes(term.toLowerCase()));
                            }
                        }" @category-selected.window="searchTerm = ''; open = false"
                            class="relative">
                            <x-form.label for="category" value="Chủ đề/Danh mục (Cách nhau bằng dấu phẩy)" />
                            <div class="relative">
                                <x-form.input type="text" name="category" id="category" x-model="formData.category"
                                    @focus="open = true" @click.away="open = false"
                                    @input="searchTerm = $event.target.value" placeholder="Ví dụ: Laravel, Frontend..."
                                    autocomplete="off" />

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
                                                class="w-full text-left px-4 py-3 rounded-xl hover:bg-primary-50 hover:cursor-pointer dark:hover:bg-zinc-800 text-sm font-medium text-zinc-700 dark:text-zinc-300 transition-colors">
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
                        </div>

                        <div>
                            <x-form.label for="reference" value="Nguồn tham khảo (Cách nhau bằng dấu phẩy)" />
                            <x-form.input type="text" name="reference" id="reference" x-model="formData.reference"
                                placeholder="https://example.com/topic1, https://example.com/topic2" />
                        </div>

                        <div class="pt-4 flex justify-center">
                            <x-form.button class="min-w-[180px]" ::disabled="loading">
                                <span x-show="!loading" class="flex items-center gap-2">
                                    Gửi ý tưởng
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2.5" stroke="currentColor"
                                        class="size-4 transition-all duration-300 -rotate-45 group-hover:translate-x-1.5 group-hover:-translate-y-1.5 group-hover:scale-110">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                                    </svg>
                                </span>
                                <span x-show="loading" class="flex items-center gap-2">
                                    <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Đang gửi...
                                </span>
                            </x-form.button>
                        </div>
                    </div>
                </form>
            </x-form.card>
        </div>
    </x-prezet.subpage-header>

    <div class="py-24" id="ideas-list" x-data="{
        loading: false,
        selectedIdea: null,
        showModal: false,
        lastRequestId: 0,
        filters: {
            search: '',
            status: 'all',
            sort: 'latest',
            category: 'all'
        },
        hasFilters() {
            return this.filters.search !== '' || this.filters.status !== 'all' || this.filters.category !== 'all';
        },
        resetFilters() {
            this.filters.search = '';
            this.filters.status = 'all';
            this.filters.category = 'all';
            this.filters.sort = 'latest';
            this.fetchIdeas();
        },
        async fetchIdeas(url = null) {
            // Skip search if only 1 character is entered
            if (!url && this.filters.search.length > 0 && this.filters.search.length < 2) {
                return;
            }

            const requestId = ++this.lastRequestId;
            this.loading = true;

            if (!url) {
                const params = new URLSearchParams(this.filters);
                url = `{{ route('ideas.list') }}?${params.toString()}`;
            }

            try {
                const response = await fetch(url);
                const html = await response.text();

                // Only update if this is still the latest request
                if (requestId === this.lastRequestId) {
                    this.$refs.listContainer.innerHTML = html;
                }
            } catch (error) {
                if (requestId === this.lastRequestId) {
                    console.error('Error fetching ideas:', error);
                    window.showToast('Không thể tải danh sách ý tưởng', 'error');
                }
            } finally {
                if (requestId === this.lastRequestId) {
                    this.loading = false;
                }
            }
        },
        handlePagination(e) {
            const link = e.target.closest('.pagination a');
            if (link) {
                e.preventDefault();
                this.fetchIdeas(link.href);
                window.scrollTo({
                    top: this.$el.offsetTop - 100,
                    behavior: 'smooth'
                });
            }
        },
        async toggleVote(id) {
            try {
                const response = await fetch(`/ideas/${id}/vote`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                if (response.ok) {
                    window.showToast(data.message, 'success');
                    // Update vote count and button state in UI
                    const countEl = document.getElementById(`vote-count-${id}`);
                    const btnEl = document.getElementById(`vote-btn-${id}`);
                    const cardEl = document.getElementById(`idea-card-${id}`);

                    if (countEl) countEl.innerText = data.votes_count;
                    if (btnEl) {
                        if (data.is_voted) {
                            btnEl.classList.add('text-primary-500', 'bg-primary-50', 'dark:bg-primary-500/10');
                            btnEl.classList.remove('text-zinc-400');
                        } else {
                            btnEl.classList.remove('text-primary-500', 'bg-primary-50', 'dark:bg-primary-500/10');
                            btnEl.classList.add('text-zinc-400');
                        }
                    }

                    if (cardEl) {
                        if (data.is_voted) {
                            cardEl.classList.add('bg-primary-50/40', 'border-primary-100', 'dark:bg-primary-900/10', 'dark:border-primary-900/30');
                            cardEl.classList.remove('bg-zinc-50/80', 'border-zinc-100', 'dark:bg-zinc-900/50', 'dark:border-zinc-800');
                        } else {
                            cardEl.classList.remove('bg-primary-50/40', 'border-primary-100', 'dark:bg-primary-900/10', 'dark:border-primary-900/30');
                            cardEl.classList.add('bg-zinc-50/80', 'border-zinc-100', 'dark:bg-zinc-900/50', 'dark:border-zinc-800');
                        }
                    }
                } else {
                    window.showToast(data.message, 'error');
                }
            } catch (error) {
                window.showToast('Có lỗi xảy ra', 'error');
            }
        },
        openDetail(idea) {
            this.selectedIdea = idea;
            this.showModal = true;
        },
        async updateIdeaStatus(id, status) {
            try {
                const response = await fetch(`/ideas/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ status })
                });
                const data = await response.json();
                if (response.ok) {
                    window.showToast(data.message, 'success');
                    this.fetchIdeas();
                } else {
                    window.showToast(data.message, 'error');
                }
            } catch (error) {
                window.showToast('Có lỗi xảy ra', 'error');
            }
        },
        async deleteIdea(id) {
            if (!confirm('Bạn có chắc chắn muốn xóa ý tưởng này?')) return;
            try {
                const response = await fetch(`/ideas/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                const data = await response.json();
                if (response.ok) {
                    window.showToast(data.message, 'success');
                    this.fetchIdeas();
                } else {
                    window.showToast(data.message, 'error');
                }
            } catch (error) {
                window.showToast('Có lỗi xảy ra', 'error');
            }
        }
    }" @idea-created.window="fetchIdeas()"
        @click="handlePagination($event)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-8 mb-16">
                <div class="flex items-center gap-8">
                    <h2 class="text-3xl font-bold text-zinc-900 dark:text-white shrink-0">
                        Danh sách ý tưởng
                    </h2>
                    <div class="h-px grow bg-zinc-100 dark:bg-zinc-800 hidden sm:block"></div>
                </div>

                {{-- Filters --}}
                <div class="flex flex-wrap items-center justify-between gap-6">
                    <div class="flex flex-wrap items-center gap-4 grow">
                        <div class="relative w-full md:w-72">
                            <input type="text" x-model="filters.search" @input.debounce.750ms="fetchIdeas()"
                                placeholder="Tìm kiếm ý tưởng..."
                                class="w-full pl-10 pr-4 py-2.5 rounded-2xl bg-zinc-50 dark:bg-zinc-800 border-none focus:ring-2 focus:ring-primary-500 text-sm dark:text-white transition-all shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2" stroke="currentColor"
                                class="size-4 absolute left-4 top-1/2 -translate-y-1/2 text-zinc-400">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </div>

                        <div class="flex items-center gap-3 w-full sm:w-auto">
                            <select x-model="filters.status" @change="fetchIdeas()"
                                class="flex-1 sm:flex-none pl-4 pr-10 py-2.5 rounded-2xl bg-zinc-50 dark:bg-zinc-800 border-none focus:ring-2 focus:ring-primary-500 text-sm dark:text-white transition-all shadow-sm">
                                <option value="all">Tất cả trạng thái</option>
                                <option value="submitted">Đang chờ</option>
                                <option value="published">Đã đăng</option>
                            </select>

                            <select x-model="filters.sort" @change="fetchIdeas()"
                                class="flex-1 sm:flex-none pl-4 pr-10 py-2.5 rounded-2xl bg-zinc-50 dark:bg-zinc-800 border-none focus:ring-2 focus:ring-primary-500 text-sm dark:text-white transition-all shadow-sm">
                                <option value="latest">Mới nhất</option>
                                <option value="top">Nổi bật nhất</option>
                                <option value="oldest">Cũ nhất</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <button x-show="hasFilters()" @click="resetFilters()" x-cloak
                            class="px-4 py-2.5 rounded-2xl bg-red-50 dark:bg-red-500/10 text-red-600 dark:text-red-400 text-xs font-bold hover:bg-red-100 dark:hover:bg-red-500/20 transition-all flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor" class="size-3.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                            Xóa bộ lọc
                        </button>

                        <div class="w-6 h-6 flex items-center justify-center">
                            <div x-show="loading" x-transition:enter="transition opacity duration-300"
                                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                x-transition:leave="transition opacity duration-300"
                                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                class="animate-spin size-5 border-2 border-primary-500 border-t-transparent rounded-full"
                                x-cloak></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="relative min-h-[400px]">
                {{-- Progress bar overlay --}}
                <div
                    class="absolute top-0 left-0 w-full h-0.5 bg-transparent overflow-hidden z-10 pointer-events-none">
                    <div x-show="loading" x-transition:enter="transition opacity duration-300"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                        x-transition:leave="transition opacity duration-500" x-transition:leave-start="opacity-100"
                        x-transition:leave-end="opacity-0" class="h-full bg-primary-500 animate-shimmer"
                        style="width: 100%; background: linear-gradient(to right, transparent, var(--color-primary-500), transparent); background-size: 200% 100%;"
                        x-cloak></div>
                </div>

                <div x-ref="listContainer" :class="loading ? 'opacity-50 pointer-events-none' : 'opacity-100'"
                    class="transition-opacity duration-300">
                    @include('ideas.partials.list', ['ideas' => $ideas])
                </div>
            </div>
        </div>

        {{-- Detail Modal --}}
        <div x-show="showModal" class="fixed inset-0 z-[100] flex items-center justify-center p-4 sm:p-6" x-cloak>
            <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0" class="absolute inset-0 bg-zinc-950/60 backdrop-blur-sm"
                @click="showModal = false"></div>

            <div x-show="showModal" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                class="relative w-full max-w-2xl bg-white dark:bg-zinc-900 rounded-3xl shadow-2xl overflow-hidden border border-zinc-200 dark:border-zinc-800">

                <div class="p-8 sm:p-10 max-h-[85vh] overflow-y-auto custom-scrollbar">
                    <div
                        class="flex justify-between items-start mb-6 sticky top-0 bg-white dark:bg-zinc-900 z-10 -mt-2 pt-2">
                        <div class="flex flex-wrap gap-2">
                            <template x-if="selectedIdea?.category">
                                <template x-for="cat in selectedIdea.category.split(',')" :key="cat">
                                    <span
                                        class="px-2.5 py-1 rounded-xl bg-primary-50 dark:bg-primary-900/20 text-[10px] font-bold text-primary-600 dark:text-primary-400 ring-1 ring-primary-100 dark:ring-primary-900/30"
                                        x-text="cat.trim()"></span>
                                </template>
                            </template>
                        </div>
                        <button @click="showModal = false"
                            class="text-zinc-400 hover:text-zinc-600 dark:hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <h3 class="text-2xl font-bold text-zinc-900 dark:text-white mb-6 leading-tight whitespace-pre-wrap break-words"
                        x-text="selectedIdea?.name"></h3>

                    <div class="grid grid-cols-2 gap-8 py-6 border-y border-zinc-100 dark:border-zinc-800 mb-8">
                        <div class="space-y-1">
                            <p class="text-[10px] font-black uppercase tracking-widest text-zinc-400">Đề xuất bởi</p>
                            <p class="font-bold text-zinc-700 dark:text-zinc-300 break-words"
                                x-text="selectedIdea?.user_name || 'Ẩn danh'"></p>
                            <p class="text-xs text-zinc-500 break-all" x-text="selectedIdea?.email"></p>
                        </div>
                        <div class="space-y-1 text-right">
                            <p class="text-[10px] font-black uppercase tracking-widest text-zinc-400">Ngày gửi</p>
                            <p class="font-bold text-zinc-700 dark:text-zinc-300"
                                x-text="selectedIdea?.formatted_date"></p>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <template x-if="selectedIdea?.reference">
                            <div class="space-y-3">
                                <p class="text-[10px] font-black uppercase tracking-widest text-zinc-400">Nguồn tham
                                    khảo</p>
                                <div class="flex flex-wrap gap-3">
                                    <template x-for="ref in selectedIdea.reference.split(',')" :key="ref">
                                        <template x-if="ref.trim().startsWith('http')">
                                            <a :href="ref.trim()" target="_blank"
                                                class="inline-flex items-center gap-2 px-4 py-2 rounded-2xl bg-zinc-50 dark:bg-zinc-800 text-xs font-bold text-zinc-600 dark:text-zinc-400 hover:bg-primary-500 hover:text-white transition-all max-w-full overflow-hidden">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    class="size-4 shrink-0">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M13.19 8.688a4.5 4.5 0 0 1 1.242 7.244l-4.5 4.5a4.5 4.5 0 0 1-6.364-6.364l1.757-1.757m13.35-.622 1.757-1.757a4.5 4.5 0 0 0-6.364-6.364l-4.5 4.5a4.5 4.5 0 0 0 1.242 7.244" />
                                                </svg>
                                                <span class="truncate" x-text="new URL(ref.trim()).hostname"></span>
                                            </a>
                                        </template>
                                        <template x-if="!ref.trim().startsWith('http')">
                                            <span
                                                class="px-4 py-2 rounded-2xl bg-zinc-50 dark:bg-zinc-800 text-xs font-bold text-zinc-500 break-words"
                                                x-text="ref.trim()"></span>
                                        </template>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="mt-10 flex justify-center sticky bottom-0 bg-white dark:bg-zinc-900 pb-2 pt-4">
                        <button @click="toggleVote(selectedIdea.id); showModal = false"
                            class="inline-flex items-center gap-3 px-8 py-4 rounded-full bg-primary-500 text-white font-bold hover:bg-primary-600 transition-all shadow-xl shadow-primary-500/20 active:scale-95 hover:cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="2.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>
                            <span x-text="selectedIdea?.is_voted ? 'Bỏ bình chọn' : 'Bình chọn ý tưởng này'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-prezet.template>
