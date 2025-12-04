<?php

namespace App\Livewire\Admin\Quizzes;

use App\Models\Quiz;
use App\Models\Question;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\On;
use Usernotnull\Toast\Concerns\WireToast;
use App\Services\QuestionService;

#[Layout('components.layouts.app')]
class ShowQuiz extends Component
{
    use WireToast;

    public Quiz $quiz;
    public bool $isModalOpen = false;
    public ?Question $editingQuestion = null;

    public function mount(Quiz $quiz)
    {
        $this->quiz = $quiz->load('questions'); // Eager load pertanyaan
    }

    #[On('question-saved')]
    public function refreshQuestions()
    {
        $this->quiz->refresh(); // Refresh data kuis termasuk relasi questions
        $this->isModalOpen = false; // Pastikan modal tertutup setelah simpan
    }

    public function openCreateQuestionModal()
    {
        $this->isModalOpen = true;
        $this->editingQuestion = null;
    }

    public function openEditQuestionModal(Question $question)
    {
        $this->isModalOpen = true;
        $this->editingQuestion = $question;
    }

    #[On('delete-confirmed')]
    public function delete(int $id, QuestionService $questionService)
    {
        try {
            $question = Question::findOrFail($id);
            $questionService->delete($question);
            toast()->info('Pertanyaan berhasil dihapus!')->sticky()->push();
            $this->refreshQuestions();
        } catch (\Exception $e) {
            toast()->danger('Gagal menghapus pertanyaan: ' . $e->getMessage())->sticky()->push();
        }
    }

    #[Title('Kelola Pertanyaan Kuis')]
    public function render()
    {
        return view('livewire.admin.quizzes.show-quiz');
    }
}
