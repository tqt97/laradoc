@php
    /* @var string $body */
    /* @var \Prezet\Prezet\Data\DocumentData $document */
    /* @var \Illuminate\Support\Collection<int,object> $docs */
@endphp

<x-prezet.template>
    @seo([
        'title' => $document->frontmatter->title,
        'description' => $document->frontmatter->excerpt,
        'url' => route('prezet.show', ['slug' => $document->slug]),
        'image' => $document->frontmatter->image ? url($document->frontmatter->image) : null,
    ])

    <div id="articles-content" class="container mx-auto px-4 py-12">
        <div class="mb-12 text-center">
            <h1 class="text-4xl font-extrabold tracking-tight text-zinc-900 sm:text-5xl dark:text-white">
                {{ $document->frontmatter->title }}
            </h1>
            @if($document->frontmatter->excerpt)
                <p class="mt-4 text-xl text-zinc-600 dark:text-zinc-400 max-w-2xl mx-auto leading-relaxed">
                    {{ $document->frontmatter->excerpt }}
                </p>
            @endif
        </div>

        @if($body)
            <article class="prose prose-zinc dark:prose-invert max-w-none mb-16 pb-12 border-b border-zinc-200 dark:border-zinc-800">
                {!! $body !!}
            </article>
        @endif

        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
            @foreach ($docs as $doc)
                <x-prezet.article :article="$doc->data" :author="$doc->author" />
            @endforeach
        </div>
    </div>
</x-prezet.template>
