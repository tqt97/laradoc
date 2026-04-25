@php
    /* @var object $knowledge */
    /* @var string $body */
    /* @var array $headings */
    /* @var \Illuminate\Support\Collection $relatedArticles */
@endphp

<x-prezet.template>
    @seo($seo)

    <div class="max-w-7xl mx-auto px-4 py-8 lg:py-16">
        {{-- Top Navigation --}}
        <div class="flex items-center justify-between">
            <nav class="flex items-center gap-2 text-xs font-bold uppercase tracking-[0.2em] text-zinc-400">
                <a href="{{ route('knowledge.index') }}" class="hover:text-primary-500 transition-colors">Kiến thức</a>
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
                <span>Quay lại</span>
            </a>
        </div>

        <x-prezet.alpine class="grid grid-cols-12 gap-8 lg:gap-16">
            {{-- Right Sidebar / TOC Desktop --}}
            <x-prezet.toc :headings="$headings" class="px-2" />
            {{-- <div class="col-span-12 lg:order-last lg:col-span-3">
                <div class="flex-none overflow-y-auto lg:sticky lg:top-[6rem] lg:h-[calc(100vh-4.75rem)]">

                    <div
                        class="mt-8 hidden lg:block p-8 rounded-[40px] bg-primary-600 text-white relative overflow-hidden shadow-2xl shadow-primary-500/20">
                        <div class="absolute -right-4 -bottom-4 size-32 bg-white/10 rounded-full blur-3xl"></div>
                        <div class="relative z-10">
                            <h3 class="text-lg font-black leading-tight mb-4">Bạn muốn học thêm?</h3>
                            <p class="text-sm text-primary-100 mb-8 font-medium leading-relaxed">Khám phá thêm các bài
                                tóm tắt kiến thức và câu hỏi phỏng vấn mới nhất.</p>
                            <a href="{{ route('knowledge.index') }}"
                                class="inline-flex items-center gap-2 bg-white text-primary-600 px-6 py-3 rounded-2xl text-xs font-black uppercase tracking-widest hover:bg-primary-50 transition-colors shadow-lg">
                                Tất cả chủ đề
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                                    stroke="currentColor" class="size-3">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div> --}}

            <div class="col-span-12 lg:hidden">
                <div class="h-px w-full border-0 bg-zinc-200 dark:bg-zinc-700"></div>
            </div>

            {{-- Main Content --}}
            <article class="col-span-12 lg:col-span-12 min-w-0">
                <header class="mb-12">
                    {{-- <div class="flex items-center gap-3 mb-6">
                        <span
                            class="px-3 py-1 rounded-full bg-primary-500/10 text-primary-600 dark:text-primary-400 text-[10px] font-black uppercase tracking-widest border border-primary-500/20">
                            Ôn tập kiến thức
                        </span>
                        <span class="text-[10px] font-bold text-zinc-400 uppercase tracking-widest">
                            #{{ $knowledge->frontmatter->category ?? 'General' }}
                        </span>
                    </div> --}}

                    <h1
                        class="text-3xl md:text-4xl lg:text-5xl font-black text-zinc-900 dark:text-white mb-8 leading-[1.1] tracking-tight">
                        {{ $knowledge->frontmatter->title }}
                    </h1>

                    <div class="flex flex-wrap items-center justify-between gap-6 mb-8">
                        <div class="flex flex-wrap items-center gap-8 text-xs font-bold text-zinc-500">
                            <div class="flex items-center gap-2.5">
                                <div
                                    class="p-2 rounded-xl bg-zinc-50 dark:bg-zinc-900 border border-zinc-100 dark:border-zinc-800">
                                    <x-prezet.icon-calendar class="size-4 text-primary-500" />
                                </div>
                                <div class="flex flex-col gap-0.5">
                                    <span class="text-[10px] uppercase tracking-wider opacity-50">Ngày đăng</span>
                                    <span
                                        class="text-zinc-900 dark:text-zinc-200">{{ $knowledge->createdAt->format('d/m/Y') }}</span>
                                </div>
                            </div>

                            <div class="flex items-center gap-2.5">
                                <div
                                    class="p-2 rounded-xl bg-zinc-50 dark:bg-zinc-900 border border-zinc-100 dark:border-zinc-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4 text-primary-500">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12.a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                </div>
                                <div class="flex flex-col gap-0.5">
                                    <span class="text-[10px] uppercase tracking-wider opacity-50">Lượt xem</span>
                                    <span class="text-zinc-900 dark:text-zinc-200">{{ number_format($views ?? 0) }}</span>
                                </div>
                            </div>
                        </div>

                        <x-prezet.social-share :url="request()->url()" :title="$knowledge->frontmatter->title" />
                    </div>

                    <div class="col-span-12 mt-4">
                        <div class="h-px w-full border-0 bg-zinc-100 dark:bg-zinc-800"></div>
                    </div>
                </header>

                {{-- @if ($knowledge->frontmatter->image)
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
                @endif --}}

                <div class="prose prose-zinc dark:prose-invert max-w-none
                    prose-pre:rounded-3xl prose-headings:font-display
                    prose-a:border-b prose-a:border-dashed prose-a:border-black/30 prose-a:font-semibold prose-a:no-underline prose-a:hover:border-solid
                    prose-img:rounded-3xl prose-img:border prose-img:border-zinc-100 dark:prose-img:border-zinc-800
                    prose-code:text-primary-600 dark:prose-code:text-primary-400 prose-code:bg-primary-500/5 prose-code:px-1.5 prose-code:py-0.5 prose-code:rounded-md prose-code:before:content-none prose-code:after:content-none
                    knowledge-content">
                    {!! $body !!}
                </div>

                {{-- Tags Section --}}
                @if(isset($knowledge->frontmatter->tags) && is_array($knowledge->frontmatter->tags))
                    <div class="mt-16 pt-10 border-t border-zinc-100 dark:border-zinc-800">
                        <div class="flex items-center gap-4 flex-wrap">
                            <div class="flex items-center gap-2 text-zinc-400 dark:text-zinc-500 mr-2">
                                <x-prezet.icon-tag class="size-4" />
                                <span class="text-xs font-black uppercase tracking-widest">Chủ đề:</span>
                            </div>
                            @foreach($knowledge->frontmatter->tags as $tag)
                                <a href="{{ route('knowledge.index', ['tag' => $tag]) }}"
                                    class="inline-flex items-center px-4 py-2 rounded-2xl bg-zinc-50 dark:bg-zinc-900 border border-zinc-100 dark:border-zinc-800 text-xs font-bold text-zinc-600 dark:text-zinc-400 hover:border-primary-500 hover:text-primary-600 dark:hover:text-primary-400 transition-all hover:-translate-y-0.5 hover:shadow-lg hover:shadow-primary-500/5">
                                    #{{ $tag }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Related Articles Section --}}
                @if($relatedArticles->isNotEmpty())
                    <div class="mt-32 pt-20 border-t border-zinc-100 dark:border-zinc-800">
                        <div class="flex items-center justify-between mb-12">
                            <div>
                                <h2 class="text-3xl font-black text-zinc-900 dark:text-white tracking-tight mb-2">Bài viết
                                    liên quan</h2>
                                <p class="text-sm text-zinc-500 font-medium tracking-wide">Tiếp tục hành trình nâng tầm kiến
                                    thức của bạn</p>
                            </div>
                            <div class="hidden sm:block h-px flex-1 bg-zinc-100 dark:bg-zinc-800 mx-12"></div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            @foreach($relatedArticles as $article)
                                <x-prezet.article :article="$article" :hide-image="true" />
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Bottom Navigation
                <div
                    class="mt-20 pt-12 border-t border-zinc-100 dark:border-zinc-800 flex flex-col sm:flex-row items-center justify-between gap-6">
                    <div class="flex items-center gap-4">
                        <div
                            class="size-12 rounded-2xl bg-zinc-900 dark:bg-white flex items-center justify-center text-white dark:text-zinc-900 font-black text-xl">
                            {{ strtoupper(substr(config('app.name'), 0, 1)) }}
                        </div>
                        <div class="flex flex-col">
                            <span class="text-sm font-black text-zinc-900 dark:text-white uppercase tracking-wider">{{
                                config('app.name') }}</span>
                            <span class="text-xs text-zinc-500 font-medium">Kho kiến thức & Ôn tập</span>
                        </div>
                    </div>

                    <a href="{{ route('knowledge.index') }}"
                        class="px-8 py-4 rounded-2xl bg-zinc-50 dark:bg-zinc-900 text-zinc-900 dark:text-white text-xs font-black uppercase tracking-[0.2em] border border-zinc-200 dark:border-zinc-800 hover:bg-white dark:hover:bg-zinc-800 transition-all hover:shadow-xl active:scale-95">
                        Khám phá thêm
                    </a>
                </div> --}}
            </article>
        </x-prezet.alpine>
    </div>

    <style>
        html {
            scroll-behavior: smooth;
        }

        .knowledge-content details {
            margin-top: 1.5rem;
            margin-bottom: 1.5rem;
            border: 2px solid #f4f4f5;
            border-radius: 1rem;
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
            padding: 1rem 1.5rem;
            font-weight: 600;
            font-size: 1rem;
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

        /* Custom indicator - Chevron Down */
        .knowledge-content summary::after {
            content: '';
            width: 2rem;
            height: 2rem;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='3' stroke='%23f97316'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='m19.5 8.25-7.5 7.5-7.5-7.5' /%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: center;
            background-size: 1.25rem;
            background-color: #fff;
            border: 2px solid #f4f4f5;
            border-radius: 0.75rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .dark .knowledge-content summary::after {
            background-color: #18181b;
            border-color: #27272a;
        }

        /* Custom indicator - Chevron Up when open */
        .knowledge-content details[open] summary::after {
            background-color: #f97316;
            border-color: #f97316;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='3' stroke='white'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='m4.5 15.75 7.5-7.5 7.5 7.5' /%3E%3C/svg%3E");
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
