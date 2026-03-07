@php
    /* @var array $seo */
    /* @var object $document */
    /* @var string $body */
    /* @var \Illuminate\Support\Collection $docs */
@endphp

<x-prezet.template>
    @seo($seo)

    <x-prezet.subpage-header :title="'Danh mục: ' . $document->category" :subtitle="$document->frontmatter->excerpt" />

    <div class="py-12 lg:py-24">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-24">
                @foreach ($docs as $post)
                    <x-prezet.article :article="$post->data" :author="$post->author" :readingTime="$post->readingTime" />
                @endforeach
            </div>
        </div>
    </div>
</x-prezet.template>
