<?php

namespace App\Livewire\Admin\Quizzes\Forms;

use App\Models\Question;
use Livewire\Form;

class QuestionFormObject extends Form
{
    public ?Question $question = null;

    public int $quiz_id;
    public string $question_text = '';
    public array $options = ['', '']; // Minimal 2 opsi
    public ?int $correct_option_index = null;

    public function rules(): array
    {
        return [
            'quiz_id' => 'required|exists:quizzes,id',
            'question_text' => 'required|string|min:10|max:500',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string|min:1|max:255',
            'correct_option_index' => 'required|integer|min:0|max:' . (count($this->options) - 1),
        ];
    }

    public function setQuestion(Question $question)
    {
        $this->question = $question;
        $this->quiz_id = $question->quiz_id;
        $this->question_text = $question->question_text;
        $this->options = $question->options;
        $this->correct_option_index = $question->correct_option_index;
    }

    public function addOption()
    {
        $this->options[] = '';
    }

    public function removeOption(int $index)
    {
        unset($this->options[$index]);
        $this->options = array_values($this->options); // Re-index array

        // Jika kunci jawaban yang benar terhapus, reset
        if ($this->correct_option_index === $index) {
            $this->correct_option_index = null;
        } elseif ($this->correct_option_index > $index) {
            // Sesuaikan index jika opsi yang terhapus ada sebelum kunci jawaban
            $this->correct_option_index--;
        }
    }
}
