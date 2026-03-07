@props(['headings' => []])

<div x-data="{ 
    activeId: '',
    init() {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.activeId = entry.target.id;
                    // Auto scroll the sidebar to the active item
                    this.$nextTick(() => {
                        const activeElement = this.$el.querySelector(`[data-toc-id='${this.activeId}']`);
                        if (activeElement) {
                            activeElement.scrollIntoView({
                                behavior: 'smooth',
                                block: 'nearest'
                            });
                        }
                    });
                }
            });
        }, { 
            rootMargin: '0px 0px -70% 0px',
            threshold: 1.0
        });

        document.querySelectorAll('h2[id], h3[id]').forEach((section) => {
            observer.observe(section);
        });
    }
}">
    {{-- Mobile Sidebar --}}
    <div x-show="showSidebar" x-trap.inert.noscroll="showSidebar"
        class="fixed inset-0 z-40 flex h-full items-start overflow-y-auto bg-zinc-900/50 pr-10 backdrop-blur-sm lg:hidden"
        x-cloak>
        <div class="min-h-full w-full max-w-xs bg-white px-4 pt-24 pb-12 sm:px-6 dark:bg-zinc-950"
            x-on:click.outside="showSidebar = false">
            
            @if(!empty($headings))
                <div class="mb-12">
                    <h3 class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-900 dark:text-white mb-6">
                        Mục lục
                    </h3>
                    <ul role="list" class="space-y-4 border-l border-zinc-100 dark:border-zinc-800">
                        @foreach ($headings as $heading)
                            <li class="relative">
                                <a href="#{{ $heading['id'] }}" 
                                   data-toc-id="{{ $heading['id'] }}"
                                   @click="showSidebar = false; activeId = '{{ $heading['id'] }}'"
                                   :class="activeId === '{{ $heading['id'] }}' 
                                        ? 'text-primary-600 dark:text-primary-400 border-l-2 border-primary-500' 
                                        : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white hover:border-l-2 hover:border-zinc-300 dark:hover:border-zinc-700'"
                                   class="block w-full pl-4 transition-all duration-200 -ml-px text-sm"
                                   style="padding-left: {{ (($heading['level'] ?? 2) - 1) * 1 }}rem">
                                    {{ $heading['text'] ?? $heading['title'] ?? '' }}
                                </a>
                            </li>
                            @if(!empty($heading['children']))
                                @foreach($heading['children'] as $child)
                                    <li class="relative">
                                        <a href="#{{ $child['id'] }}" 
                                           data-toc-id="{{ $child['id'] }}"
                                           @click="showSidebar = false; activeId = '{{ $child['id'] }}'"
                                           :class="activeId === '{{ $child['id'] }}' 
                                                ? 'text-primary-600 dark:text-primary-400 border-l-2 border-primary-500' 
                                                : 'text-zinc-400 dark:text-zinc-500 hover:text-zinc-900 dark:hover:text-white hover:border-l-2 hover:border-zinc-300 dark:hover:border-zinc-700'"
                                           class="block w-full pl-4 transition-all duration-200 -ml-px text-xs mt-2"
                                           style="padding-left: {{ (($child['level'] ?? 3) - 1) * 1 }}rem">
                                            {{ $child['text'] ?? $child['title'] ?? '' }}
                                        </a>
                                    </li>
                                @endforeach
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </div>

    {{-- Desktop Sidebar --}}
    <div class="hidden lg:relative lg:block lg:flex-none">
        <div class="sticky top-[4.75rem] -ml-0.5 flex h-[calc(100vh-4.75rem)] w-64 flex-col justify-between overflow-x-hidden overflow-y-auto pt-16 pr-8 pb-4 pl-0.5 xl:w-72 xl:pr-16">
            <div>
                @if(!empty($headings))
                    <div class="mb-12">
                        <h3 class="text-xs font-bold uppercase tracking-[0.2em] text-zinc-900 dark:text-white mb-6">
                            Mục lục bài viết
                        </h3>
                        <ul role="list" class="space-y-4 border-l border-zinc-100 dark:border-zinc-800">
                            @foreach ($headings as $heading)
                                <li class="relative">
                                    <a href="#{{ $heading['id'] }}" 
                                       data-toc-id="{{ $heading['id'] }}"
                                       @click="activeId = '{{ $heading['id'] }}'"
                                       :class="activeId === '{{ $heading['id'] }}' 
                                            ? 'text-primary-600 dark:text-primary-400 border-l-2 border-primary-500' 
                                            : 'text-zinc-500 dark:text-zinc-400 hover:text-zinc-900 dark:hover:text-white hover:border-l-2 hover:border-zinc-300 dark:hover:border-zinc-700'"
                                       class="block w-full pl-4 transition-all duration-200 -ml-px text-sm"
                                       style="padding-left: {{ (($heading['level'] ?? 2) - 1) * 1 }}rem">
                                        {{ $heading['text'] ?? $heading['title'] ?? '' }}
                                    </a>
                                </li>
                                @if(!empty($heading['children']))
                                    @foreach($heading['children'] as $child)
                                        <li class="relative">
                                            <a href="#{{ $child['id'] }}" 
                                               data-toc-id="{{ $child['id'] }}"
                                               @click="activeId = '{{ $child['id'] }}'"
                                               :class="activeId === '{{ $child['id'] }}' 
                                                    ? 'text-primary-600 dark:text-primary-400 border-l-2 border-primary-500' 
                                                    : 'text-zinc-400 dark:text-zinc-500 hover:text-zinc-900 dark:hover:text-white hover:border-l-2 hover:border-zinc-300 dark:hover:border-zinc-700'"
                                               class="block w-full pl-4 transition-all duration-200 -ml-px text-xs mt-2"
                                               style="padding-left: {{ (($child['level'] ?? 3) - 1) * 1 }}rem">
                                                {{ $child['text'] ?? $child['title'] ?? '' }}
                                            </a>
                                        </li>
                                    @endforeach
                                @endif
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="mt-16 text-[10px] font-bold uppercase tracking-widest text-zinc-400 dark:text-zinc-600">
                <a target="_blank" href="https://prezet.com" class="hover:text-zinc-900 dark:hover:text-zinc-400 transition-colors">Powered by Prezet</a>
            </div>
        </div>
    </div>
</div>
