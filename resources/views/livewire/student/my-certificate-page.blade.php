<div>
    <div class="bg-white rounded-2xl shadow-lg p-6 lg:p-8">
        @if ($certificate)
            {{-- Tampilan Jika Sertifikat SUDAH ADA --}}
            <div class="text-center">
                <div class="inline-block p-4 bg-emerald-100 rounded-full mb-4">
                    <x-phosphor-seal-check-bold class="w-12 h-12 text-primary" />
                </div>
                <h1 class="text-2xl font-bold text-slate-800 mb-2">Selamat, {{ auth()->user()->name }}!</h1>
                <p class="text-slate-500 max-w-xl mx-auto mb-6">
                    Anda telah berhasil menyelesaikan seluruh rangkaian kursus di Talks-y.id. Ini adalah bukti dedikasi dan pencapaian Anda.
                </p>

                {{-- Card Sertifikat --}}
                <div class="bg-slate-50 border border-slate-200 rounded-xl p-8 max-w-2xl mx-auto text-left mb-8">
                    <div class="flex justify-between items-start mb-6">
                        <div>
                            <p class="text-sm text-slate-400">Sertifikat Kelulusan</p>
                            <h2 class="text-xl font-bold text-primary">English for Professionals</h2>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-white font-bold">T</div>
                            <span class="text-lg font-bold tracking-tight text-primary">Talksy<span class="text-accent">.id</span></span>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs text-slate-500 font-semibold">Diberikan kepada:</p>
                            <p class="font-medium text-slate-700">{{ auth()->user()->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-semibold">Tanggal Terbit:</p>
                            <p class="font-medium text-slate-700">{{ $certificate->issued_at->format('d F Y') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 font-semibold">Kode Sertifikat Unik:</p>
                            <p class="font-mono text-sm text-slate-700 bg-slate-200 px-2 py-1 rounded inline-block">{{ $certificate->certificate_code }}</p>
                        </div>
                    </div>
                </div>

                {{-- Tombol Aksi --}}
                <div class="flex justify-center gap-4">
                    <x-button wire:click="downloadCertificate" wire:target="downloadCertificate" variant="primary" class="text-base">
                        <x-slot:icon_left>
                            <x-phosphor-download-simple-bold class="w-5 h-5" />
                        </x-slot:icon_left>
                        Unduh PDF
                    </x-button>
                    <x-button variant="secondary-ghost">
                        Bagikan
                    </x-button>
                </div>
            </div>
        @else
            {{-- Tampilan Jika Sertifikat BELUM ADA --}}
            <div class="text-center max-w-lg mx-auto">
                <div class="inline-block p-4 bg-yellow-100 rounded-full mb-4">
                    <x-phosphor-certificate-duotone class="w-12 h-12 text-yellow-600" />
                </div>
                <h1 class="text-2xl font-bold text-slate-800 mb-2">Selesaikan Kursus Untuk Membuka Sertifikat</h1>
                <p class="text-slate-500 mb-6">
                    Anda belum menyelesaikan semua materi dan kuis yang dibutuhkan. Teruslah belajar dan kembali ke halaman ini setelah semua progres Anda 100%.
                </p>
                <x-button href="{{ route('student.dashboard') }}" wire:navigate variant="primary" class="text-base">
                    <x-slot:icon_left>
                        <x-phosphor-arrow-left-bold class="w-5 h-5" />
                    </x-slot:icon_left>
                    Kembali ke Dashboard
                </x-button>
            </div>
        @endif
    </div>
</div>
