@props(['item'])

@php
$isActive = false;
// Cek apakah rute item utama aktif
if (isset($item['route']) && $item['route'] !== '#' && request()->routeIs($item['route'])) {
$isActive = true;
}

// Jika tidak, cek apakah ada rute anak yang aktif (untuk dropdown)
if (!$isActive && isset($item['children'])) {
foreach ($item['children'] as $child) {
if (isset($child['route']) && $child['route'] !== '#' && request()->routeIs($child['route'])) {
$isActive = true;
break;
}
}
}
@endphp

@if(empty($item['children']))
{{-- Tautan Biasa --}}
<a href="{{ $item['route'] === '#' ? '#' : route($item['route']) }}" @if($item['route'] !=='#' ) wire:navigate @endif
    @class([ 'flex items-center gap-3 px-3 py-2.5 rounded-lg transition-colors group'
    , 'bg-primary-light text-primary font-semibold'=> $isActive, // Style aktif
    'text-slate-600 hover:bg-slate-50 hover:text-primary' => !$isActive,
    ])>
    <x-dynamic-component :component="$item['icon']" @class(['icon-size-md', 'group-hover:text-primary'=> !$isActive]) />
        <span>{{ $item['label'] }}</span>
</a>
@else
{{-- Dropdown --}}
<div x-data="{ open: @json($isActive) }">
    <button @click="open = !open"
        @class([ 'w-full flex items-center justify-between px-3 py-2.5 rounded-lg transition-colors group'
        , 'text-slate-600 hover:bg-slate-50 hover:text-primary' , 'text-primary'=> $isActive
        ])>
        <div class="flex items-center gap-3">
            <x-dynamic-component :component="$item['icon']" @class(['icon-size-md
                group-hover:text-primary', 'text-primary'=> $isActive]) />
                <span>{{ $item['label'] }}</span>
        </div>
        <x-phosphor-caret-down-bold class="icon-size-normal transition-transform duration-200"
            @:class="open ? 'rotate-180' : ''" />

    </button>

    <div x-show="open" x-collapse.duration.300ms class="pl-10 mt-1 space-y-1">
        @foreach($item['children'] as $child)
        <a href="{{ $child['route'] === '#' ? '#' : route($child['route']) }}" @if($child['route'] !=='#' )
            wire:navigate @endif @class([ 'block px-3 py-2 text-sm rounded-lg' , 'text-primary font-semibold'=>
            (isset($child['route']) && $child['route'] !== '#' && request()->routeIs($child['route'])),
            'text-slate-500 hover:text-primary hover:bg-slate-50' => !(isset($child['route']) && $child['route'] !== '#'
            && request()->routeIs($child['route'])),
            ])>
            {{ $child['label'] }}
        </a>
        @endforeach
    </div>
</div>
@endif
