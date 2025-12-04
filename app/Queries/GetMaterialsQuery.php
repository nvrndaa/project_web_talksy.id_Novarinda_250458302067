<?php

namespace App\Queries;

use App\Models\Material;
use Illuminate\Database\Eloquent\Collection;

class GetMaterialsQuery
{
    public function get(int $moduleId): Collection
    {
        return Material::where('module_id', $moduleId)
            ->orderBy('id', 'asc') // Atau berdasarkan urutan lain jika ada
            ->get();
    }
}
