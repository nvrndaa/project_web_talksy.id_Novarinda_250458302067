@props(['links' => []])

<nav class="fixed w-full z-50 transition-all duration-300" x-data="{ isScrolled: window.pageYOffset > 20 }"
    :class="{ 'glass-effect py-3': isScrolled, 'bg-transparent py-5': !isScrolled }"
    @scroll.window="isScrolled = (window.pageYOffset > 20)">
    <div class="container flex justify-between items-center">
        <a href="{{ route('home') }}" wire:navigate class="flex items-center gap-2">
            <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-white font-bold">T</div>
            <span class="text-xl font-bold tracking-tight text-primary">Talksy<span
                    class="text-accent">.id</span></span>
        </a>
        <div class="hidden md:flex gap-8">
            @foreach ($links as $link)
            <a href="{{ $link['href'] }}" class="nav-link">{{ $link['text'] }}</a>
            @endforeach
        </div>
        <div class="flex gap-3 items-center">
            @if(Route::has('login'))
            @auth
            <x-button href="{{ route('admin.dashboard') }}" variant="primary" wire:navigate>Dashboard</x-button>
            @else
            <x-button href="{{ route('login') }}" variant="primary-ghost" wire:navigate>Masuk</x-button>
            <x-button href="{{ route('register') }}" variant="primary" class="text-sm shadow-lg" wire:navigate>Daftar
                Sekarang</x-button>
            @endauth
            @endif
        </div>
    </div>
</nav>
