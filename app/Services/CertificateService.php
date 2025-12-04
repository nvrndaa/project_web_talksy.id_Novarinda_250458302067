<?php

namespace App\Services;

use App\Models\User;
use App\Models\Certificate;
use App\Queries\GetCourseCompletionStatusQuery;
use Illuminate\Support\Str;

class CertificateService
{
    public function __construct(
        protected GetCourseCompletionStatusQuery $completionStatusQuery
    ) {}

    /**
     * Mengecek apakah user memenuhi syarat untuk sertifikat, dan jika ya, menerbitkannya.
     * Mencegah pembuatan sertifikat duplikat.
     *
     * @param User $user
     * @return Certificate|null Sertifikat yang baru dibuat, atau null jika tidak ada yang dibuat.
     */
    public function issueCertificateIfQualified(User $user): ?Certificate
    {
        // 1. Cek dulu apakah user sudah punya sertifikat. Jika sudah, hentikan.
        $existingCertificate = Certificate::where('user_id', $user->id)->exists();
        if ($existingCertificate) {
            return null;
        }

        // 2. Ambil data progres user menggunakan Query Object
        $status = $this->completionStatusQuery->get($user);

        // 3. Lakukan pengecekan kualifikasi
        $isQualified =
            ($status->total_active_modules > 0) && // Pastikan ada modul aktif
            ($status->user_passed_quizzes >= $status->total_active_modules) &&
            ($status->user_completed_materials >= $status->total_active_materials);

        if (!$isQualified) {
            return null;
        }

        // 4. Jika qualified, buat sertifikat
        return Certificate::create([
            'user_id' => $user->id,
            'certificate_code' => $this->generateUniqueCertificateCode($user->id),
            'issued_at' => now(),
        ]);
    }

    /**
     * Membuat kode sertifikat yang unik.
     * Format: TSY-USERID-YYYYMM-RANDOMSTRING
     *
     * @param int $userId
     * @return string
     */
    private function generateUniqueCertificateCode(int $userId): string
    {
        $datePart = now()->format('Ym');
        $randomPart = Str::upper(Str::random(8));

        return "TSY-{$userId}-{$datePart}-{$randomPart}";
    }
}
