<?php

namespace App\Livewire\Admin\Modules\Forms;

use Livewire\Form;
use App\Models\Module;
use App\Services\ModuleService;

class ModuleFormObject extends Form
{
    public ?Module $module = null;

    public string $title = '';
    public string $description = '';
    public int $order_index = 0;
    public bool $is_active = true;

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order_index' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ];
    }

    public function setModule(?Module $module = null)
    {
        $this->module = $module;
        $this->fill(
            $module ? $module->toArray() : [
                'title' => '',
                'description' => '',
                'order_index' => Module::max('order_index') + 1,
                'is_active' => true,
            ]
        );
    }

    public function save(ModuleService $moduleService)
    {
        $this->validate();

        if ($this->module) {
            $moduleService->update($this->module, $this->all());
        } else {
            $moduleService->create($this->all());
        }
    }
}
