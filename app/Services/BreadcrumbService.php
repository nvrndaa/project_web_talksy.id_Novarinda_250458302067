<?php

namespace App\Services;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

class BreadcrumbService
{
    public function generate(): array
    {
        $route = Request::route();
        if (!$route) {
            return [];
        }

        $name = $route->getName();
        $crumbs = [];

        // Breadcrumb default untuk semua halaman di dalam panel
        if (Auth()->check()) {
            $dashboardRoute = Auth()->user()->role->value === 'admin' ? 'admin.dashboard' : 'student.dashboard';
            $crumbs[] = ['label' => 'Home', 'url' => route($dashboardRoute)];
        } else {
             $crumbs[] = ['label' => 'Home', 'url' => route('home')];
        }


        // --- LOGIKA BREADCRUMB ---
        switch (true) {
            // == STUDENT ==
            case $name === 'student.dashboard':
                $crumbs[] = ['label' => 'Dashboard', 'url' => null];
                break;
            case $name === 'student.my-learning':
                $crumbs[] = ['label' => 'My Learning', 'url' => null];
                break;
            case $name === 'student.my-results':
                $crumbs[] = ['label' => 'Riwayat Kuis', 'url' => null];
                break;
            case $name === 'student.my-certificate':
                $crumbs[] = ['label' => 'Sertifikat', 'url' => null];
                break;
            case $name === 'student.account.settings':
                 $crumbs[] = ['label' => 'Pengaturan Akun', 'url' => null];
                break;
            case $name === 'student.material.show':
                $material = $route->parameter('material');
                $crumbs[] = ['label' => 'My Learning', 'url' => route('student.my-learning')];
                $crumbs[] = ['label' => $material->module->title, 'url' => route('student.my-learning')]; // Arahkan kembali ke my-learning
                $crumbs[] = ['label' => Str::limit($material->title, 25), 'url' => null];
                break;
            case $name === 'student.quiz.attempt':
                $quiz = $route->parameter('quiz');
                $crumbs[] = ['label' => 'My Learning', 'url' => route('student.my-learning')];
                 $crumbs[] = ['label' => $quiz->module->title, 'url' => route('student.my-learning')];
                $crumbs[] = ['label' => Str::limit($quiz->title, 25), 'url' => null];
                break;

            // == ADMIN ==
            case str_starts_with($name, 'admin.'):
                 $this->generateAdminCrumbs($name, $route, $crumbs);
                 break;
        }

        return $crumbs;
    }

    private function generateAdminCrumbs(string $name, $route, array &$crumbs): void
    {
         switch (true) {
             case $name === 'admin.dashboard':
                 $crumbs[] = ['label' => 'Dashboard', 'url' => null];
                 break;
            case str_starts_with($name, 'admin.modules'):
                 $crumbs[] = ['label' => 'Kelola Modul', 'url' => route('admin.modules.index')];
                if ($route->hasParameter('module')) {
                     $crumbs[] = ['label' => Str::limit($route->parameter('module')->title, 25), 'url' => null];
                }
                 break;
            case str_starts_with($name, 'admin.quizzes'):
                 $crumbs[] = ['label' => 'Kelola Kuis', 'url' => route('admin.quizzes.index')];
                if ($route->hasParameter('quiz')) {
                     $crumbs[] = ['label' => Str::limit($route->parameter('quiz')->title, 25), 'url' => null];
                }
                 break;
            case str_starts_with($name, 'admin.users'):
                 $crumbs[] = ['label' => 'Kelola Pengguna', 'url' => route('admin.users.index')];
                 break;
            case str_starts_with($name, 'admin.analytics'):
                $crumbs[] = ['label' => 'Analitik', 'url' => '#'];
                $finalCrumb = Str::of(str_replace('admin.analytics.', '', $name))->replace('-', ' ')->title();
                $crumbs[] = ['label' => (string) $finalCrumb, 'url' => null];
                break;
         }
    }
}
