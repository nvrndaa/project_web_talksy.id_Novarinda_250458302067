<?php

namespace App\Livewire\Admin\Modules;

use App\Models\Module;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;
use App\Livewire\Admin\Modules\Forms\ModuleFormObject;
use App\Services\ModuleService;

class FormModule extends Component
{
    use WireToast;

    public ModuleFormObject $form;

    public function mount(?Module $module = null)
    {
        $this->form->setModule($module);
    }

    public function save(ModuleService $service)
    {
        try {
            $isEditing = (bool)$this->form->module;

            $this->form->save($service); // Panggil method save dari Form Object

            if ($isEditing) {
                toast()->success('Modul berhasil diperbarui!')->push();
            } else {
                toast()->success('Modul berhasil disimpan!')->push();
            }

            $this->dispatch('close-modal');
            $this->dispatch('module-saved'); // Beri tahu komponen induk untuk refresh
        } catch (\Exception $e) {
            toast()->danger('Gagal menyimpan modul: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.modules.form-module');
    }
}
