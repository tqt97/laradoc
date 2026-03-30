<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-2 space-y-1">
        <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-50">
            Chào mừng trở lại
        </h1>

        <p class="text-sm text-gray-500 dark:text-gray-400">
            Đăng nhập để tiếp tục vào hệ thống
        </p>
    </div>

    <div class="flex items-center gap-3 text-xs text-gray-200">
        <div class="flex-1 h-px bg-gray-200 dark:bg-gray-600"></div>
        <span class="mt-1">
            <x-icons.arrow-down />
        </span>
        <div class="flex-1 h-px bg-gray-200 dark:bg-gray-600"></div>
    </div>

    <form class="mt-6" method="POST" action="{{ route('login') }}"
        x-data="{ loading: false, show: { password: false } }" @submit="loading = true">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" placeholder="Nhập email" aria-label="Email address"
                aria-required="true" aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <x-password-input name="password" label="Mật khẩu" placeholder="Tối thiểu 8 ký tự" :strength="false" />

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center hover:cursor-pointer">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-orange-500 shadow-sm focus:ring-orange-500" name="remember">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-300">{{ __('Ghi nhớ tài khoản') }}</span>
            </label>
        </div>

        <div class="mt-6 space-y-5">

            <!-- Login -->
            <x-primary-button class="w-full flex items-center justify-center gap-2 hover:cursor-pointer"
                x-bind:disabled="loading" x-bind:class="{ 'opacity-50 cursor-not-allowed': loading }">
                <x-icons.loading />

                <span x-text="loading ? 'Đang đăng nhập...' : 'Đăng nhập'"></span>
            </x-primary-button>

            <!-- Divider -->
            <div class="flex items-center gap-3 text-xs text-gray-400 dark:text-gray-600">
                <div class="flex-1 h-px bg-gray-200 dark:bg-gray-600"></div>
                <span class="text-gray-400 dark:text-gray-300">hoặc tiếp tục với</span>
                <div class="flex-1 h-px bg-gray-200 dark:bg-gray-600"></div>
            </div>

            <!-- Social login -->
            <div class="grid grid-cols-2 gap-3">

                <!-- Google -->
                <a href="#"
                    class="flex items-center justify-center gap-2 border border-orange-300 rounded-lg py-2.5
                    hover:bg-gray-50 hover:border-orange-400 hover:text-orange-500 transition text-sm font-medium dark:text-gray-300 dark:bg-gray-800">
                    <x-icons.google />
                    Google
                </a>

                <!-- GitHub -->
                <a href="#"
                    class="flex items-center justify-center gap-2 border border-orange-300 rounded-lg py-2.5 hover:bg-gray-50 hover:border-orange-400 hover:text-orange-500 transition text-sm font-medium dark:text-gray-300 dark:bg-gray-800">
                    <x-icons.githud />
                    GitHub
                </a>
            </div>

            <!-- Register -->
            @if (Route::has('register'))
                <div class="text-center text-sm text-gray-800 dark:text-gray-300">
                    Chưa có tài khoản?
                    <a href="{{ route('register') }}" class="text-orange-500 font-medium hover:underline">
                        Đăng ký ngay
                    </a>
                </div>
            @endif

            <!-- Forgot password -->
            @if (Route::has('password.request'))
                <div class="text-center">
                    <a href="{{ route('password.request') }}"
                        class="text-xs text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-300">
                        Quên mật khẩu?
                    </a>
                </div>
            @endif
        </div>

    </form>
</x-guest-layout>
