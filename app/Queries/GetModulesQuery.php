<?php

namespace App\Queries;

use App\Models\Module;
use Illuminate\Pagination\LengthAwarePaginator;

class GetModulesQuery
{
    public function get(string $search = '', string $orderBy = 'order_index', string $orderDirection = 'asc', int $perPage = 10): LengthAwarePaginator
    {
        return Module::query()
            ->when($search, fn($query) => $query->where('title', 'like', '%' . $search . '%'))
            ->orderBy($orderBy, $orderDirection)
            ->withCount('materials')
            ->paginate($perPage);
    }
}
