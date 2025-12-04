<?php

namespace App\Services;

use App\Queries\Stats\GetTotalCertificatesQuery;
use App\Queries\Stats\GetTotalModulesQuery;
use App\Queries\Stats\GetTotalStudentsQuery;
use App\Queries\Stats\GetQuizPassRateQuery;
use App\Queries\Stats\GetRecentStudentsQuery; // Import baru
use App\Queries\Trends\GetNewUserTrendQuery;
use Illuminate\Database\Eloquent\Collection; // Import baru

class DashboardService
{
    public function getTotalStudents(): int
    {
        return (new GetTotalStudentsQuery())->get();
    }

    public function getNewUserTrend(int $days = 7): array
    {
        return (new GetNewUserTrendQuery())->get($days);
    }

    public function getTotalModules(): int
    {
        return (new GetTotalModulesQuery())->get();
    }

    public function getQuizPassRate(): int
    {
        return (new GetQuizPassRateQuery())->get();
    }

    public function getTotalCertificates(): int
    {
        return (new GetTotalCertificatesQuery())->get();
    }

    /**
     * Metode baru untuk mengambil siswa terbaru.
     */
    public function getRecentStudents(int $limit = 3): Collection
    {
        return (new GetRecentStudentsQuery())->get($limit);
    }
}
