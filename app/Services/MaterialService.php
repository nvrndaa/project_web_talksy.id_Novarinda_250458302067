<?php

namespace App\Services;

use App\Models\Material;
use Illuminate\Support\Facades\DB;

class MaterialService
{
    public function create(array $data): Material
    {
        return DB::transaction(function () use ($data) {
            return Material::create($data);
        });
    }

    public function update(Material $material, array $data): Material
    {
        return DB::transaction(function () use ($material, $data) {
            $material->update($data);
            return $material;
        });
    }

    public function delete(Material $material): void
    {
        DB::transaction(function () use ($material) {
            $material->delete();
        });
    }
}
