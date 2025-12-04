<?php

namespace App\Queries;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetUserQuizAttemptsQuery
{
    /**
     * Mengambil semua riwayat pengerjaan kuis untuk seorang user.
     *
     * @param User $user
     * @return LengthAwarePaginator
     */
    public function get(User $user): LengthAwarePaginator
    {
        return $user->quizAttempts()
            ->with(['quiz' => function ($query) {
                // Eager load judul kuis dan relasi ke modulnya untuk judul modul
                $query->select('id', 'title', 'module_id')->with('module:id,title');
            }])
            ->latest() // Urutkan berdasarkan yang paling baru
            ->paginate(10); // Gunakan paginasi
    }
}
