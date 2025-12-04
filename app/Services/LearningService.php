<?php

namespace App\Services;

use App\Models\User;
use App\Models\Material;
use Illuminate\Support\Facades\DB;

class LearningService
{
    /**
     * Menandai sebuah materi telah diselesaikan oleh seorang user.
     * Menggunakan firstOrCreate untuk mencegah error jika data sudah ada (idempotent).
     *
     * @param User $user
     * @param Material $material
     * @return void
     */
    public function markMaterialAsComplete(User $user, Material $material): void
    {
        // Logika Bisnis: Cek duplikasi, catat timestamp
        // Menggunakan syncWithoutDetaching adalah cara yang tepat dan idempotent
        // untuk memastikan record di pivot table ada, tanpa membuat duplikat.
        $user->completions()->syncWithoutDetaching([$material->id]);
    }
}
