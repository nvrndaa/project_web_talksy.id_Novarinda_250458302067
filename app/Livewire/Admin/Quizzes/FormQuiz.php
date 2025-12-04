<?php

namespace App\Livewire\Admin\Quizzes;

use App\Models\Quiz;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;
use App\Services\QuizService;
use App\Livewire\Admin\Quizzes\Forms\QuizFormObject;

class FormQuiz extends Component
{
    use WireToast;

    public QuizFormObject $form;
    public ?Quiz $quiz = null;

    public function mount(?Quiz $quiz = null)
    {
        $this->quiz = $quiz;
        if ($this->quiz) {
            $this->form->setQuiz($quiz);
        }
    }

    public function save(QuizService $quizService)
    {
        $this->validate();

        try {
            if ($this->quiz) {
                $quizService->update($this->quiz, $this->form->all());
                toast()->info('Kuis berhasil diperbarui!')->sticky()->push();
            } else {
                $quizService->create($this->form->all());
                toast()->info('Kuis berhasil ditambahkan!')->sticky()->push();
            }
            $this->dispatch('quiz-saved');
        } catch (\Exception $e) {
            toast()->danger('Terjadi kesalahan: ' . $e->getMessage())->sticky()->push();
        }
    }

    public function render()
    {
        return view('livewire.admin.quizzes.form-quiz');
    }
}
