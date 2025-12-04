@props([
'variant' => 'primary',
'href' => null,
'type' => 'submit',
'fullWidth' => false,
])

@php
// Base Classes
$baseClasses = 'inline-flex items-center justify-center px-5 py-2.5 gap-2 rounded-xl font-bold text-sm transition-all
duration-200 focus:outline-none focus:ring-2 focus:ring-offset-1 disabled:opacity-50 disabled:cursor-not-allowed';

// Variant Colors
$variants = [
'primary' => 'bg-primary text-white hover:bg-emerald-800 focus:ring-primary shadow-lg shadow-primary/20 border
border-transparent',
'primary-ghost' => 'text-primary hover:bg-primary/5 hover:text-primary border border-primary/20 focus:ring-primary/20',
'secondary' => 'bg-white text-slate-700 border border-slate-200 hover:bg-slate-50 hover:text-primary
focus:ring-slate-200',
'secondary-ghost' => 'text-slate-700 hover:bg-slate-50 hover:text-primary border border-slate-200 focus:ring-slate-200',
'accent' => 'bg-accent text-slate-900 hover:bg-yellow-400 focus:ring-accent shadow-lg shadow-yellow-900/20 border
border-transparent',
'accent-ghost' => 'text-accent hover:bg-accent/5 hover:text-accent border border-accent/20 focus:ring-accent/20',
'info' => 'bg-sky-600 text-white hover:bg-sky-700 focus:ring-sky-500 border border-transparent',
'info-ghost' => 'text-sky-600 hover:bg-sky-50 hover:text-sky-700 border border-sky-200 focus:ring-sky-200',
'success' => 'bg-emerald-600 text-white hover:bg-emerald-700 focus:ring-emerald-500 border border-transparent',
'success-ghost' => 'text-emerald-600 hover:bg-emerald-50 hover:text-emerald-700 border border-emerald-200
focus:ring-emerald-200',
'warning' => 'bg-yellow-400 text-slate-900 hover:bg-yellow-500 focus:ring-yellow-400 border border-transparent',
'warning-ghost' => 'text-yellow-400 hover:bg-yellow-50 hover:text-yellow-500 border border-yellow-200
focus:ring-yellow-200',
'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500 border border-transparent',
'danger-ghost' => 'text-red-600 hover:bg-red-50 hover:text-red-700 border border-red-200 focus:ring-red-200',
'ghost' => 'bg-transparent text-slate-600 hover:bg-primary/5 hover:text-primary border border-transparent',
];

$variantClass = $variants[$variant] ?? $variants['primary'];
$widthClass = $fullWidth ? 'w-full' : '';
$classes = "$baseClasses $variantClass $widthClass";

// --- LOGIKA BARU ---
// Cek apakah button ini memiliki wire:target atau wire:click
// Jika ya, kita anggap button ini butuh indikator loading.
$hasWireTarget = $attributes->whereStartsWith('wire:target')->isNotEmpty();
$hasWireClick = $attributes->whereStartsWith('wire:click')->isNotEmpty();

// Loading aktif jika ada wire:target ATAU wire:click
$enableLoading = $hasWireTarget || $hasWireClick;
@endphp

@if ($href)
<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
    @if (isset($icon_right))
    <span class="shrink-0">{{ $icon_right }}</span>
    @endif
</a>
@else
<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}
    {{-- Render atribut disabled hanya jika loading diaktifkan --}}
    {{ $enableLoading ? 'wire:loading.attr=disabled' : '' }}
    >
    {{-- Render Spinner hanya jika loading diaktifkan --}}
    @if($enableLoading)
    <svg wire:loading {{-- Jika ada wire:target spesifik, tambahkan ke svg juga (opsional, tapi lebih akurat) --}}
        @if($hasWireTarget) {{ $attributes->whereStartsWith('wire:target') }} @endif
        class="animate-spin -ml-1 h-4 w-4 text-current"
        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor"
            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
        </path>
    </svg>
    @endif

    @if (isset($icon_left))
    {{-- Tambahkan wire:loading.remove hanya jika loading aktif --}}
    <span @if($hasWireTarget) wire:loading.remove @endif class="shrink-0">
        {{ $icon_left }}
    </span>
    @endif

    <span>{{ $slot }}</span>

    @if (isset($icon_right))
    <span @if($hasWireTarget) wire:loading.remove @endif class="shrink-0">
        {{ $icon_right }}
    </span>
    @endif
</button>
@endif
