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
                name: '',
                category: '',
                reference: ''
            },
            loading: false,
            async submitIdea() {
                if (this.loading) return;
                this.loading = true;
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
                        this.formData = {
                            user_name: '',
                            name: '',
                            category: '',
                            reference: ''
                        };
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
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="md:col-span-1">
                                <x-form.label for="user_name" value="Họ tên của bạn (Tùy chọn)" />
                                <x-form.input type="text" name="user_name" id="user_name"
                                    x-model="formData.user_name" placeholder="Ví dụ: Nguyễn Văn A" />
                            </div>
                            <div class="md:col-span-2">
                                <x-form.label for="name" value="Ý tưởng của bạn" :required="true" />
                                <x-form.input type="text" name="name" id="name" required
                                    x-model="formData.name"
                                    placeholder="Ví dụ: Hướng dẫn sử dụng React Query với Laravel" />
                            </div>
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
                            <x-form.button class="min-w-45" ::disabled="loading">
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
        async fetchIdeas(url = '{{ route('ideas.list') }}') {
            if (this.loading) return;
            this.loading = true;
            try {
                const response = await fetch(url);
                const html = await response.text();
                this.$refs.listContainer.innerHTML = html;
            } catch (error) {
                console.error('Error fetching ideas:', error);
                window.showToast('Không thể tải danh sách ý tưởng', 'error');
            } finally {
                this.loading = false;
            }
        },
        handlePagination(e) {
            const link = e.target.closest('.pagination a');
            if (link) {
                e.preventDefault();
                this.fetchIdeas(link.href);
                // Smooth scroll to top of list container
                window.scrollTo({
                    top: this.$el.offsetTop - 100,
                    behavior: 'smooth'
                });
            }
        }
    }" @idea-created.window="fetchIdeas()"
        @click="handlePagination($event)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-8 mb-16">
                <h2 class="text-3xl font-bold text-zinc-900 dark:text-white">
                    Danh sách ý tưởng
                </h2>
                <div class="h-px grow bg-zinc-100 dark:bg-zinc-800"></div>
                <div x-show="loading"
                    class="animate-spin size-5 border-2 border-primary-500 border-t-transparent rounded-full" x-cloak>
                </div>
            </div>

            <div x-ref="listContainer">
                @include('ideas.partials.list', ['ideas' => $ideas])
            </div>
        </div>
    </div>
</x-prezet.template>
