<div id="toast-container"
    class="fixed top-6 right-6 z-[110] flex flex-col gap-3 w-full max-w-[320px] pointer-events-none"
    x-cloak
    x-data="{
        toasts: [],
        addToast(message, type = 'success') {
            if (!message) return;
            const id = Date.now();
            this.toasts.push({ id, message, type, show: true });
            setTimeout(() => {
                this.removeToast(id);
            }, type === 'success' ? 4000 : 6000);
        },
        removeToast(id) {
            const index = this.toasts.findIndex(t => t.id === id);
            if (index !== -1) {
                this.toasts[index].show = false;
                setTimeout(() => {
                    this.toasts = this.toasts.filter(t => t.id !== id);
                }, 500);
            }
        }
    }"
    x-init="
        window.showToast = (message, type) => addToast(message, type);
        @if (session('success'))
            @php $msg = session('success'); @endphp
            @if(is_string($msg) && strlen(trim($msg)) > 0)
                setTimeout(() => addToast('{{ $msg }}', 'success'), 100);
            @endif
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                setTimeout(() => addToast('{{ $error }}', 'error'), 100);
            @endforeach
        @endif
    "
    @toast.window="addToast($event.detail.message, $event.detail.type)">
    <template x-for="toast in toasts" :key="toast.id">
        <div x-show="toast.show" x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="relative p-3 rounded-2xl backdrop-blur-xl border font-bold text-[12px] shadow-2xl flex items-center gap-3 pointer-events-auto overflow-hidden transition-all"
            :class="{
                'bg-emerald-50/95 dark:bg-zinc-900/95 border-emerald-500/10 dark:border-emerald-500/20 text-zinc-900 dark:text-zinc-100 shadow-emerald-500/10': toast
                    .type === 'success',
                'bg-red-50/95 dark:bg-zinc-900/95 border-red-500/10 dark:border-red-500/20 text-zinc-900 dark:text-zinc-100 shadow-red-500/10 items-start': toast
                    .type === 'error'
            }">

            {{-- Success Icon --}}
            <template x-if="toast.type === 'success'">
                <div
                    class="size-8 rounded-xl bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                        stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </div>
            </template>

            {{-- Error Icon --}}
            <template x-if="toast.type === 'error'">
                <div
                    class="size-8 rounded-xl bg-red-500/10 text-red-600 dark:text-red-400 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3"
                        stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </div>
            </template>

            <div class="flex-1 min-w-0">
                <p class="text-[10px] font-black uppercase tracking-widest leading-none mb-1"
                    :class="toast.type === 'success' ? 'text-emerald-600 dark:text-emerald-400' :
                        'text-red-600 dark:text-red-400'"
                    x-text="toast.type === 'success' ? 'Thành công' : 'Đã xảy ra lỗi'"></p>
                <p class="truncate leading-tight" x-text="toast.message"></p>
            </div>

            {{-- Progress Bar --}}
            <div class="absolute bottom-0 left-0 h-[3px] w-full"
                :class="toast.type === 'success' ? 'bg-emerald-500/10' : 'bg-red-500/10'">
                <div x-init="$nextTick(() => $el.style.width = '0%')" class="h-full w-full transition-all ease-linear"
                    :class="toast.type === 'success' ? 'bg-emerald-500' : 'bg-red-500'"
                    :style="`transition-duration: ${toast.type === 'success' ? 4000 : 6000}ms`"></div>
            </div>
        </div>
    </template>
</div>
