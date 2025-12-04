<?php

namespace App\Queries\Stats;

use App\Models\QuizAttempt;

class GetQuizPassRateQuery
{
    public function get(): int
    {
        $totalAttempts = QuizAttempt::count();

        if ($totalAttempts === 0) {
            return 0;
        }

        $passedAttempts = QuizAttempt::where('is_passed', true)->count();

        return (int) round(($passedAttempts / $totalAttempts) * 100);
    }
}
