<?php

namespace App\Livewire\Admin\Quizzes;

use App\Models\Question;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;
use App\Services\QuestionService;
use App\Livewire\Admin\Quizzes\Forms\QuestionFormObject;

class FormQuestion extends Component
{
    use WireToast;

    public QuestionFormObject $form;
    public int $quizId;
    public ?Question $question = null;

    public function mount(int $quizId, ?Question $question = null)
    {
        $this->quizId = $quizId;
        $this->form->quiz_id = $quizId;
        if ($question) {
            $this->question = $question;
            $this->form->setQuestion($question);
        }
    }

    public function save(QuestionService $questionService)
    {
        $this->validate();

        try {
            if ($this->question) {
                $questionService->update($this->question, $this->form->all());
                toast()->info('Pertanyaan berhasil diperbarui!')->sticky()->push();
            } else {
                $questionService->create($this->form->all());
                toast()->info('Pertanyaan berhasil ditambahkan!')->sticky()->push();
            }
            $this->dispatch('question-saved');
        } catch (\Exception $e) {
            toast()->danger('Terjadi kesalahan: ' . $e->getMessage())->sticky()->push();
        }
    }

    public function addOption()
    {
        $this->form->addOption();
    }

    public function removeOption(int $index)
    {
        $this->form->removeOption($index);
    }

    public function render()
    {
        return view('livewire.admin.quizzes.form-question');
    }
}
