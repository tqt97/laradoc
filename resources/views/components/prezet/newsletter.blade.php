<div id="newsletter-section" class="max-w-3xl w-full mx-auto">
    <div id="newsletter-form-container">
        <div class="text-center space-y-4 mb-8">
            <h3 class="text-3xl font-bold text-white">Bản tin hàng tuần</h3>
            <p class="text-zinc-400 font-medium">
                Đăng ký để nhận thông tin về những bài viết mới nhất tuần qua
            </p>
        </div>

        <form action="{{ route('newsletter.subscribe') }}" method="POST" class="relative max-w-md mx-auto group">
            @csrf
            <div
                class="relative flex items-center p-1 rounded-4xl bg-zinc-800/50 border border-zinc-700/50 shadow-sm focus-within:ring-2 focus-within:ring-white/10 focus-within:border-zinc-500 transition-all">
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
                    class=" bg-primary-600 text-zinc-100 font-bold text-xs uppercase tracking-widest px-6 py-3 rounded-3xl transition-all disabled:opacity-50 hover:cursor-pointer hover:bg-primary-700 hover:text-white">
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
