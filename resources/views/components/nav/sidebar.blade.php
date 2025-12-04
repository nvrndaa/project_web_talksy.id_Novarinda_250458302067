{{-- Overlay untuk mobile --}}
<div x-show="isSidebarOpen" @click="isSidebarOpen = false"
    x-transition:enter="transition-opacity ease-linear duration-300" x-transition:enter-start="opacity-0"
    x-transition:leave="transition-opacity ease-linear duration-300" x-transition:leave-end="opacity-0"
    class="fixed inset-0 bg-slate-900/50 z-40 lg:hidden backdrop-blur-sm">
</div>

{{-- Konten Sidebar --}}
<aside :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-200 transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 flex flex-col shadow-2xl lg:shadow-none">

    {{-- Logo --}}
    <div class="h-16 flex items-center px-6 border-b border-slate-100 shrink-0">
        <a href="{{ auth()->user()?->role === \App\Enums\UserRole::ADMIN ? route('admin.dashboard') : route('student.dashboard') }}"
            wire:navigate class="flex items-center gap-2">
            <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-white">
                <x-phosphor-chat-circle-text-bold class="icon-size-md" />
            </div>
            <span class="text-xl font-bold text-primary tracking-tight">Talksy<span
                    class="text-accent">.id</span></span>
        </a>
    </div>

    <div class="flex-1 overflow-y-auto py-4 px-3 space-y-1 no-scrollbar">
        @if(!empty($navigationMenu()))
        @foreach ($navigationMenu() as $item)
        @if(isset($item['is_header']))
        <div class="px-3 my-2 text-xs font-bold text-slate-400 uppercase tracking-wider">{{ $item['label'] }}</div>
        @elseif(isset($item['is_divider']))
        <div class="my-4 border-t border-slate-100"></div>
        @else
        <x-nav.menu-item :item="$item" />
        @endif
        @endforeach
        @endif
    </div>

    {{-- User Footer --}}
    <div class="p-4 border-t border-slate-100 bg-slate-50/50 shrink-0">
        @auth
        <div class="flex items-center gap-3">
            <img src="{{ auth()->user()->avatar_url ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=065F46&color=fff' }}"
                class="w-10 h-10 rounded-full border-2 border-white shadow-sm" alt="User">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-bold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                <p class="text-xs text-slate-500 capitalize">{{ auth()->user()->role->value }}</p>
            </div>
            <button class="text-slate-400 hover:text-red-500 transition">
                <x-phosphor-sign-out class="icon-size-lg" />
            </button>
        </div>
        @endauth
    </div>
</aside>
