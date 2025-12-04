<div>
    <h1 class="text-3xl font-bold text-slate-800 mb-6">Laporan Hasil Kuis</h1>

    <div class="card p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-4">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama siswa atau kuis..."
                    class="form-input w-72" />

{{-- <div class="w-48">
                    <x-forms.custom-select :options="$this->statusOptions" wire-model="filterStatus" placeholder="Pilih Status" />
                </div> --}}
                </div>
        </div>

        @if($attempts->isEmpty())
        <div class="text-center py-10 text-muted">
            <x-phosphor-info-bold class="icon-size-xl mx-auto mb-3" />
            <p>Belum ada riwayat pengerjaan kuis yang tercatat.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="text-slate-500 border-b border-slate-200">
                        <th scope="col" class="px-3 py-3 font-semibold">Siswa</th>
                        <th scope="col" class="px-3 py-3 font-semibold">Kuis</th>
                        <th scope="col" class="px-3 py-3 font-semibold text-center">Nilai</th>
                        <th scope="col" class="px-3 py-3 font-semibold text-center">Status</th>
                        <th scope="col" class="px-3 py-3 font-semibold">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($attempts as $attempt)
                    <tr class="border-b border-slate-100 hover:bg-slate-50">
                        <td class="px-3 py-3">
                            <p class="font-semibold text-slate-800">{{ $attempt->user->name }}</p>
                            <p class="text-xs text-muted">{{ $attempt->user->email }}</p>
                        </td>
                        <td class="px-3 py-3">
                            <p class="font-semibold text-slate-800">{{ $attempt->quiz->title }}</p>
                            <p class="text-xs text-muted">Modul: {{ $attempt->quiz->module->title ?? 'N/A' }}</p>
                        </td>
<td class="px-3 py-3 text-center font-bold text-xl {{ $attempt->is_passed ? 'text-emerald-600' : 'text-red-600' }}">
                            {{ $attempt->score }}
                        </td>
                        <td class="px-3 py-3 text-center">
                            @if($attempt->is_passed)
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-medium text-emerald-700">Lulus</span>
                            @else
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-700">Gagal</span>
                            @endif
                        </td>
                        <td class="px-3 py-3">
                            {{ $attempt->created_at->format('d M Y, H:i') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $attempts->links() }}
        </div>
        @endif
    </div>
</div>
