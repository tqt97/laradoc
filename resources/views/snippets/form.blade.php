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
            <x-form.card>
                <form action="{{ $snippet ? route('snippets.update', $slug) : route('snippets.store') }}" method="POST"
                    class="space-y-6">
                    @csrf
                    @if ($snippet)
                        @method('PUT')
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-form.label value="Tiêu đề" />
                            <x-form.input type="text" name="title"
                                value="{{ old('title', $snippet?->frontmatter->title) }}" required
                                placeholder="Ví dụ: Laravel Eloquent scope" :error="$errors->first('title')" />
                        </div>

                        <div>
                            <x-form.label value="Ngôn ngữ" />
                            <x-form.select name="language" required :error="$errors->first('language')">
                                @foreach (config('prezet.snippet_languages') as $key => $lang)
                                    <option value="{{ $key }}" @selected(old('language', $snippet?->language) == $key)>
                                        {{ $lang['label'] }}
                                    </option>
                                @endforeach
                            </x-form.select>
                        </div>
                    </div>

                    <div>
                        <x-form.label value="Mô tả ngắn" />
                        <x-form.input type="text" name="description"
                            value="{{ old('description', $snippet?->frontmatter->excerpt) }}"
                            placeholder="Mô tả tóm tắt về chức năng của snippet" :error="$errors->first('description')" />
                    </div>

                    <div>
                        <x-form.label value="Mã nguồn" />
                        <x-form.textarea name="code" rows="12" required placeholder="Dán mã nguồn của bạn vào đây..."
                            class="font-mono" :error="$errors->first('code')">{{ old('code', $code ?? '') }}</x-form.textarea>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t border-zinc-100 dark:border-zinc-800/50">
                        <x-form.button type="button" variant="secondary" onclick="window.location='{{ $snippet ? route('snippets.show', $slug) : route('snippets.index') }}'" class="!px-8 !py-2">
                            Hủy bỏ
                        </x-form.button>

                        <x-form.button>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                stroke="currentColor" class="size-4 transition-transform duration-300">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                            </svg>
                            {{ $snippet ? 'Cập nhật Snippet' : 'Lưu Snippet' }}
                        </x-form.button>
                    </div>
                </form>
            </x-form.card>
        </div>
    </div>
</x-prezet.template>
