<div>
    <h1 class="text-3xl font-bold text-slate-800 mb-6">Daftar Sertifikat</h1>

    <div class="card p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-4">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama siswa atau kode sertifikat..."
                    class="form-input w-96" />
            </div>
        </div>

        @if($certificates->isEmpty())
        <div class="text-center py-10 text-muted">
            <x-phosphor-info-bold class="icon-size-xl mx-auto mb-3" />
            <p>Belum ada sertifikat yang diterbitkan.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="text-slate-500 border-b border-slate-200">
                        <th scope="col" class="px-3 py-3 font-semibold">Siswa</th>
                        <th scope="col" class="px-3 py-3 font-semibold">Kode Sertifikat</th>
                        <th scope="col" class="px-3 py-3 font-semibold">Tanggal Terbit</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($certificates as $certificate)
                    <tr class="border-b border-slate-100 hover:bg-slate-50">
                        <td class="px-3 py-3">
                            <p class="font-semibold text-slate-800">{{ $certificate->user->name }}</p>
                            <p class="text-xs text-muted">{{ $certificate->user->email }}</p>
                        </td>
                        <td class="px-3 py-3">
                            <code class="font-mono text-primary">{{ $certificate->certificate_code }}</code>
                        </td>
                        <td class="px-3 py-3">
                            {{ $certificate->issued_at->format('d M Y, H:i') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $certificates->links() }}
        </div>
        @endif
    </div>
</div>
