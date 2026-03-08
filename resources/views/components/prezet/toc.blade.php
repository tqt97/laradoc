@props(['headings' => []])

<div {{ $attributes->merge(['class' => '']) }}>
    <div class="flex items-center gap-2 mb-6">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
            class="size-4 text-primary-500">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0ZM3.75 12h.007v.008H3.75V12Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm-3.75 5.25h.007v.008H3.75v-.008Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
        </svg>
        <p class="font-semibold text-xs tracking-[0.2em] text-zinc-900 dark:text-zinc-100 uppercase">
            Mục lục bài viết
        </p>
    </div>
    <ol role="list" class="space-y-0 text-xs border-l border-zinc-100 dark:border-zinc-800">
        @foreach ($headings as $h2)
            <li class="relative">
                <div x-show="activeHeading === '{{ $h2['id'] }}'"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 -translate-x-1"
                    x-transition:enter-end="opacity-100 translate-x-0"
                    class="absolute -left-px top-0 h-full w-0.5 bg-primary-500"></div>

                <a href="#{{ $h2['id'] }}"
                    :class="activeHeading === '{{ $h2['id'] }}' ?
                        'text-primary-600 dark:text-primary-400' :
                        'text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-200'"
                    x-on:click.prevent="scrollToHeading('{{ $h2['id'] }}')"
                    class="block pl-4 py-1 transition-all duration-200 leading-relaxed">
                    {{ $h2['title'] }}
                </a>

                @if (!empty($h2['children']))
                    <ol role="list" class="mt-px space-y-0">
                        @foreach ($h2['children'] as $h3)
                            <li class="relative">
                                <div x-show="activeHeading === '{{ $h3['id'] }}'"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 -translate-x-1"
                                    x-transition:enter-end="opacity-100 translate-x-0"
                                    class="absolute -left-px top-0 h-full w-0.5 bg-primary-500/50">
                                </div>

                                <a href="#{{ $h3['id'] }}"
                                    :class="activeHeading === '{{ $h3['id'] }}' ?
                                        'text-primary-600 dark:text-primary-400' :
                                        'text-zinc-500 hover:text-zinc-700 dark:text-zinc-500 dark:hover:text-zinc-300'"
                                    x-on:click.prevent="scrollToHeading('{{ $h3['id'] }}')"
                                    class="block pl-8 py-1 text-xs transition-all duration-200 leading-relaxed">
                                    {{ $h3['title'] }}
                                </a>
                            </li>
                        @endforeach
                    </ol>
                @endif
            </li>
        @endforeach
    </ol>
</div>
