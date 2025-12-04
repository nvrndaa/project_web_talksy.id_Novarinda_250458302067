<?php

namespace App\Queries;

use App\Models\Module;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use stdClass;

class GetCourseCompletionStatusQuery
{
    /**
     * Mengambil status penyelesaian kursus untuk seorang user.
     *
     * @param User $user
     * @return object{
     *      total_active_modules: int,
     *      total_active_materials: int,
     *      user_completed_materials: int,
     *      user_passed_quizzes: int
     * }
     */
    public function get(User $user): object
    {
        $status = new stdClass();

        // 1. Hitung total modul dan materi yang aktif
        $activeModules = Module::query()
            ->where('is_active', true)
            ->withCount('materials')
            ->get();

        $status->total_active_modules = $activeModules->count();
        $status->total_active_materials = $activeModules->sum('materials_count');

        // 2. Hitung total materi yang sudah diselesaikan user
        $status->user_completed_materials = DB::table('material_completions')
            ->where('user_id', $user->id)
            ->count();

        // 3. Hitung total kuis (unik) yang sudah LULUS oleh user
        // Menggunakan distinct('quiz_id') untuk kasus jika user mengulang kuis yang sama
        $status->user_passed_quizzes = QuizAttempt::query()
            ->where('user_id', $user->id)
            ->where('is_passed', true)
            ->distinct('quiz_id')
            ->count('quiz_id');

        return $status;
    }
}
