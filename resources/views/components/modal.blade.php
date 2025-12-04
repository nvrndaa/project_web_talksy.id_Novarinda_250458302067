@props([
'id' => 'default-modal',
'maxWidth' => 'lg',
'title' => '',
])

@php
$maxWidths = [
'sm' => '20rem',
'md' => '28rem',
'lg' => '32rem',
'xl' => '38rem',
'2xl' => '44rem',
];
$widthStyle = $maxWidths[$maxWidth] ?? $maxWidths['lg'];
@endphp

{{--
PERBAIKAN:
Menggunakan logic hybrid pada x-data.
Jika ada attributes->wire('model'), gunakan @entangle.
Jika tidak, gunakan false sebagai default.
--}}
<div x-data="{
        show: @if($attributes->wire('model')->value()) @entangle($attributes->wire('model')) @else false @endif
    }" x-show="show" x-on:open-modal.window="if ($event.detail.id === '{{ $id }}') show = true"
    x-on:close-modal.window="show = false" x-on:keydown.escape.window="show = false" class="modal-backdrop"
    style="display: none;">

    {{-- Modal Content Container --}}
    <div x-show="show" x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="modal-content"
        @click.away="show = false" style="max-width: {{ $widthStyle }}; width: 100%;">

        {{-- Modal Header --}}
        <div class="modal-header">
            <h3 class="modal-title">{{ $title }}</h3>
            {{-- Tambahkan show = false untuk menutup via entangle --}}
            <button type="button" @click="show = false" class="modal-close-btn">
                <x-phosphor-x-bold class="icon-size-md" />
            </button>
        </div>

        <div class="modal-body">
            {{ $slot }}
        </div>

        @if(isset($footer))
        <div class="modal-footer">
            {{ $footer }}
        </div>
        @endif
    </div>
</div>
