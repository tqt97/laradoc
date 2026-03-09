<footer class="bg-zinc-900 dark:bg-black border-t border-zinc-800 mt-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="flex flex-col items-center text-center space-y-16">
            {{-- Newsletter Section --}}
            <x-prezet.newsletter />

            <div class="w-full h-px bg-zinc-800"></div>

            {{-- Simple Footer Bottom --}}
            <div class="flex flex-col md:flex-row justify-between items-center w-full gap-8">
                <div class="flex items-center gap-6">
                    <x-prezet.logo />
                    <p class="text-sm font-bold text-zinc-400">
                        &copy; {{ date('Y') }} <a class="text-primary-800 hover:text-primary-600 hover:underline"
                            href="/">TuanTQ</a> - Chia sẻ và lưu trữ kiến thức.
                    </p>
                </div>

                <div class="flex items-center gap-8 text-sm font-bold device-x">
                    <a href="{{ route('prezet.index') }}"
                        class="text-zinc-400 hover:text-primary-500 transition-colors">Bài viết</a>
                    <a href="{{ route('prezet.series.index') }}"
                        class="text-zinc-400 hover:text-primary-500 transition-colors">Chuỗi bài viết</a>
                    <a href="{{ route('links.index') }}"
                        class="text-zinc-400 hover:text-primary-500 transition-colors">Liên kết</a>
                    <a href="{{ route('snippets.index') }}"
                        class="text-zinc-400 hover:text-primary-500 transition-colors">Snippets</a>
                </div>
            </div>
        </div>
    </div>
</footer>
