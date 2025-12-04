<?php

namespace App\Services;

use App\Models\Module;
use App\Models\User;

class LandingPageService
{
    /**
     * Mengambil data statistik untuk ditampilkan di landing page.
     * Menggabungkan data dinamis dari database dan data statis untuk marketing.
     */
    public function getStats(): array
    {
        $totalModules = Module::where('is_active', true)->count();
        $totalStudents = User::student()->count();

        return [
            ['value' => $totalModules, 'label' => 'Modul Terstruktur'],
            ['value' => $totalStudents . '+', 'label' => 'Siswa Bergabung'],
            ['value' => '4.9/5', 'label' => 'Rating Review'],
            ['value' => 'Lulus', 'label' => 'Sertifikasi Resmi'],
        ];
    }

    /**
     * Mengambil data preview kurikulum (3 modul pertama).
     */
    public function getCurriculumPreview(): \Illuminate\Database\Eloquent\Collection
    {
        return Module::query()
            ->where('is_active', true)
            ->orderBy('order_index')
            ->with('materials:id,module_id,title,type') // Hanya ambil kolom yang dibutuhkan
            ->limit(3)
            ->get();
    }
}
