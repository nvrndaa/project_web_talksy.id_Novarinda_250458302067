<?php

namespace App\Livewire\Admin;

use App\Services\DashboardService;
use Illuminate\Database\Eloquent\Collection; // Import baru
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Dashboard Admin - Talksy.id')]
class Dashboard extends Component
{
    public int $totalStudents = 0;
    public int $totalModules = 0;
    public int $quizPassRate = 0;
    public int $totalCertificates = 0;
    public array $newUserTrendData = [];

    // Properti baru untuk menampung data siswa terbaru
    public Collection $recentStudents;

    public function mount(DashboardService $dashboardService)
    {
        // Mengisi semua properti dengan data asli dari service
        $this->totalStudents = $dashboardService->getTotalStudents();
        $this->totalModules = $dashboardService->getTotalModules();
        $this->quizPassRate = $dashboardService->getQuizPassRate();
        $this->totalCertificates = $dashboardService->getTotalCertificates();
        $this->newUserTrendData = $dashboardService->getNewUserTrend(7);

        // Mengisi data siswa terbaru
        $this->recentStudents = $dashboardService->getRecentStudents(3);
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
