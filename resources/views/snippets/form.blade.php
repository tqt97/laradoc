<x-prezet.template>
    @seo([
        'title' => ($snippet ? 'Sửa Snippet' : 'Tạo Snippet mới') . ' - TuanTQ',
        'description' => 'Quản lý các đoạn mã nguồn hữu ích.',
    ])

    <div id="articles" class="py-12 lg:py-24">
        <div class="max-w-4xl mx-auto px-4">
            <nav class="mb-12">
                <a href="{{ $snippet ? route('snippets.show', $slug) : route('snippets.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-bold text-zinc-500 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-white transition-colors group">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                        stroke="currentColor" class="size-4 group-hover:-translate-x-1 transition-transform">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                    </svg>
                    Quay lại
                </a>
            </nav>

            <header class="mb-12">
                <h1 class="text-4xl font-bold tracking-tight text-zinc-900 dark:text-white">
                    {{ $snippet ? 'Chỉnh sửa Snippet' : 'Tạo Snippet mới' }}
                </h1>
                <p class="mt-4 text-lg text-zinc-500 dark:text-zinc-400">
                    {{ $snippet ? 'Cập nhật lại đoạn mã nguồn và thông tin mô tả.' : 'Lưu lại đoạn mã hữu ích để bạn có thể dễ dàng tìm lại và sử dụng sau này.' }}
                </p>
            </header>

            <div class="p-8 rounded-3xl bg-zinc-50 dark:bg-zinc-900/50 ring-1 ring-zinc-200 dark:ring-zinc-800 shadow-sm"
                hx-boost="false">
                <form action="{{ $snippet ? route('snippets.update', $slug) : route('snippets.store') }}" method="POST"
                    class="space-y-8">
                    @csrf
                    @if ($snippet)
                        @method('PUT')
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label for="title" class="text-sm font-bold text-zinc-700 dark:text-zinc-300 ml-1">Tiêu
                                đề *</label>
                            <input type="text" name="title" id="title" required
                                value="{{ old('title', $snippet ? $snippet->frontmatter->title : '') }}"
                                placeholder="Ví dụ: Laravel Eloquent scope"
                                class="w-full px-4 py-3 rounded-2xl bg-white dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700 text-sm focus:ring-2 focus:ring-primary-500 transition-all outline-none dark:text-white" />
                            @error('title')
                                <p class="text-xs text-red-500 font-medium ml-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2">
                            <label for="language" class="text-sm font-bold text-zinc-700 dark:text-zinc-300 ml-1">Ngôn
                                ngữ *</label>
                            <select name="language" id="language" required
                                class="w-full px-4 py-3 rounded-2xl bg-white dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700 text-sm focus:ring-2 focus:ring-primary-500 transition-all outline-none dark:text-white appearance-none">
                                @foreach (['php', 'javascript', 'html', 'css', 'sql', 'bash', 'json', 'markdown', 'python', 'yaml'] as $lang)
                                    <option value="{{ $lang }}"
                                        {{ old('language', $snippet ? $snippet->frontmatter->language : 'php') == $lang ? 'selected' : '' }}>
                                        {{ strtoupper($lang) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('language')
                                <p class="text-xs text-red-500 font-medium ml-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label for="description" class="text-sm font-bold text-zinc-700 dark:text-zinc-300 ml-1">Mô tả
                            ngắn</label>
                        <input type="text" name="description" id="description"
                            value="{{ old('description', $snippet ? $snippet->frontmatter->excerpt : '') }}"
                            placeholder="Mô tả công dụng của đoạn mã này..."
                            class="w-full px-4 py-3 rounded-2xl bg-white dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700 text-sm focus:ring-2 focus:ring-primary-500 transition-all outline-none dark:text-white" />
                        @error('description')
                            <p class="text-xs text-red-500 font-medium ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="code" class="text-sm font-bold text-zinc-700 dark:text-zinc-300 ml-1">Mã nguồn
                            (Code) *</label>
                        <textarea name="code" id="code" rows="12" required placeholder="// Dán mã nguồn của bạn vào đây..."
                            class="w-full px-6 py-5 rounded-3xl bg-white dark:bg-zinc-800 border-zinc-200 dark:border-zinc-700 text-sm font-mono focus:ring-2 focus:ring-primary-500 transition-all outline-none dark:text-white leading-relaxed">{{ old('code', $code ?? '') }}</textarea>
                        @error('code')
                            <p class="text-xs text-red-500 font-medium ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end gap-4 pt-4">
                        <a href="{{ $snippet ? route('snippets.show', $slug) : route('snippets.index') }}"
                            class="px-8 py-4 rounded-2xl border border-zinc-200 dark:border-zinc-700 text-zinc-600 dark:text-zinc-400 font-bold text-sm hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-all">
                            Hủy bỏ
                        </a>

                        @if (!$snippet)
                            <button type="submit" name="continue" value="1"
                                class="px-8 py-4 rounded-2xl border-2 border-zinc-900 dark:border-white text-zinc-900 dark:text-white font-bold text-sm hover:bg-zinc-900 hover:text-white dark:hover:bg-white dark:hover:text-zinc-900 transition-all">
                                Lưu và thêm mới
                            </button>
                        @endif

                        <button type="submit"
                            class="px-10 py-4 rounded-2xl bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 font-bold text-sm shadow-xl hover:scale-[1.02] active:scale-[0.98] transition-all">
                            {{ $snippet ? 'Cập nhật Snippet' : 'Lưu Snippet' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-prezet.template>
