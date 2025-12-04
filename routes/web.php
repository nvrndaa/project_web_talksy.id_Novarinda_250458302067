<?php

use Illuminate\Support\Facades\Route;
use App\Enums\UserRole;
use App\Livewire\HomePage;

// Rute Publik (Guest)
Route::get('/', HomePage::class)->name('home');
Route::get('/verify', \App\Livewire\CertificateValidationPage::class)->name('certificate.verify');

// Rute-rute otentikasi untuk pengguna yang belum login (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', \App\Livewire\Auth\LoginPage::class)->name('login');
    Route::get('/register', \App\Livewire\Auth\RegisterPage::class)->name('register');
    Route::get('/forgot-password', \App\Livewire\Auth\ForgotPasswordPage::class)->name('password.request');
});

// Grup untuk semua user yang sudah login dan terverifikasi emailnya
Route::middleware(['auth', 'verified'])->group(function () {

    // --- AREA STUDENT ---
    Route::middleware('role:' . UserRole::STUDENT->value)
        ->name('student.') // prefix nama route: student.dashboard
        ->group(function () {
            // Rute untuk Dashboard Student
            Route::get('/dashboard', App\Livewire\Student\Dashboard::class)->name('dashboard');
        // Rute untuk Halaman My Learning
        Route::get('/my-learning', \App\Livewire\Student\MyLearningPage::class)->name('my-learning');
        // Rute untuk Halaman Riwayat Kuis
        Route::get('/my-results', \App\Livewire\Student\MyResultsPage::class)->name('my-results');
        // Rute untuk Halaman Sertifikat Student
        Route::get('/my-certificate', \App\Livewire\Student\MyCertificatePage::class)->name('my-certificate');
        // Rute untuk menampilkan materi
        Route::get('/learn/material/{material}', \App\Livewire\Student\Classroom\MaterialPage::class)->name('material.show');
        // Rute untuk mengerjakan kuis
        Route::get('/quiz/{quiz}/attempt', \App\Livewire\Student\Quiz\AttemptPage::class)->name('quiz.attempt');
        // Rute untuk Pengaturan Akun
        Route::get('/account/settings', \App\Livewire\Student\Account\SettingsPage::class)->name('account.settings');
            // ...rute-rute student lainnya bisa ditambahkan di sini
        });

    // --- AREA ADMIN ---
    Route::middleware('role:' . UserRole::ADMIN->value)
        ->prefix('admin') // prefix URL: /admin/*
        ->name('admin.') // prefix nama route: admin.dashboard
        ->group(function () {
            // Rute untuk Dashboard Admin
            Route::get('/dashboard', App\Livewire\Admin\Dashboard::class)->name('dashboard');
            // Rute untuk Manajemen Modul
            Route::get('/modules', App\Livewire\Admin\Modules\ManageModules::class)->name('modules.index');
            // Rute untuk menampilkan detail modul dan mengelola materinya
            Route::get('/modules/{module}', App\Livewire\Admin\Modules\ShowModule::class)->name('modules.show');
            // Rute untuk Manajemen Kuis
            Route::get('/quizzes', App\Livewire\Admin\Quizzes\ManageQuizzes::class)->name('quizzes.index');
            // Rute untuk menampilkan detail kuis dan mengelola pertanyaannya
            Route::get('/quizzes/{quiz}', App\Livewire\Admin\Quizzes\ShowQuiz::class)->name('quizzes.show');
            // Rute untuk Manajemen Pengguna
            Route::get('/users', App\Livewire\Admin\Users\ManageUsers::class)->name('users.index');

        // --- AREA ANALYTICS & REPORTS ---
        Route::prefix('analytics')->name('analytics.')->group(function () {
                Route::get('/quiz-attempts', \App\Livewire\Admin\Analytics\QuizAttemptsReport::class)->name('quiz-attempts');
                Route::get('/material-completions', \App\Livewire\Admin\Analytics\MaterialCompletionsReport::class)->name('material-completions');
                Route::get('/certificates', \App\Livewire\Admin\Analytics\CertificatesReport::class)->name('certificates');
            });
        });
});
