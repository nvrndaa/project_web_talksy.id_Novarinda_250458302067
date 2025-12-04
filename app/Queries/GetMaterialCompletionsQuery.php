<?php

namespace App\Queries;

use App\Models\MaterialCompletion;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class GetMaterialCompletionsQuery
{
    public function get(string $search = '', int $perPage = 15): LengthAwarePaginator
    {
        return MaterialCompletion::query()
            ->with(['user', 'material.module']) // Eager load nested relationships
            ->when($search, function (Builder $query, $search) {
                $query->where(function ($q) use ($search) {
                    // Search by user name
                    $q->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    })
                    // Or search by material title
                    ->orWhereHas('material', function ($materialQuery) use ($search) {
                        $materialQuery->where('title', 'like', "%{$search}%");
                    })
                    // Or search by module title
                    ->orWhereHas('material.module', function ($moduleQuery) use ($search) {
                        $moduleQuery->where('title', 'like', "%{$search}%");
                    });
                });
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
}
