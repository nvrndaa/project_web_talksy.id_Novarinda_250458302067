<?php

namespace App\Livewire\Student\Quiz;

use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Services\QuizService;
use Livewire\Component;

class AttemptPage extends Component
{
    public Quiz $quiz;
    public $questions;

    // Menyimpan jawaban user
    public array $answers = [];

    // Hasil
    public ?QuizAttempt $result = null;

    public function mount(Quiz $quiz)
    {
        $this->quiz = $quiz;
        $this->initializeQuiz();
    }

    /**
     * Inisialisasi atau reset state kuis.
     */
    public function initializeQuiz()
    {
        $this->questions = $this->quiz->questions()->get();
        $this->reset('answers');
        foreach ($this->questions as $question) {
            $this->answers[$question->id] = null;
        }
        $this->result = null; // Reset hasil
    }

    public function submit(QuizService $quizService)
    {
        $filledAnswers = array_filter($this->answers, fn($value) => !is_null($value) && $value !== '');
        $answeredCount = count($filledAnswers);
        $totalQuestions = $this->questions->count();

        if ($answeredCount < $totalQuestions) {
            toast()->warning('Anda baru menjawab ' . $answeredCount . ' dari ' . $totalQuestions . ' pertanyaan.')->sticky()->push();
            return;
        }

        try {
            $this->result = $quizService->submitAttempt(auth()->user(), $this->quiz, $this->answers);

            if ($this->result->is_passed) {
                $this->dispatch('quiz-passed');
                toast()->info('Selamat! Anda lulus kuis.')->sticky()->push();
            } else {
                toast()->warning('Maaf, Anda belum lulus kuis.')->sticky()->push();
            }
        } catch (\Exception $e) {
            toast()->danger('Terjadi kesalahan: ' . $e->getMessage())->sticky()->push();
        }
    }

    public function retry()
    {
        $this->initializeQuiz(); // Panggil metode inisialisasi ulang
        $this->dispatch('scroll-on-top');
    }

    public function render()
    {
        return view('livewire.student.quiz.attempt-page')
            ->layout('components.layouts.app', ['title' => 'Kerjakan Kuis: ' . $this->quiz->title]);
    }
}
