<x-guest-layout>

    <div class="text-center mb-2 space-y-1">
        <h1 class="text-xl font-semibold text-gray-900 dark:text-gray-50">
            Tạo tài khoản
        </h1>

        <p class="text-sm text-gray-500 dark:text-gray-400">
            Bắt đầu sử dụng nền tảng chỉ trong vài giây
        </p>
    </div>

    <div class="flex items-center gap-3 text-xs text-gray-200">
        <div class="flex-1 h-px bg-gray-200 dark:bg-gray-600"></div>
        <span class="mt-1">
            <x-icons.arrow-down />
        </span>
        <div class="flex-1 h-px bg-gray-200 dark:bg-gray-600"></div>
    </div>

    <form class="mt-6" method="POST" action="{{ route('register') }}" x-data="{ loading: false }"
        @submit="loading = true">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" value="Tên" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required
                autofocus autocomplete="name" placeholder="Nhập tên của bạn" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div class="mt-4">
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autocomplete="username" placeholder="Nhập email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <x-password-input name="password" label="Mật khẩu" placeholder="Tối thiểu 8 ký tự" />

        <!-- Confirm Password -->
        <x-password-input name="password_confirmation" label="Xác nhận mật khẩu" placeholder="Xác nhận mật khẩu"
            :strength="false" :confirm="true" />

        <!-- Action -->
        <div class="mt-6 space-y-5">

            <!-- Register -->
            <x-primary-button class="w-full flex justify-center items-center gap-2 hover:cursor-pointer"
                x-bind:disabled="loading" x-bind:class="{ 'opacity-50 cursor-not-allowed': loading }">
                <x-icons.loading />

                <span x-text="loading ? 'Đang tạo tài khoản...' : 'Đăng ký'"></span>
            </x-primary-button>

            <!-- Divider -->
            <div class="flex items-center gap-3 text-xs text-gray-400">
                <div class="flex-1 h-px bg-gray-200"></div>
                <span class="text-gray-400">hoặc tiếp tục với</span>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            <!-- Social -->
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
                    class="flex items-center justify-center gap-2 border border-orange-300 rounded-lg py-2.5
        hover:bg-gray-50 hover:border-orange-400 hover:text-orange-500 transition text-sm font-medium dark:text-gray-300 dark:bg-gray-800">
                    <x-icons.github />
                    GitHub
                </a>
            </div>

            <!-- Login -->
            <div class="text-center text-sm text-gray-500 dark:text-gray-400">
                Đã có tài khoản?
                <a href="{{ route('login') }}" class="text-orange-500 font-medium hover:underline">
                    Đăng nhập
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
