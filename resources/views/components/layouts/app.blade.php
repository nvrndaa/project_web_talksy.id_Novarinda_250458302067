<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Talksy.id' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">


    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-surface font-sans text-slate-600 antialiased" x-data="dashboardLogic()">
     <livewire:toasts />

    <div class="flex h-screen overflow-hidden">

        {{-- Sidebar Navigasi Dinamis --}}
        <x-nav.sidebar />

        {{-- Konten Utama --}}
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

            {{-- Topbar Navigasi --}}
            <x-nav.topbar />

            {{-- Slot untuk Konten Halaman Livewire --}}
            <main class="flex-1 overflow-y-auto p-4 lg:p-8">
                {{ $slot }}
            </main>
        </div>
    </div>

    @livewireScripts
</body>
</html>
