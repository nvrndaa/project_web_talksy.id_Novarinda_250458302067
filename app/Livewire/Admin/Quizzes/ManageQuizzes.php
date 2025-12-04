<?php

namespace App\Livewire\Admin\Quizzes;

use App\Models\Quiz;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Services\QuizService;
use Livewire\Attributes\Layout;
use App\Queries\GetQuizzesQuery;
use Usernotnull\Toast\Concerns\WireToast;

#[Layout('components.layouts.app')]
#[Title('Manajemen Kuis - Talksy.id')]
class ManageQuizzes extends Component
{
    use WithPagination, WireToast;

    public string $search = '';
    public bool $isModalOpen = false; // Properti untuk mengontrol modal
    public ?Quiz $editingQuiz = null; // Kuis yang sedang diedit

    #[On('quiz-saved')]
    #[On('quiz-deleted')]
    public function refreshList()
    {
        $this->resetPage(); // Reset halaman ke 1 setelah ada perubahan data
    }

    public function openCreateModal()
    {
        $this->isModalOpen = true; // Buka flag untuk render konten
        $this->editingQuiz = null;
    }

    public function openEditModal(Quiz $quiz)
    {
        $this->isModalOpen = true; // Buka flag untuk render konten
        $this->editingQuiz = $quiz;
    }

    #[On('delete-confirmed')]
    public function delete(int $id, QuizService $quizService)
    {
        try {
            $quiz = Quiz::findOrFail($id);
            $quizService->delete($quiz);
            toast()->info('Kuis berhasil dihapus!')->sticky()->push();
            $this->refreshList();
        } catch (\Exception $e) {
            toast()->danger('Gagal menghapus kuis: ' . $e->getMessage())->sticky()->push();
        }
    }

    public function render(GetQuizzesQuery $query) // Inject GetQuizzesQuery
    {
        $quizzes = $query->get(
            search: $this->search,
            perPage: 10
        );

        return view('livewire.admin.quizzes.manage-quizzes', [
            'quizzes' => $quizzes,
        ]);
    }
}

