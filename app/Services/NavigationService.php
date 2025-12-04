<?php

namespace App\Services;

use App\Enums\UserRole;
use Illuminate\Support\Facades\Auth;

class NavigationService
{
    public function getMenu(): array
    {
        $user = Auth::user();

        if (!$user) {
            return [];
        }

        return match ($user->role) {
            UserRole::ADMIN => $this->getAdminMenu(),
            UserRole::STUDENT => $this->getStudentMenu(),
            default => [],
        };
    }

    protected function getAdminMenu(): array
    {
        return [
            ['label' => 'Main Menu', 'is_header' => true],
            ['label' => 'Dashboard', 'icon' => 'phosphor-squares-four-duotone', 'route' => 'admin.dashboard'],
            ['label' => 'Kelola Modul', 'icon' => 'phosphor-stack-duotone', 'route' => 'admin.modules.index'],
            ['label' => 'Kelola Kuis', 'icon' => 'phosphor-question-duotone', 'route' => 'admin.quizzes.index'], // Menambahkan menu Kelola Kuis
            ['label' => 'Kelola Pengguna', 'icon' => 'phosphor-users-duotone', 'route' => 'admin.users.index'],

            ['is_divider' => true],
            ['label' => 'Laporan', 'is_header' => true],
            ['label' => 'Analitik', 'icon' => 'phosphor-chart-bar-duotone', 'children' => [
                ['label' => 'Hasil Kuis', 'route' => 'admin.analytics.quiz-attempts'],
                ['label' => 'Progres Materi', 'route' => 'admin.analytics.material-completions'],
                ['label' => 'Daftar Sertifikat', 'route' => 'admin.analytics.certificates'],
            ]],

            ['is_divider' => true],
            // ['label' => 'Settings', 'icon' => 'phosphor-gear-duotone', 'children' => [
            //     ['label' => 'General', 'route' => '#'],
            //     ['label' => 'System', 'route' => '#'],
            // ]],
        ];
    }

    protected function getStudentMenu(): array
    {
        return [
            ['label' => 'Main Menu', 'is_header' => true],
            ['label' => 'Dashboard', 'icon' => 'phosphor-squares-four-duotone', 'route' => 'student.dashboard'],
            ['label' => 'My Learning', 'icon' => 'phosphor-book-open-text-duotone', 'route' => 'student.my-learning'],
            ['label' => 'Riwayat Kuis', 'icon' => 'phosphor-chart-bar-horizontal-duotone', 'route' => 'student.my-results'],
            ['label' => 'Sertifikat', 'icon' => 'phosphor-certificate-duotone', 'route' => 'student.my-certificate'],

            ['is_divider' => true],
            ['label' => 'Account', 'is_header' => true],
            ['label' => 'Settings', 'icon' => 'phosphor-gear-duotone', 'route' => 'student.account.settings'],
        ];
    }
}
