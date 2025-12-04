<div>
    <h1 class="text-3xl font-bold text-slate-800 mb-6">Manajemen Modul</h1>

    <div class="card p-6">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-4">
                <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari modul..."
                    class="form-input w-72" />
            </div>
            <x-button variant="primary" wire:target="openCreateModal" wire:click="openCreateModal">
                <x-slot:icon_left>
                    <x-phosphor-plus-bold class="w-4 h-4" />
                </x-slot:icon_left>
                Tambah
            </x-button>
        </div>

        @if($modules->isEmpty())
        <div class="text-center py-10 text-muted">
            <x-phosphor-info-bold class="icon-size-xl mx-auto mb-3" />
            <p>Belum ada modul yang terdaftar.</p>
        </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm whitespace-nowrap">
                <thead>
                    <tr class="text-slate-500 border-b border-slate-200">
                        <th scope="col" class="px-3 py-3 font-semibold">#</th>
                        <th scope="col" class="px-3 py-3 font-semibold">Judul Modul</th>
                        <th scope="col" class="px-3 py-3 font-semibold">Materi</th>
                        <th scope="col" class="px-3 py-3 font-semibold">Status</th>
                        <th scope="col" class="px-3 py-3 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($modules as $module)
                    <tr class="border-b border-slate-100 hover:bg-slate-50">
                        <td class="px-3 py-3">{{ $module->order_index }}</td>
                        <td class="px-3 py-3">
                            <p class="font-semibold text-slate-800">{{ $module->title }}</p>
                            <p class="text-xs text-muted line-clamp-1">{{ $module->description }}</p>
                        </td>
                        <td class="px-3 py-3">{{ $module->materials_count }} Materi</td>
                        <td class="px-3 py-3">
                            @if($module->is_active)
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2 py-0.5 text-xs font-medium text-emerald-700">Aktif</span>
                            @else
                            <span
                                class="inline-flex items-center gap-1 rounded-full bg-red-100 px-2 py-0.5 text-xs font-medium text-red-700">Nonaktif</span>
                            @endif
                        </td>
                                                        <td class="px-3 py-3 text-right">
                                                            <div class="flex justify-end gap-2">
                                                                <a href="{{ route('admin.modules.show', $module) }}" wire:navigate class="p-1 rounded-full hover:bg-slate-200 text-slate-500 hover:text-primary transition" title="Kelola Konten">
                                                                    <x-phosphor-books-bold class="icon-size-md" />
                                                                </a>
                                                                <button wire:click="openEditModal({{ $module->id }})" class="p-1 rounded-full hover:bg-slate-200 text-slate-500 hover:text-primary transition" title="Edit">
                                                                    <x-phosphor-pencil-line-bold class="icon-size-md" />
                                                                </button>
                                                                <button @click="confirmDelete({{ $module->id }})" class="p-1 rounded-full hover:bg-red-200 text-red-500 hover:text-red-700 transition" title="Hapus">
                                                                    <x-phosphor-trash-bold class="icon-size-md" />
                                                                </button>
                                                            </div>
                                                        </td>                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $modules->links() }}
        </div>
        @endif
    </div>

    {{-- Modal untuk Form Create/Edit Modul --}}
    <x-modal id="module-form-modal" wire:model="isModalOpen" maxWidth="lg"
        :title="$editingModule ? 'Edit Modul' : 'Tambah Modul Baru'">

        @if ($this->isModalOpen)
        @livewire('admin.modules.form-module', ['module' => $editingModule], key($editingModule?->id ?? 'new'))
        @endif
    </x-modal>
</div>
