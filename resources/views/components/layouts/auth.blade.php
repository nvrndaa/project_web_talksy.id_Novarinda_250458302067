<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Talksy.id' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-slate-50 text-dark font-sans antialiased">
    <livewire:toasts />

    <div class="relative min-h-screen flex items-center justify-center p-4">
        {{-- Background Pattern --}}
        <div class="absolute inset-0 opacity-5 pointer-events-none">
            <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="islamic-geo" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M0 20 L20 0 L40 20 L20 40 Z" fill="none" stroke="currentColor" stroke-width="0.5" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#islamic-geo)" class="text-primary" />
            </svg>
        </div>

        <main class="relative z-10">
            {{-- Logo --}}
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" wire:navigate class="inline-flex items-center gap-2">
                    <div
                        class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center text-white font-bold text-xl">
                        T</div>
                    <span class="text-2xl font-bold tracking-tight text-primary">Talksy<span
                            class="text-accent">.id</span></span>
                </a>
            </div>

            {{-- Slot untuk form (Login/Register/dll) --}}
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>

</html>
