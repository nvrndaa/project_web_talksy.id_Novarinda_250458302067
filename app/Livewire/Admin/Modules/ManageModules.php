<?php

namespace App\Livewire\Admin\Modules;

use App\Models\Module;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Services\ModuleService;
use Livewire\Attributes\Layout;
use App\Queries\GetModulesQuery;
use Usernotnull\Toast\Concerns\WireToast;

#[Layout('components.layouts.app')]
#[Title('Manajemen Modul - Talksy.id')]
class ManageModules extends Component
{
    use WithPagination, WireToast;

    public string $search = '';
    public bool $isModalOpen = false; // Properti untuk mengontrol modal
    public ?Module $editingModule = null; // Modul yang sedang diedit

    #[On('module-saved')]
    #[On('module-deleted')]
    public function refreshList()
    {
        $this->resetPage(); // Reset halaman ke 1 setelah ada perubahan data
    }

    public function openCreateModal()
    {
        $this->isModalOpen = true; // Buka flag untuk render konten
        $this->editingModule = null;
    }

    public function openEditModal(Module $module)
    {
        $this->isModalOpen = true; // Buka flag untuk render konten
        $this->editingModule = $module;
    }

    #[On('delete-confirmed')]
    public function delete(int $id, ModuleService $moduleService)
    {
        try {
            $module = Module::findOrFail($id);
            $moduleService->delete($module);
            toast()->info('Modul berhasil dihapus!')->sticky()->push();
            $this->refreshList();
        } catch (\Exception $e) {
            toast()->danger('Gagal menghapus modul: ' . $e->getMessage())->sticky()->push();
        }
    }

    public function render(GetModulesQuery $query) // Inject GetModulesQuery
    {
        $modules = $query->get(
            search: $this->search,
            perPage: 10
        );

        return view('livewire.admin.modules.manage-modules', [
            'modules' => $modules,
        ]);
    }
}
