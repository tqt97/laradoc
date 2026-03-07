@php
    /* @var array $seo */
    /* @var object|null $snippet */
    /* @var string|null $code */
    /* @var string|null $slug */
@endphp

<x-prezet.template>
    @seo($seo)

    <x-prezet.subpage-header :title="$snippet ? 'Sửa Snippet' : 'Tạo Snippet mới'" subtitle="Quản lý các đoạn mã nguồn hữu ích." />

    <div class="py-12 lg:py-24">
        <div class="max-w-4xl mx-auto px-4">
            <div
                class="p-8 rounded-3xl bg-zinc-50 dark:bg-zinc-900/50 ring-1 ring-zinc-200 dark:ring-zinc-800 shadow-sm">
                <form action="{{ $snippet ? route('snippets.update', $slug) : route('snippets.store') }}" method="POST"
                    class="space-y-8">
                    @csrf
                    @if ($snippet)
                        @method('PUT')
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-widest text-zinc-500 ml-1">Tiêu đề</label>
                            <input type="text" name="title"
                                value="{{ old('title', $snippet?->frontmatter->title) }}" required
                                placeholder="Ví dụ: Laravel Eloquent scope"
                                class="w-full px-4 py-3 rounded-2xl bg-white dark:bg-zinc-950 border-zinc-200 dark:border-zinc-800 text-sm focus:ring-2 focus:ring-primary-500 transition-all outline-none dark:text-white" />
                        </div>

                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-widest text-zinc-500 ml-1">Ngôn
                                ngữ</label>
                            <select name="language" required
                                class="w-full px-4 py-3 rounded-2xl bg-white dark:bg-zinc-950 border-zinc-200 dark:border-zinc-800 text-sm focus:ring-2 focus:ring-primary-500 transition-all outline-none dark:text-white">
                                @foreach (config('prezet.snippet_languages') as $key => $lang)
                                    <option value="{{ $key }}" @selected(old('language', $snippet?->language) == $key)>
                                        {{ $lang['label'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-widest text-zinc-500 ml-1">Mô tả ngắn</label>
                        <input type="text" name="description"
                            value="{{ old('description', $snippet?->frontmatter->excerpt) }}"
                            placeholder="Mô tả tóm tắt về chức năng của snippet"
                            class="w-full px-4 py-3 rounded-2xl bg-white dark:bg-zinc-950 border-zinc-200 dark:border-zinc-800 text-sm focus:ring-2 focus:ring-primary-500 transition-all outline-none dark:text-white" />
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-widest text-zinc-500 ml-1">Mã nguồn</label>
                        <textarea name="code" rows="12" required placeholder="Dán mã nguồn của bạn vào đây..."
                            class="w-full px-4 py-3 rounded-2xl bg-white dark:bg-zinc-950 border-zinc-200 dark:border-zinc-800 text-sm font-mono focus:ring-2 focus:ring-primary-500 transition-all outline-none dark:text-white">{{ old('code', $code ?? '') }}</textarea>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-zinc-100 dark:border-zinc-800">
                        <a href="{{ $snippet ? route('snippets.show', $slug) : route('snippets.index') }}"
                            class="text-sm font-bold text-zinc-500 hover:text-zinc-900 dark:hover:text-white transition-colors">
                            Hủy bỏ
                        </a>

                        <button type="submit"
                            class="px-8 py-3 rounded-2xl bg-zinc-900 dark:bg-white text-white dark:text-zinc-900 font-bold text-sm shadow-xl hover:scale-[1.02] active:scale-[0.98] transition-all">
                            {{ $snippet ? 'Cập nhật Snippet' : 'Lưu Snippet' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-prezet.template>
