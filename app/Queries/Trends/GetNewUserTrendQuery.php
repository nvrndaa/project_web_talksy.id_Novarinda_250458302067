<?php

namespace App\Queries\Trends;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GetNewUserTrendQuery
{
    public function get(int $days = 14): array
    {
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subDays($days - 1);

        $users = User::where('role', UserRole::STUDENT)
            ->whereBetween('created_at', [$startDate->startOfDay(), $endDate->endOfDay()])
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->keyBy('date');

        $labels = [];
        $values = [];

        for ($i = 0; $i < $days; $i++) {
            $date = $startDate->copy()->addDays($i);
            $dateString = $date->format('Y-m-d');
            
            $labels[] = $date->format('d M'); // Format '10 Nov'
            $values[] = $users->has($dateString) ? $users[$dateString]->count : 0;
        }

        return [
            'seriesName' => 'Siswa Baru',
            'labels' => $labels,
            'values' => $values,
        ];
    }
}
