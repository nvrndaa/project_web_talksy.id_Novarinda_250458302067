<header
    class="h-16 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center justify-between px-4 lg:px-8 sticky top-0 z-30">

    <div class="flex items-center gap-4">
        {{-- Tombol Buka Sidebar di Mobile --}}
        <button @click="isSidebarOpen = true" class="lg:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100">
            <x-phosphor-list-bold class="icon-size-normal" />
        </button>
{{-- Breadcrumb Dinamis --}}
        <x-breadcrumb />
    </div>

    <div class="flex items-center gap-3 sm:gap-4">
        <div class="h-6 w-px bg-slate-200 hidden sm:block"></div>

        {{-- Dropdown User Menu --}}
        @auth
        <div class="flex items-center gap-2 cursor-pointer" x-data="{ open: false }" @click.away="open = false">
            <button @click="open = !open" class="flex items-center gap-2 focus:outline-none">
                <span class="text-sm font-semibold text-slate-700 hidden sm:block">Halo, {{
                    Str::words(auth()->user()->name, 1, '') }}</span>
                <x-phosphor-caret-down-bold class="text-slate-400 icon-size-normal" />
            </button>

            <div x-show="open" x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-75"
                x-transition:leave-start="transform opacity-100 scale-100"
                x-transition:leave-end="transform opacity-0 scale-95"
                class="absolute right-4 top-14 w-48 bg-white rounded-xl shadow-lg border border-slate-100 py-1 z-50">
{{-- <a href="{{ route('account.settings') }}"
                    class="block px-4 py-2 text-sm text-slate-600 hover:bg-primary/5 hover:text-primary">My
                    Profile</a> --}}
                {{-- <a href="#" class="block px-4 py-2 text-sm text-slate-600 hover:bg-primary/5 hover:text-primary">Support</a> --}}
                <div class="border-t border-slate-100 my-1"></div>
                {{-- Form untuk logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
        @endauth
    </div>
</header>
