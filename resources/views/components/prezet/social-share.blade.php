@props(['url', 'title'])

<div x-data="{
    copied: false,
    copyToClipboard() {
        navigator.clipboard.writeText('{{ $url }}').then(() => {
            this.copied = true;
            setTimeout(() => this.copied = false, 2000);
            $dispatch('notify', { message: 'Đã sao chép liên kết!', type: 'success' });
        });
    }
}" class="social-share-wrapper">
    <!-- Desktop Sticky Sidebar -->
    <div class="hidden xl:flex fixed left-8 top-1/2 -translate-y-1/2 flex-col items-center gap-4 z-40">
        <div class="w-px h-12 bg-zinc-200 dark:bg-zinc-800 mb-2"></div>

        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url) }}"
            target="_blank" rel="noopener noreferrer"
            class="group relative flex h-10 w-10 items-center justify-center rounded-full bg-white shadow-sm border border-zinc-200 text-zinc-600 transition-all hover:-translate-y-1 hover:bg-blue-600 hover:text-white dark:bg-zinc-900 dark:border-zinc-800 dark:text-zinc-400"
            title="Chia sẻ lên Facebook">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
            <span class="absolute left-full ml-3 px-2 py-1 rounded bg-zinc-900 text-white text-[10px] font-bold opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all whitespace-nowrap">Facebook</span>
        </a>

        <a href="https://twitter.com/intent/tweet?url={{ urlencode($url) }}&text={{ urlencode($title) }}"
            target="_blank" rel="noopener noreferrer"
            class="group relative flex h-10 w-10 items-center justify-center rounded-full bg-white shadow-sm border border-zinc-200 text-zinc-600 transition-all hover:-translate-y-1 hover:bg-zinc-900 hover:text-white dark:bg-zinc-900 dark:border-zinc-800 dark:text-zinc-400 dark:hover:bg-white dark:hover:text-black"
            title="Chia sẻ lên Twitter">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/></svg>
            <span class="absolute left-full ml-3 px-2 py-1 rounded bg-zinc-900 text-white text-[10px] font-bold opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all whitespace-nowrap">Twitter</span>
        </a>

        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($url) }}"
            target="_blank" rel="noopener noreferrer"
            class="group relative flex h-10 w-10 items-center justify-center rounded-full bg-white shadow-sm border border-zinc-200 text-zinc-600 transition-all hover:-translate-y-1 hover:bg-blue-700 hover:text-white dark:bg-zinc-900 dark:border-zinc-800 dark:text-zinc-400"
            title="Chia sẻ lên LinkedIn">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg>
            <span class="absolute left-full ml-3 px-2 py-1 rounded bg-zinc-900 text-white text-[10px] font-bold opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all whitespace-nowrap">LinkedIn</span>
        </a>

        <button @click="copyToClipboard()"
            class="group relative flex h-10 w-10 items-center justify-center rounded-full bg-white shadow-sm border border-zinc-200 text-zinc-600 transition-all hover:-translate-y-1 hover:bg-emerald-600 hover:text-white dark:bg-zinc-900 dark:border-zinc-800 dark:text-zinc-400 hover:cursor-pointer"
            title="Sao chép liên kết">
            <svg x-show="!copied" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
            <svg x-show="copied" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-white"><polyline points="20 6 9 17 4 12"/></svg>

            <span class="absolute left-full ml-3 px-2 py-1 rounded bg-zinc-900 text-white text-[10px] font-bold transition-all whitespace-nowrap"
                  :class="copied ? 'opacity-100 visible' : 'opacity-0 invisible group-hover:opacity-100 group-hover:visible'"
                  x-text="copied ? 'Đã sao chép!' : 'Copy link'"></span>
        </button>

        <div class="w-px h-12 bg-zinc-200 dark:bg-zinc-800 mt-2"></div>
    </div>

    <!-- Mobile/Default Horizontal Layout -->
    <div class="flex items-center gap-2 xl:hidden">
        <span class="text-xs font-bold text-zinc-400 dark:text-zinc-500 uppercase tracking-wider mr-1">Chia sẻ:</span>

        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($url) }}"
            target="_blank" rel="noopener noreferrer"
            class="flex h-8 w-8 items-center justify-center rounded-full bg-zinc-100 text-zinc-600 transition-colors hover:bg-blue-100 hover:text-blue-600 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:bg-blue-900/30 dark:hover:text-blue-400"
            title="Chia sẻ lên Facebook">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
        </a>

        <a href="https://twitter.com/intent/tweet?url={{ urlencode($url) }}&text={{ urlencode($title) }}"
            target="_blank" rel="noopener noreferrer"
            class="flex h-8 w-8 items-center justify-center rounded-full bg-zinc-100 text-zinc-600 transition-colors hover:bg-zinc-900 hover:text-white dark:bg-zinc-800 dark:text-zinc-400 dark:hover:bg-white dark:hover:text-black"
            title="Chia sẻ lên Twitter">
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/></svg>
        </a>

        <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode($url) }}"
            target="_blank" rel="noopener noreferrer"
            class="flex h-8 w-8 items-center justify-center rounded-full bg-zinc-100 text-zinc-600 transition-colors hover:bg-blue-600 hover:text-white dark:bg-zinc-800 dark:text-zinc-400 dark:hover:bg-blue-600 dark:hover:text-white"
            title="Chia sẻ lên LinkedIn">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect width="4" height="12" x="2" y="9"/><circle cx="4" cy="4" r="2"/></svg>
        </a>

        <div class="relative flex items-center">
            <button @click="copyToClipboard()"
                class="flex h-8 w-8 items-center justify-center rounded-full bg-zinc-100 text-zinc-600 transition-colors hover:bg-emerald-100 hover:text-emerald-600 dark:bg-zinc-800 dark:text-zinc-400 dark:hover:bg-emerald-900/30 dark:hover:text-emerald-400"
                title="Sao chép liên kết">
                <svg x-show="!copied" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="14" x="8" y="8" rx="2" ry="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/></svg>
                <svg x-show="copied" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-emerald-500"><polyline points="20 6 9 17 4 12"/></svg>
            </button>
            <div x-show="copied"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-2"
                 class="absolute bottom-full left-1/2 -translate-x-1/2 mb-2 px-2 py-1 rounded bg-zinc-900 text-white text-[10px] font-bold whitespace-nowrap z-50">
                Đã sao chép!
            </div>
        </div>
    </div>
</div>
