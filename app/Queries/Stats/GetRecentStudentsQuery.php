<?php

namespace App\Queries\Stats;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class GetRecentStudentsQuery
{
    /**
     * Mengambil N siswa terbaru yang terdaftar.
     *
     * @param int $limit Jumlah siswa yang ingin diambil.
     * @return Collection
     */
    public function get(int $limit = 3): Collection
    {
        return User::student()
            ->latest() // Shortcut untuk orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
