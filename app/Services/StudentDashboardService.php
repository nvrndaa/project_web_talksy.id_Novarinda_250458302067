<?php

namespace App\Services;

use App\Models\User;
use App\Queries\Curriculum\GetStudentCurriculumQuery;
use App\Queries\GetCourseCompletionStatusQuery;
use App\Queries\Trends\GetStudentActivityTrendQuery;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StudentDashboardService
{
    protected User $user;

    public function __construct(
        protected GetStudentCurriculumQuery $curriculumQuery,
        protected GetCourseCompletionStatusQuery $completionStatusQuery,
        protected GetStudentActivityTrendQuery $activityTrendQuery
    ) {
        $this->user = Auth::user();
    }

    /**
     * Mengambil materi berikutnya yang harus dipelajari siswa.
     * @return object|null {title: string, route: string}
     */
    public function getNextMaterialToStudy(): ?object
    {
        $curriculum = $this->curriculumQuery->get($this->user);

        foreach ($curriculum as $module) {
            foreach ($module->materials as $material) {
                if (!$material->is_completed) {
                    // Temukan materi pertama yang belum selesai
                    return (object) [
                        'title' => $material->title,
                        // Asumsi rute materi adalah 'student.material.show'
                        // Kita perlu membuat rute ini nanti atau disesuaikan dengan yang ada
                        'route' => '#', // Placeholder, perlu rute materi
                        'material_id' => $material->id,
                        'module_id' => $module->id,
                    ];
                }
            }
            // Jika semua materi dalam modul selesai, cek kuis
            if ($module->quiz && !($module->quiz->latestAttempt?->is_passed ?? false)) {
                // Temukan kuis yang belum lulus
                return (object) [
                    'title' => 'Kuis ' . $module->quiz->title,
                    'route' => route('student.quiz.attempt', ['quiz' => $module->quiz->id]),
                    'is_quiz' => true,
                    'quiz_id' => $module->quiz->id,
                ];
            }
        }

        // Jika semua sudah selesai
        return (object) ['title' => 'Anda telah menyelesaikan semua materi!', 'route' => route('student.my-certificate')];
    }

    /**
     * Mengambil persentase progres keseluruhan kursus siswa.
     */
    public function getOverallCourseProgress(): int
    {
        $status = $this->completionStatusQuery->get($this->user);

        $totalCompletionPoints = $status->total_active_materials + $status->total_active_modules; // Modul dianggap 1 'point' jika kuis lulus
        $userCompletionPoints = $status->user_completed_materials + $status->user_passed_quizzes;

        return ($totalCompletionPoints > 0) ? round(($userCompletionPoints / $totalCompletionPoints) * 100) : 0;
    }

    /**
     * Mengambil rata-rata skor kuis siswa.
     */
    public function getAverageQuizScore(): int
    {
        $averageScore = DB::table('quiz_attempts')
            ->where('user_id', $this->user->id)
            ->avg('score');

        return round($averageScore ?? 0);
    }

    /**
     * Mengambil jumlah modul yang kuisnya sudah diluluskan siswa.
     * @return string Contoh: "5 dari 18"
     */
    public function getCompletedModulesCount(): string
    {
        $status = $this->completionStatusQuery->get($this->user);
        return $status->user_passed_quizzes . ' dari ' . $status->total_active_modules;
    }

    /**
     * Mengambil status sertifikat siswa.
     */
    public function getCertificateStatus(): string
    {
        return $this->user->certificate()->exists() ? 'Sudah Diraih' : 'Belum Diraih';
    }

    /**
     * Mengambil data tren aktivitas belajar siswa untuk chart.
     */
    public function getStudentActivityTrend(int $days = 7): array
    {
        // Langsung return hasil dari Query Object yang sudah kita rapikan di atas
        return $this->activityTrendQuery->get($this->user, $days);
    }

    /**
     * Mengambil daftar 5 pencapaian terbaru siswa.
     */
    public function getRecentAchievements(): array
    {
        // 1. Ambil Penyelesaian Materi (Pakai Query Builder agar Timestamp Jelas)
        $materialCompletions = DB::table('material_completions')
            ->join('materials', 'material_completions.material_id', '=', 'materials.id')
            ->select(
                'materials.title',
                'material_completions.created_at', // Pastikan ambil waktu selesai
                DB::raw("'material' as type")
            )
            ->where('material_completions.user_id', $this->user->id)
            ->where('material_completions.created_at', '>=', now()->subDays(30))
            ->get();

        // 2. Ambil Pengerjaan Kuis
        $quizAttempts = DB::table('quiz_attempts')
            ->join('quizzes', 'quiz_attempts.quiz_id', '=', 'quizzes.id')
            ->select(
                'quizzes.title',
                'quiz_attempts.score',
                'quiz_attempts.is_passed',
                'quiz_attempts.created_at',
                DB::raw("'quiz' as type")
            )
            ->where('quiz_attempts.user_id', $this->user->id)
            ->where('quiz_attempts.created_at', '>=', now()->subDays(30))
            ->get();

        // 3. Gabungkan, Urutkan DESC (Terbaru diatas), dan Format
        $mergedActivities = $materialCompletions->merge($quizAttempts)
            ->sortByDesc('created_at') // PERBAIKAN: Gunakan sortByDesc
            ->take(5);

        $achievements = [];

        foreach ($mergedActivities as $activity) {
            // Konversi string date DB ke Carbon untuk diffForHumans
            $time = \Carbon\Carbon::parse($activity->created_at)->diffForHumans();

            if ($activity->type === 'material') {
                $achievements[] = [
                    'icon' => 'phosphor-check-circle-bold',
                    'color' => 'text-emerald-500',
                    'text' => 'Materi Selesai: ' . $activity->title,
                    'time' => $time,
                ];
            } elseif ($activity->type === 'quiz') {
                $status = $activity->is_passed ? 'Lulus' : 'Gagal';
                $color = $activity->is_passed ? 'text-emerald-500' : 'text-red-500';
                $icon = $activity->is_passed ? 'phosphor-medal-military-bold' : 'phosphor-x-circle-bold';

                $achievements[] = [
                    'icon' => $icon,
                    'color' => $color,
                    'text' => "Kuis {$status}: {$activity->title} (Skor: {$activity->score})",
                    'time' => $time,
                ];
            }
        }

        return $achievements;
    }
}
