@php
    /* @var \Prezet\Prezet\Data\FrontmatterData $fm */
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>{{ $fm->title }} | OG Image</title>

    <meta name="robots" content="noindex" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;700;900&display=swap"
        rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css'])

    <style>
        body {
            width: 1200px;
            height: 630px;
            margin: 0;
            padding: 0;
            overflow: hidden;
            background-color: #0F172A;
            /* Dark Blue from spec */
        }

        .og-container {
            width: 1200px;
            height: 630px;
            position: relative;
            display: flex;
            flex-direction: column;
            padding: 100px;
            /* 100px margin as per safe area spec */
            box-sizing: border-box;
            background-image:
                radial-gradient(circle at 0% 0%, rgba(234, 88, 12, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 100% 100%, rgba(234, 88, 12, 0.1) 0%, transparent 50%);
        }

        /* Abstract Grid Pattern */
        .og-grid {
            position: absolute;
            inset: 0;
            background-image: radial-gradient(rgba(255, 255, 255, 0.05) 1px, transparent 1px);
            background-size: 40px 40px;
            z-index: 0;
        }

        .og-content {
            position: relative;
            z-index: 10;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
    </style>
</head>

<body class="font-['Be_Vietnam_Pro'] antialiased">
    <div class="og-container">
        <div class="og-grid"></div>

        <div class="og-content">
            {{-- Top Section: Category --}}
            <div>
                @if ($fm->category)
                    <span
                        class="inline-flex items-center rounded-3xl bg-primary-600/20 px-4 py-2 text-xl font-black uppercase tracking-[0.2em] text-primary-500 ring-1 ring-inset ring-primary-500/30">
                        {{ $fm->category }}
                    </span>
                @endif
            </div>

            {{-- Center Section: Main Title --}}
            <div class="flex flex-col gap-6">
                <h1 class="text-7xl font-black leading-[1.1] tracking-tight text-white line-clamp-2">
                    {{ $fm->title }}
                </h1>

                @if ($fm->excerpt)
                    <p class="text-3xl font-medium leading-relaxed text-slate-400 line-clamp-2 max-w-[900px]">
                        {{ $fm->excerpt }}
                    </p>
                @endif
            </div>

            {{-- Bottom Section: Branding --}}
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div
                        class="flex h-12 w-12 items-center justify-center rounded-3xl bg-slate-800/50 p-2 ring-1 ring-white/10">
                        <x-prezet.logo />
                    </div>
                    <span class="text-3xl font-bold tracking-tight text-white">
                        tuantq.online
                    </span>
                </div>

                {{-- Decorative Tech Element --}}
                <div class="flex gap-2">
                    <div class="h-2 w-8 rounded-full bg-primary-600"></div>
                    <div class="h-2 w-2 rounded-full bg-primary-600/50"></div>
                    <div class="h-2 w-2 rounded-full bg-primary-600/20"></div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
