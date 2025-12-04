<?php

namespace App\Queries;

use App\Models\Quiz;
use Illuminate\Pagination\LengthAwarePaginator;

class GetQuizzesQuery
{
    public function get(string $search = '', int $perPage = 10): LengthAwarePaginator
    {
        return Quiz::query()
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', '%' . $search . '%');
            })
            ->with('module') // Eager load module relationship
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
}
