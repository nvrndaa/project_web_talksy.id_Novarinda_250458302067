<nav {{ $attributes->merge(['class' => 'hidden sm:flex text-sm font-medium text-slate-500']) }}>
    @forelse ($crumbs as $index => $crumb)
        @if (!$loop->first)
            <span class="mx-2 text-slate-300">/</span>
        @endif

        @if (!$loop->last && $crumb['url'])
            <a href="{{ $crumb['url'] }}" class="hover:text-primary transition-colors" wire:navigate>
                {{ $crumb['label'] }}
            </a>
        @else
            <span class="text-primary font-bold">
                {{ $crumb['label'] }}
            </span>
        @endif
    @empty
        {{-- Jika tidak ada breadcrumb, bisa tampilkan default atau kosong --}}
        <span class="text-primary font-bold">Dashboard</span>
    @endforelse
</nav>
