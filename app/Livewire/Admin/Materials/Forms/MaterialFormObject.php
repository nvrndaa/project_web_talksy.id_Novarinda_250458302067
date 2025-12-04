<?php

namespace App\Livewire\Admin\Materials\Forms;

use Livewire\Form;
use App\Models\Material;
use App\Enums\MaterialType;
use App\Services\MaterialService;
use Illuminate\Validation\Rule;

class MaterialFormObject extends Form
{
    public ?Material $material = null;
    public int $module_id;

    public ?string $title = '';
    public string $type = 'video';
    public ?string $content_url = null;
    public ?string $content_body = null;

    public function setMaterial(int $moduleId, ?Material $material = null)
    {
        $this->material = $material;
        $this->module_id = $moduleId;

        $this->fill($material ? $material->toArray() : [
            'title' => '',
            'type' => 'video',
            'content_url' => '',
            'content_body' => '',
        ]);
    }

    public function save(MaterialService $materialService)
    {
        // Validasi sudah dilakukan oleh komponen Livewire utama (FormMaterial.php)
        // $this->validate(); // Hapus baris ini

        $data = $this->all();
        // Pastikan hanya data yang relevan yang disimpan
        if ($this->type !== 'text') {
            $data['content_body'] = null;
        }
        if ($this->type !== 'video' && $this->type !== 'pdf') {
            $data['content_url'] = null;
        }

        if ($this->material) {
            $materialService->update($this->material, $data);
        } else {
            $this->module_id = $data['module_id'] = $this->module_id; // pastikan module_id ada saat create
            $materialService->create($data);
        }
    }
}
