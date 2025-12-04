<div>
    {{-- Header Halaman --}}
    <div class="mb-8">
        <div class="flex items-center gap-3 mb-2">
            <a href="{{ route('admin.modules.index') }}" wire:navigate class="p-2 rounded-full hover:bg-slate-100">
                <x-phosphor-arrow-left-bold class="icon-size-md" />
            </a>
            <h1 class="text-3xl font-bold text-slate-800">Konten Modul</h1>
        </div>
        <p class="text-lg text-muted pl-11">{{ $module->title }}</p>
    </div>

    {{-- Aksi Utama --}}
    <div class="flex justify-end mb-6">
        <x-button variant="primary" wire:click="openCreateMaterialModal">
            <x-slot:icon_left>
                <x-phosphor-plus-bold class="w-5 h-5" />
            </x-slot:icon_left>
            Tambah Materi Baru
        </x-button>
    </div>

    {{-- Daftar Materi --}}
    <div class="card p-6">
        @if($module->materials->isEmpty())
            <div class="text-center py-10 text-muted">
                <x-phosphor-info-bold class="icon-size-xl mx-auto mb-3" />
                <p>Modul ini belum memiliki materi.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm whitespace-nowrap">
                    <thead>
                        <tr class="text-slate-500 border-b border-slate-200">
                            <th scope="col" class="px-3 py-3 font-semibold">Judul Materi</th>
                            <th scope="col" class="px-3 py-3 font-semibold">Tipe</th>
                            <th scope="col" class="px-3 py-3 font-semibold text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($module->materials as $material)
                            <tr class="border-b border-slate-100 hover:bg-slate-50">
                                <td class="px-3 py-3 font-semibold text-slate-800">{{ $material->title }}</td>
                                <td class="px-3 py-3">
                                    <span class="inline-flex items-center gap-1 rounded-full bg-blue-100 px-2 py-0.5 text-xs font-medium text-blue-700 capitalize">{{ $material->type->value }}</span>
                                </td>
                                <td class="px-3 py-3 text-right">
                                    <div class="flex justify-end gap-2">
                                        <button wire:click="openEditMaterialModal({{ $material->id }})" class="p-1 rounded-full hover:bg-slate-200 text-slate-500 hover:text-primary transition" title="Edit">
                                            <x-phosphor-pencil-line-bold class="icon-size-md" />
                                        </button>
                                        <button @click="confirmDelete({{ $material->id }})" class="p-1 rounded-full hover:bg-red-200 text-red-500 hover:text-red-700 transition" title="Hapus">
                                            <x-phosphor-trash-bold class="icon-size-md" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Modal untuk Form Create/Edit Materi --}}
    <x-modal id="material-form-modal" wire:model="isModalOpen" maxWidth="lg"
        :title="$editingMaterial ? 'Edit Materi: ' . $editingMaterial->title : 'Tambah Materi Baru'">
        @if ($this->isModalOpen)
            @livewire('admin.materials.form-material', ['moduleId' => $module->id, 'material' => $editingMaterial], key($editingMaterial?->id ?? 'new'))
        @endif
    </x-modal>
</div>
