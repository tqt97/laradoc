@php
    /* @var object $knowledge */
    /* @var string $body */
@endphp

<x-prezet.template>
    @seo($seo)

    <div class="max-w-7xl mx-auto px-4 py-12 lg:py-20">
        {{-- Top Navigation --}}
        <div class="flex items-center justify-between mb-12">
            <nav class="flex items-center gap-2 text-xs font-bold uppercase tracking-[0.2em] text-zinc-400">
                <a href="{{ route('knowledge.index') }}" class="hover:text-primary-500 transition-colors">Knowledge</a>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                    stroke="currentColor" class="size-3 opacity-50">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
                <span
                    class="text-zinc-900 dark:text-zinc-100 truncate max-w-[200px] sm:max-w-none">{{ $knowledge->frontmatter->title }}</span>
            </nav>

            <a href="{{ route('knowledge.index') }}"
                class="group flex items-center gap-2 text-xs font-black uppercase tracking-widest text-zinc-500 hover:text-primary-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                    stroke="currentColor" class="size-4 group-hover:-translate-x-1 transition-transform">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75 3 12m0 0 3.75-3.75M3 12h18" />
                </svg>
                <span>Back</span>
            </a>
        </div>

        <article>
            <header class="mb-12">
                <div class="flex items-center gap-3 mb-6">
                    <span
                        class="px-3 py-1 rounded-full bg-primary-500/10 text-primary-600 dark:text-primary-400 text-[10px] font-black uppercase tracking-widest border border-primary-500/20">
                        Knowledge Review
                    </span>
                    @if(isset($knowledge->frontmatter->tags) && is_array($knowledge->frontmatter->tags))
                        @foreach(array_slice($knowledge->frontmatter->tags, 0, 2) as $tag)
                            <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest">#{{ $tag }}</span>
                        @endforeach
                    @endif
                </div>

                <h1
                    class="text-3xl md:text-4xl lg:text-6xl font-black text-zinc-900 dark:text-white mb-8 leading-[1.1] tracking-tight">
                    {{ $knowledge->frontmatter->title }}
                </h1>

                <div class="flex flex-wrap items-center gap-8 text-xs font-bold text-zinc-500">
                    <div class="flex items-center gap-2.5">
                        <div
                            class="p-2 rounded-xl bg-zinc-50 dark:bg-zinc-900 border border-zinc-100 dark:border-zinc-800">
                            <x-prezet.icon-calendar class="size-4 text-primary-500" />
                        </div>
                        <div class="flex flex-col gap-0.5">
                            <span class="text-[10px] uppercase tracking-wider opacity-50">Published</span>
                            <span
                                class="text-zinc-900 dark:text-zinc-200">{{ $knowledge->createdAt->format('M d, Y') }}</span>
                        </div>
                    </div>

                    @if($knowledge->frontmatter->description)
                        <div
                            class="w-full mt-8 p-6 rounded-3xl bg-zinc-50 dark:bg-zinc-900/50 border border-zinc-100 dark:border-zinc-800 italic text-sm text-zinc-600 dark:text-zinc-400 leading-relaxed relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-1 h-full bg-primary-500/50"></div>
                            {{ $knowledge->frontmatter->description }}
                        </div>
                    @endif
                </div>
            </header>

            @if ($knowledge->frontmatter->image)
                <div class="mb-16 group relative">
                    <div
                        class="absolute -inset-4 bg-primary-500/5 rounded-[40px] blur-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-700">
                    </div>
                    <div
                        class="relative rounded-[32px] overflow-hidden border border-zinc-100 dark:border-zinc-800 shadow-2xl shadow-zinc-200/50 dark:shadow-none transition-transform duration-700 group-hover:scale-[1.01]">
                        <img src="{{ url($knowledge->frontmatter->image) }}" alt="{{ $knowledge->frontmatter->title }}"
                            class="w-full h-auto object-cover" />
                    </div>
                </div>
            @endif

            <div class="prose prose-zinc dark:prose-invert max-w-none
                prose-headings:font-black prose-headings:tracking-tight
                prose-h2:text-2xl prose-h2:mt-12 prose-h2:mb-6
                prose-p:leading-relaxed prose-p:text-zinc-600 dark:prose-p:text-zinc-400
                prose-a:text-primary-600 dark:prose-a:text-primary-400 prose-a:no-underline hover:prose-a:underline
                prose-img:rounded-3xl prose-img:border prose-img:border-zinc-100 dark:prose-img:border-zinc-800
                prose-code:text-primary-600 dark:prose-code:text-primary-400 prose-code:bg-primary-500/5 prose-code:px-1.5 prose-code:py-0.5 prose-code:rounded-md prose-code:before:content-none prose-code:after:content-none
                knowledge-content">
                {!! $body !!}
            </div>

            {{-- Bottom Navigation --}}
            <div
                class="mt-20 pt-12 border-t border-zinc-100 dark:border-zinc-800 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div
                        class="size-12 rounded-2xl bg-zinc-900 dark:bg-white flex items-center justify-center text-white dark:text-zinc-900 font-black text-xl">
                        {{ strtoupper(substr(config('app.name'), 0, 1)) }}
                    </div>
                    <div class="flex flex-col">
                        <span
                            class="text-sm font-black text-zinc-900 dark:text-white uppercase tracking-wider">{{ config('app.name') }}</span>
                        <span class="text-xs text-zinc-500 font-medium">Knowledge Base & Review</span>
                    </div>
                </div>

                <a href="{{ route('knowledge.index') }}"
                    class="px-8 py-4 rounded-2xl bg-zinc-50 dark:bg-zinc-900 text-zinc-900 dark:text-white text-xs font-black uppercase tracking-[0.2em] border border-zinc-200 dark:border-zinc-800 hover:bg-white dark:hover:bg-zinc-800 transition-all hover:shadow-xl active:scale-95">
                    Explore More
                </a>
            </div>
        </article>
    </div>

    <style>
        .knowledge-content details {
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
            border: 2px solid #f4f4f5;
            border-radius: 1.5rem;
            overflow: hidden;
            background: #fafafa;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .dark .knowledge-content details {
            border-color: #18181b;
            background: #09090b;
        }

        .knowledge-content details[open] {
            border-color: #f97316;
            background: #fff;
            box-shadow: 0 20px 25px -5px rgba(59, 130, 246, 0.05), 0 8px 10px -6px rgba(59, 130, 246, 0.05);
        }

        .dark .knowledge-content details[open] {
            border-color: #f97316;
            background: #000;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.3);
        }

        .knowledge-content summary {
            padding: 1.5rem 2rem;
            font-weight: 800;
            font-size: 1.125rem;
            cursor: pointer;
            list-style: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
            outline: none;
            color: #18181b;
            transition: color 0.3s ease;
        }

        .dark .knowledge-content summary {
            color: #f4f4f5;
        }

        .knowledge-content summary:hover {
            color: #f97316;
        }

        .knowledge-content summary::-webkit-details-marker {
            display: none;
        }

        /* Custom indicator */
        .knowledge-content summary::after {
            content: '';
            width: 2rem;
            height: 2rem;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='3' stroke='%23f97316'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M12 4.5v15m7.5-7.5h-15' /%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 1rem;
            background-color: #fff;
            border: 2px solid #f4f4f5;
            border-radius: 0.75rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .dark .knowledge-content summary::after {
            background-color: #18181b;
            border-color: #27272a;
        }

        .knowledge-content details[open] summary::after {
            transform: rotate(45deg);
            background-color: #f97316;
            border-color: #f97316;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='3' stroke='white'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M12 4.5v15m7.5-7.5h-15' /%3E%3C/svg%3E");
        }

        .knowledge-content details .details-content,
        .knowledge-content details>*:not(summary) {
            padding: 0 2rem 2rem;
            animation: slideDown 0.5s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Responsive tweaks */
        @media (max-width: 640px) {
            .knowledge-content summary {
                padding: 1.25rem 1.5rem;
                font-size: 1rem;
            }

            .knowledge-content details>*:not(summary) {
                padding: 0 1.5rem 1.5rem;
            }
        }
    </style>
</x-prezet.template>
