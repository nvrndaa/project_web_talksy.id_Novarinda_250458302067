<?php

namespace App\Queries\Trends;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GetStudentActivityTrendQuery
{
    public function get(User $user, int $days = 7): array
    {
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subDays($days - 1);

        // 1. Ambil data mentah dari DB
        $rawStats = DB::table('material_completions')
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as total_items')
            )
            ->where('user_id', $user->id)
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            // PERBAIKAN 1: Group by menggunakan raw expression, bukan alias
            ->groupBy(DB::raw('DATE(created_at)'))
            ->get();

        // 2. Mapping ulang agar Key array pasti string 'Y-m-d'
        // Ini memastikan tanggal dari DB cocok dengan loop PHP di bawah
        $statsByDate = $rawStats->mapWithKeys(function ($item) {
            return [Carbon::parse($item->date)->format('Y-m-d') => $item->total_items];
        });

        // 3. Siapkan Array Kosong untuk Labels & Values
        $labels = [];
        $values = [];

        // 4. Loop dari hari pertama sampai hari ini
        for ($i = 0; $i < $days; $i++) {
            $currentDate = $startDate->copy()->addDays($i);
            $dateString = $currentDate->format('Y-m-d'); // Contoh: "2025-12-04"

            // Label Chart (Senin, 04 Des)
            $labels[] = $currentDate->translatedFormat('D, d M');

            // PERBAIKAN 2: Cek data menggunakan collection yang sudah dirapikan
            $values[] = $statsByDate->has($dateString)
                ? (int) $statsByDate->get($dateString)
                : 0;
        }

        return [
            'labels' => $labels,
            'values' => $values,
            'seriesName' => 'Materi Selesai'
        ];
    }
}
