@php
    /* @var object $knowledge */
    /* @var string $body */
@endphp

<x-prezet.template>
    @seo($seo)

    <div class="max-w-7xl mx-auto px-4 py-12 lg:py-20">
        {{-- Breadcrumbs --}}
        <nav class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-zinc-400 mb-8">
            <a href="{{ route('knowledge.index') }}" class="hover:text-primary-500 transition-colors">Knowledge</a>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                stroke="currentColor" class="size-3">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
            <span class="text-zinc-900 dark:text-zinc-100 truncate">{{ $knowledge->frontmatter->title }}</span>
        </nav>

        <article>
            <header class="mb-12">
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-black text-zinc-900 dark:text-white mb-6 leading-tight">
                    {{ $knowledge->frontmatter->title }}
                </h1>

                <div class="flex flex-wrap items-center gap-6 text-sm font-bold text-zinc-500">
                    <div class="flex items-center gap-2">
                        <x-prezet.icon-calendar class="size-4" />
                        <span>{{ $knowledge->createdAt->format('d/m/Y') }}</span>
                    </div>
                </div>
            </header>

            @if ($knowledge->frontmatter->image)
                <div class="mb-12 rounded-3xl overflow-hidden border border-zinc-100 dark:border-zinc-800 shadow-2xl">
                    <img src="{{ url($knowledge->frontmatter->image) }}" alt="{{ $knowledge->frontmatter->title }}"
                        class="w-full h-auto object-cover" />
                </div>
            @endif

            <div class="prose prose-zinc dark:prose-invert max-w-none
                prose-headings:font-black prose-headings:tracking-tight
                prose-a:text-primary-600 dark:prose-a:text-primary-400 prose-a:no-underline hover:prose-a:underline
                prose-img:rounded-3xl prose-img:border prose-img:border-zinc-100 dark:prose-img:border-zinc-800
                knowledge-content">
                {!! $body !!}
            </div>
        </article>
    </div>

    <style>
        .knowledge-content details {
            margin-bottom: 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 1rem;
            overflow: hidden;
            background: #fff;
            transition: all 0.3s ease;
        }
        .dark .knowledge-content details {
            border-color: #27272a;
            background: #18181b;
        }
        .knowledge-content details[open] {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        .knowledge-content summary {
            padding: 1rem 1.5rem;
            font-weight: 700;
            cursor: pointer;
            list-style: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
            outline: none;
        }
        .knowledge-content summary::-webkit-details-marker {
            display: none;
        }
        .knowledge-content summary::after {
            content: '+';
            font-size: 1.5rem;
            line-height: 1;
            transition: transform 0.3s ease;
        }
        .knowledge-content details[open] summary::after {
            transform: rotate(45deg);
        }
        .knowledge-content details .details-content {
            padding: 0 1.5rem 1.5rem;
            border-top: 1px solid #f3f4f6;
        }
        .dark .knowledge-content details .details-content {
            border-top-color: #27272a;
        }

        /* Ensure markdown content inside details is spaced correctly */
        .knowledge-content details > *:not(summary) {
            padding: 0 1.5rem 1.5rem;
        }
    </style>
</x-prezet.template>
