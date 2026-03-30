<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="alternate icon" type="image/png" href="/favicon.ico">
    <link rel="apple-touch-icon" href="/favicon.svg">

    <x-prezet.meta />

    <!-- Fonts Preload -->
    <link rel="preload" href="/build/assets/be-vietnam-pro-v12-latin_vietnamese-regular-CnRXpc0c.woff2" as="font"
        type="font/woff2" crossorigin>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('jsonld')

    <script>
        (function () {
            const stored = localStorage.getItem('theme')
            const prefersDark = window.matchMedia(
                '(prefers-color-scheme: dark)'
            ).matches
            const useDark =
                stored === 'dark' || (stored === null && prefersDark)

            if (useDark) {
                document.documentElement.classList.add('dark')
            }
        })()
    </script>
    <style>
        @keyframes gradientMove {

            0%,
            100% {
                transform: translate(0, 0);
            }

            50% {
                transform: translate(20px, -20px);
            }
        }
    </style>
</head>

<body
    class="relative font-sans antialiased bg-white dark:bg-zinc-950 selection:bg-zinc-900 selection:text-white dark:selection:bg-white dark:selection:text-zinc-900">

    <div class="fixed inset-0 -z-10 overflow-hidden">

        <!-- Gradient base -->
        <div class="absolute inset-0
    bg-linear-to-br
    from-orange-300/20
    via-amber-100/20
    to-rose-100/20
    dark:from-orange-400/10
    dark:via-amber-100/10
    dark:to-rose-100/10">
        </div>

        <!-- Glow blobs -->
        <!-- Blob 1 -->
        <div class="absolute top-[-10%] left-[-10%] w-125 h-125
    bg-orange-500/30 rounded-full blur-3xl opacity-30
    animate-[gradientMove_12s_ease-in-out_infinite]">
        </div>

        <!-- Blob 2 -->
        <div class="absolute bottom-[-10%] right-[-10%] w-125 h-125
    bg-amber-400/30 rounded-full blur-3xl opacity-30
    animate-[gradientMove_16s_ease-in-out_infinite]">
        </div>

        <!-- Blob 3 -->
        <div class="absolute top-[30%] left-[60%] w-100 h-100
    bg-rose-400/25 rounded-full blur-3xl opacity-30
    animate-[gradientMove_20s_ease-in-out_infinite]">
        </div>
        <div class="absolute inset-0
    bg-[radial-gradient(circle_at_center,rgba(249,115,22,0.15),transparent_70%)]">
        </div>
    </div>

    <div class="min-h-screen flex flex-col transition-colors duration-300">
        <main class="grow max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
                <div>
                    <a href="/">
                        <x-prezet.logo class="w-16 h-16 fill-current text-gray-500" />
                    </a>
                </div>

                <div class="w-full sm:max-w-md mt-6 px-10 py-10
    bg-white/90 dark:bg-zinc-900/70
    backdrop-blur-xl
    shadow-2xl
    overflow-hidden sm:rounded-3xl
    border border-white/20 dark:border-zinc-800/50">
                    {{ $slot }}
                </div>
                <div class="w-full sm:max-w-md mt-4">
                    <a href="{{ url('/') }}"
                        class="inline-flex items-center gap-2 text-sm text-gray-700 dark:text-gray-100 hover:text-orange-500 transition group">

                        <!-- Arrow icon -->
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>

                        <span>Quay lại trang chủ</span>
                    </a>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('form', {
                password: ''
            })

            Alpine.data('passwordField', (config) => ({
                show: false,

                value: '',
                debouncedValue: '',

                checking: false,
                timeout: null,

                config,

                init() {
                    if (!this.config.confirm) {
                        this.$watch('value', (val) => {
                            this.$store.form.password = val
                        })
                    }
                },

                get isConfirm() {
                    return this.config.confirm
                },

                toggle() {
                    this.show = !this.show
                },

                handleInput() {
                    clearTimeout(this.timeout)
                    const password = this.$store.form.password || ''
                    if (this.value.length === 0 || this.value.length < password.length) {
                        this.debouncedValue = this.value
                        this.checking = false
                        return
                    }
                    this.checking = true

                    this.timeout = setTimeout(() => {
                        this.debouncedValue = this.value
                        this.checking = false
                    }, 300)
                },

                get showState() {
                    const password = this.$store.form.password || ''

                    return this.debouncedValue.length > 0 &&
                        this.debouncedValue.length === password.length
                },

                get matchState() {
                    if (!this.showState) return {
                        ok: false
                    }

                    return {
                        ok: this.debouncedValue === this.$store.form.password
                    }
                },

                get strengthState() {
                    if (!this.config.strength || !this.debouncedValue) {
                        return {
                            label: '',
                            color: ''
                        }
                    }

                    let value = this.debouncedValue
                    let score = 0

                    if (value.length >= 8) score++
                    if (/[A-Z]/.test(value)) score++
                    if (/[0-9]/.test(value)) score++
                    if (/[^A-Za-z0-9]/.test(value)) score++

                    if (score <= 1) return {
                        label: 'Yếu',
                        color: 'text-red-500'
                    }
                    if (score === 2) return {
                        label: 'Trung bình',
                        color: 'text-yellow-500'
                    }

                    return {
                        label: 'Mạnh',
                        color: 'text-green-500'
                    }
                }
            }))
        })
    </script>

</body>

</html>
