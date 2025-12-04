<?php

namespace App\Services;

use App\Models\Question;
use Illuminate\Support\Facades\DB;

class QuestionService
{
    public function create(array $data): Question
    {
        return DB::transaction(function () use ($data) {
            return Question::create($data);
        });
    }

    public function update(Question $question, array $data): Question
    {
        return DB::transaction(function () use ($question, $data) {
            $question->update($data);
            return $question;
        });
    }

    public function delete(Question $question): void
    {
        DB::transaction(function () use ($question) {
            $question->delete();
        });
    }
}
