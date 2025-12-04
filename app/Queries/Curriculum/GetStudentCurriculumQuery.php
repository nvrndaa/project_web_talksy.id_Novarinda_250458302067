<?php

namespace App\Queries\Curriculum;

use App\Models\Module;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class GetStudentCurriculumQuery
{
    /**
     * Mengambil seluruh kurikulum untuk seorang siswa,
     * lengkap dengan status penyelesaian untuk setiap materi dan kuis.
     *
     * @param User $user
     * @return Collection
     */
    public function get(User $user): Collection
    {
        return Module::query()
            ->where('is_active', true)
            ->orderBy('order_index')
            ->with([
                // 1. Ambil semua materi di dalam modul
                'materials' => function ($query) use ($user) {
                    $query->orderBy('id')
                          // Tambahkan atribut virtual 'is_completed'
                          ->withExists(['completions as is_completed' => function ($q) use ($user) {
                              $q->where('user_id', $user->id);
                          }]);
                },
                // 2. Ambil kuis yang terkait dengan modul
                'quiz' => function ($query) use ($user) {
                    // Ambil attempt TERBARU untuk kuis ini oleh user ini
                    $query->with(['latestAttempt' => function ($q) use ($user) {
                        $q->where('user_id', $user->id);
                    }]);
                }
            ])
            ->get();
    }
}
