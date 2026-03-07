<div id="newsletter-section" class="max-w-2xl w-full mx-auto">
    {{-- HTMX Out-of-band swap for toast notifications --}}
    @if(session('success'))
        <div id="toast-container" hx-swap-oob="true" class="fixed top-24 right-4 z-[110] flex flex-col gap-4 w-full max-w-sm pointer-events-none">
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8"
                x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-8"
                class="p-4 rounded-2xl bg-emerald-500 text-white font-bold text-sm shadow-2xl flex items-center gap-3 pointer-events-auto">
                <div class="size-8 rounded-full bg-white/20 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>
                </div>
                <p>{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div id="newsletter-form-container">
        <div class="text-center space-y-4 mb-8">
            <h3 class="text-2xl font-black text-white tracking-tight uppercase">Bản tin hàng tuần</h3>
            <p class="text-zinc-400 font-medium">
                Đăng ký để nhận thông tin về những bài viết mới nhất tuần qua
            </p>
        </div>

        <form hx-post="{{ route('newsletter.subscribe') }}" hx-target="#newsletter-form-container" hx-swap="innerHTML"
            class="relative max-w-md mx-auto group">
            @csrf
            <div class="relative flex items-center p-1 rounded-2xl bg-zinc-800/50 border border-zinc-700/50 shadow-sm focus-within:ring-2 focus-within:ring-white/10 focus-within:border-zinc-500 transition-all">
                <div class="pl-4 text-zinc-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0-7.5 4.5-7.5-4.5" />
                    </svg>
                </div>
                <input type="email" name="email" placeholder="Địa chỉ email của bạn" required
                    class="flex-grow bg-transparent border-none focus:ring-0 text-sm font-medium text-white placeholder:text-zinc-500 py-3 px-3" />
                <button type="submit"
                    class="bg-white text-zinc-900 font-bold text-xs uppercase tracking-widest px-6 py-3 rounded-xl transition-all hover:scale-[1.02] active:scale-[0.98] disabled:opacity-50">
                    Đăng ký
                </button>
            </div>
            @error('email')
                <div class="absolute -bottom-6 left-0 text-[10px] text-red-400 font-bold uppercase tracking-wider pl-4">
                    {{ $message }}
                </div>
            @enderror
        </form>
    </div>
</div>
