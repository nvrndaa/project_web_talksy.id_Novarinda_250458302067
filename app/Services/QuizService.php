<?php

namespace App\Services;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class QuizService
{
    // 1. Inject CertificateService
    public function __construct(
        protected CertificateService $certificateService
    ) {}

    public function create(array $data): Quiz
    {
        return DB::transaction(function () use ($data) {
            return Quiz::create($data);
        });
    }

    public function update(Quiz $quiz, array $data): Quiz
    {
        return DB::transaction(function () use ($quiz, $data) {
            $quiz->update($data);
            return $quiz;
        });
    }

    public function delete(Quiz $quiz): void
    {
        DB::transaction(function () use ($quiz) {
            $quiz->delete();
        });
    }

    /**
     * 2. Tambahkan metode untuk menangani submission kuis dari siswa
     *
     * @param User $user Siswa yang mengerjakan
     * @param Quiz $quiz Kuis yang dikerjakan
     * @param array $answers Jawaban siswa, format: ['question_id' => 'selected_option_index']
     * @return QuizAttempt Hasil pengerjaan kuis
     */
    public function submitAttempt(User $user, Quiz $quiz, array $answers): QuizAttempt
    {
        // Ambil semua pertanyaan dan jawaban benarnya untuk kuis ini
        $questions = $quiz->questions()->pluck('correct_option_index', 'id');
        $totalQuestions = $questions->count();
        $correctAnswers = 0;

        // Hitung jawaban yang benar
        foreach ($answers as $questionId => $selectedOptionIndex) {
            if ($questions->has($questionId) && $questions[$questionId] == $selectedOptionIndex) {
                $correctAnswers++;
            }
        }

        // Hitung skor akhir
        $score = ($totalQuestions > 0) ? round(($correctAnswers / $totalQuestions) * 100) : 0;
        $isPassed = $score >= $quiz->passing_score;

        $quizAttempt = null;
        DB::transaction(function () use ($user, $quiz, $score, $isPassed, &$quizAttempt) {
            // Simpan hasil attempt ke database
            $quizAttempt = QuizAttempt::create([
                'user_id' => $user->id,
                'quiz_id' => $quiz->id,
                'score' => $score,
                'is_passed' => $isPassed,
            ]);

            // 3. Panggil CertificateService JIKA siswa LULUS
            if ($isPassed) {
                $this->certificateService->issueCertificateIfQualified($user);
            }
        });

        return $quizAttempt;
    }
}
