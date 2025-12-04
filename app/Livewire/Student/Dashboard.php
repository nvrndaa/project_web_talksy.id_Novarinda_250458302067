<?php

namespace App\Livewire\Student;

use App\Services\StudentDashboardService; // Import service baru
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Dashboard Saya - Talksy.id')]
class Dashboard extends Component
{
    // Properti untuk Header
    public ?object $nextMaterial = null;

    // Properti untuk Stat Cards
    public int $overallCourseProgress = 0;
    public int $averageQuizScore = 0;
    public string $completedModulesCount = "0 dari 0";
    public string $certificateStatus = "Belum Diraih";

    // Properti untuk Chart
    public array $activityTrendData = [];

    // Properti untuk Recent Achievements
    public array $recentAchievements = [];

    public function mount(StudentDashboardService $dashboardService) // Gunakan service baru
    {
        $this->nextMaterial = $dashboardService->getNextMaterialToStudy();

        $this->overallCourseProgress = $dashboardService->getOverallCourseProgress();
        $this->averageQuizScore = $dashboardService->getAverageQuizScore();
        $this->completedModulesCount = $dashboardService->getCompletedModulesCount();
        $this->certificateStatus = $dashboardService->getCertificateStatus();

        $this->activityTrendData = $dashboardService->getStudentActivityTrend();
        $this->recentAchievements = $dashboardService->getRecentAchievements();
    }

    public function render()
    {
        return view('livewire.student.dashboard');
    }
}
