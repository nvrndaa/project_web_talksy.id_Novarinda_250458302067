<?php

namespace App\Queries;

use App\Models\Question;
use Illuminate\Database\Eloquent\Collection;

class GetQuestionsQuery
{
    public function get(int $quizId): Collection
    {
        return Question::where('quiz_id', $quizId)
            ->orderBy('id')
            ->get();
    }
}
