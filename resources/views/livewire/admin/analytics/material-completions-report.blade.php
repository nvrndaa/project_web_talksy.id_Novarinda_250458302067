<div>
    <h1 class="text-3xl font-bold text-slate-800 mb-6">Laporan Progres Materi</h1>

    <div class="card p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-4">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari nama siswa, materi, atau modul..."
                    class="form-input w-96" />
            </div>
        </div>

        @if($completions->isEmpty())
        <div class="text-center py-10 text-muted">
            <x-phosphor-info-bold class="icon-size-xl mx-auto mb-3" />
            <p>Belum ada materi yang diselesaikan oleh siswa.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="text-slate-500 border-b border-slate-200">
                        <th scope="col" class="px-3 py-3 font-semibold">Siswa</th>
                        <th scope="col" class="px-3 py-3 font-semibold">Materi</th>
                        <th scope="col" class="px-3 py-3 font-semibold">Tanggal Selesai</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($completions as $completion)
                    <tr class="border-b border-slate-100 hover:bg-slate-50">
                        <td class="px-3 py-3">
                            <p class="font-semibold text-slate-800">{{ $completion->user->name }}</p>
                            <p class="text-xs text-muted">{{ $completion->user->email }}</p>
                        </td>
                        <td class="px-3 py-3">
                            <p class="font-semibold text-slate-800">{{ $completion->material->title }}</p>
                            <p class="text-xs text-muted">Modul: {{ $completion->material->module->title ?? 'N/A' }}</p>
                        </td>
                        <td class="px-3 py-3">
                            {{ $completion->created_at->format('d M Y, H:i') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $completions->links() }}
        </div>
        @endif
    </div>
</div>
