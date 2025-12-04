<?php

namespace App\Queries;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Pagination\LengthAwarePaginator;

class GetUsersQuery
{
    public function get(string $search = '', ?string $filterRole = null, int $perPage = 10): LengthAwarePaginator
    {
        return User::query()
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->when($filterRole, fn($query) => $query->where('role', $filterRole))
            ->orderBy('name', 'asc')
            ->paginate($perPage);
    }
}
