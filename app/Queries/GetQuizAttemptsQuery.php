<?php

namespace App\Queries;

use App\Models\QuizAttempt;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class GetQuizAttemptsQuery
{
    /**
     * @param string $search
     * @param string $filterStatus 'all', 'passed', 'failed'
     * @param int $perPage
     * @return LengthAwarePaginator
     */
    public function get(string $search = '', string $filterStatus = 'all', int $perPage = 15): LengthAwarePaginator
    {
        return QuizAttempt::query()
            ->with(['user', 'quiz']) // Eager load relationships
            ->when($search, function (Builder $query, $search) {
                $query->where(function ($q) use ($search) {
                    // Search by user name
                    $q->whereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%");
                    })
                    // Or search by quiz title
                    ->orWhereHas('quiz', function ($quizQuery) use ($search) {
                        $quizQuery->where('title', 'like', "%{$search}%");
                    });
                });
            })
            ->when($filterStatus !== 'all', function (Builder $query) use ($filterStatus) {
                $query->where('is_passed', $filterStatus === 'passed' ? 1 : 0);
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }
}
