<div id="newsletter-section" class="max-w-2xl w-full mx-auto">
    <div id="newsletter-form-container">
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
                class="mb-8 p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-500 font-bold text-sm text-center">
                Cảm ơn bạn đã đăng ký thành công!
            </div>
        @endif

        <div class="text-center space-y-4 mb-8">
            <h3 class="text-2xl font-black text-white tracking-tight uppercase">Bản tin hàng tuần</h3>
            <p class="text-zinc-400 font-medium">
                Đăng ký để nhận thông tin về những bài viết mới nhất tuần qua
            </p>
        </div>

        <form hx-post="{{ route('newsletter.subscribe') }}" hx-target="#newsletter-form-container" hx-swap="innerHTML"
            class="relative max-w-md mx-auto group">
            @csrf
            <div
                class="relative flex items-center p-1 rounded-2xl bg-zinc-800/50 border border-zinc-700/50 shadow-sm focus-within:ring-2 focus-within:ring-white/10 focus-within:border-zinc-500 transition-all">
                <div class="pl-4 text-zinc-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0-7.5 4.5-7.5-4.5" />
                    </svg>
                </div>
                <input type="email" name="email" placeholder="Địa chỉ email của bạn" required
                    class="flex-grow bg-transparent border-none focus:ring-0 text-sm font-medium text-white placeholder:text-zinc-500 py-3 px-3" />
                <button type="submit"
                    class="bg-white text-zinc-900 font-bold text-xs uppercase tracking-widest px-6 py-3 rounded-xl transition-all hover:scale-[1.02] active:scale-[0.98] disabled:opacity-50 hover:cursor-pointer">
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
