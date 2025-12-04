<?php

namespace App\Queries;

use App\Models\Certificate;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class GetCertificatesQuery
{
    public function get(string $search = '', int $perPage = 15): LengthAwarePaginator
    {
        return Certificate::query()
            ->with('user') // Eager load user relationship
            ->when($search, function (Builder $query, $search) {
                $query->where(function ($q) use ($search) {
                    // Search by user name
                    $q->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    })
                    // Or search by certificate code
                    ->orWhere('certificate_code', 'like', "%{$search}%");
                });
            })
            ->orderBy('issued_at', 'desc')
            ->paginate($perPage);
    }
}
