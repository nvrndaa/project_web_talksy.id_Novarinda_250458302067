<?php

namespace App\Livewire\Admin\Modules;

use App\Models\Module;
use App\Models\Material;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use Usernotnull\Toast\Concerns\WireToast;
use App\Services\MaterialService;

#[Layout('components.layouts.app')]
class ShowModule extends Component
{
    use WireToast;

    public Module $module;
    public bool $isModalOpen = false;
    public ?Material $editingMaterial = null;

    protected $listeners = [
        'material-saved' => 'refreshMaterials',
    ];

    public function mount(Module $module)
    {
        $this->module = $module->load('materials'); // Eager load materi
    }

    #[On('material-saved')]
    public function refreshMaterials()
    {
        $this->module->refresh(); // Refresh data module termasuk relasi materials
        $this->isModalOpen = false; // Pastikan modal tertutup setelah simpan
    }

    public function openCreateMaterialModal()
    {
        $this->isModalOpen = true;
        $this->editingMaterial = null;
    }

    public function openEditMaterialModal(Material $material)
    {
        $this->isModalOpen = true;
        $this->editingMaterial = $material;
    }

    #[On('delete-confirmed')]
    public function delete(int $id, MaterialService $materialService)
    {
        try {
            $material = Material::findOrFail($id);
            $materialService->delete($material);
            toast()->info('Materi berhasil dihapus!')->sticky()->push();
            $this->refreshMaterials();
        } catch (\Exception $e) {
            toast()->danger('Gagal menghapus materi: ' . $e->getMessage())->sticky()->push();
        }
    }

    #[Title('Kelola Konten Modul')]
    public function render()
    {
        return view('livewire.admin.modules.show-module');
    }
}
