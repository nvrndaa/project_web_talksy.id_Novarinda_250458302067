<div class="w-full max-w-lg">
    <div class="card p-6 lg:p-8 text-center">
        <h1 class="text-2xl font-bold text-slate-800">Verifikasi Sertifikat</h1>
        <p class="text-slate-500 mt-2 mb-6">
            Masukkan kode unik yang tertera pada sertifikat untuk memeriksa keasliannya.
        </p>

        <form wire:submit.prevent="verify" class="space-y-4">
            {{-- Input Kode Sertifikat --}}
            <div>
                <input type="text" wire:model.defer="code" placeholder="Contoh: TSY-2-202512-ABCDEFGH"
                       class="form-input w-full text-center tracking-wider"
                       autofocus
                >
                @error('code') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            {{-- Tombol Submit --}}
            <x-button type="submit" variant="primary" full-width="true" wire:target="verify">
                <x-slot:icon_left>
                    <x-phosphor-check-square-offset-bold class="w-5 h-5"/>
                </x-slot:icon_left>
                Cek Validitas
            </x-button>
        </form>

        {{-- Area Hasil Verifikasi --}}
        @if ($searched)
            <div class="mt-8 pt-6 border-t border-slate-200">
                @if ($certificate)
                    {{-- Hasil: Sertifikat Ditemukan dan Valid --}}
                    <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 text-left">
                        <div class="flex items-center gap-3">
                             <x-phosphor-seal-check-fill class="w-8 h-8 text-emerald-500 shrink-0"/>
                             <div>
                                <h3 class="text-lg font-bold text-emerald-800">Sertifikat Sah</h3>
                                <p class="text-sm text-emerald-700">Diterbitkan untuk <strong>{{ $certificate->user->name }}</strong> pada tanggal <strong>{{ $certificate->issued_at->format('d F Y') }}</strong>.</p>
                             </div>
                        </div>
                    </div>
                @else
                    {{-- Hasil: Sertifikat Tidak Ditemukan --}}
                     <div class="bg-red-50 border-l-4 border-red-500 p-4 text-left">
                        <div class="flex items-center gap-3">
                             <x-phosphor-x-circle-fill class="w-8 h-8 text-red-500 shrink-0"/>
                             <div>
                                <h3 class="text-lg font-bold text-red-800">Sertifikat Tidak Ditemukan</h3>
                                <p class="text-sm text-red-700">Pastikan kode yang Anda masukkan sudah benar dan coba lagi.</p>
                             </div>
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <p class="text-center text-sm text-slate-500 mt-6">
        Kembali ke <a href="{{ route('home') }}" wire:navigate class="font-semibold text-primary hover:underline">Halaman Utama</a>.
    </p>
</div>
