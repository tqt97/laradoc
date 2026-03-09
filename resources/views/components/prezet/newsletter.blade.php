<div id="newsletter-section" class="max-w-3xl w-full mx-auto" x-data="{
    email: '',
    loading: false,
    async subscribe() {
        if (!this.email) return;
        this.loading = true;
        try {
            const response = await fetch('{{ route('newsletter.subscribe') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ email: this.email })
            });

            const data = await response.json();

            if (response.ok) {
                window.showToast(data.message, 'success');
                this.email = '';
            } else {
                if (data.errors && data.errors.email) {
                    window.showToast(data.errors.email[0], 'error');
                } else {
                    window.showToast(data.message || 'Đã có lỗi xảy ra', 'error');
                }
            }
        } catch (error) {
            window.showToast('Không thể kết nối đến máy chủ', 'error');
        } finally {
            this.loading = false;
        }
    }
}">
    <div id="newsletter-form-container">
        <div class="text-center space-y-4 mb-8">
            <h3 class="text-3xl font-bold text-white">Bản tin hàng tuần</h3>
            <p class="text-zinc-400 font-medium">
                Đăng ký để nhận thông tin về những bài viết mới nhất tuần qua
            </p>
        </div>

        <form @submit.prevent="subscribe()" class="relative max-w-md mx-auto group">
            <div
                class="relative flex items-center p-1 rounded-4xl bg-zinc-800/50 border border-zinc-700/50 shadow-xl focus-within:ring-2 focus-within:ring-primary-500/50 transition-all">
                <div class="pl-4 text-zinc-500">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0-7.5 4.5-7.5-4.5" />
                    </svg>
                </div>
                <input type="email" x-model="email" placeholder="Địa chỉ email của bạn" required
                    :disabled="loading"
                    class="flex-grow bg-transparent border-none focus:ring-0 text-sm font-medium text-white placeholder:text-zinc-500 py-3 px-3 disabled:opacity-50" />
                <x-form.button class="!px-6 !py-3" ::disabled="loading">
                    <span x-show="!loading">Đăng ký</span>
                    <span x-show="loading" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Đang xử lý...
                    </span>
                </x-form.button>
            </div>
        </form>
    </div>
</div>
