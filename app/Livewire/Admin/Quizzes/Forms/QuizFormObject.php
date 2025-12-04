<?php

namespace App\Livewire\Admin\Quizzes\Forms;

use App\Models\Module;
use App\Models\Quiz;
use Livewire\Form;
use Illuminate\Validation\Rule;

class QuizFormObject extends Form
{
    public ?Quiz $quiz = null;

    public string $title = '';
    public ?int $module_id = null;
    public int $passing_score = 70;

    public function setQuiz(Quiz $quiz)
    {
        $this->quiz = $quiz;
        $this->title = $quiz->title;
        $this->module_id = $quiz->module_id;
        $this->passing_score = $quiz->passing_score;
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'min:3',
                'max:255',
                Rule::unique('quizzes')->ignore($this->quiz->id ?? null),
            ],
            'module_id' => [
                'required',
                'exists:modules,id',
            ],
            'passing_score' => [
                'required',
                'integer',
                'min:0',
                'max:100',
            ],
        ];
    }

    public function getModuleOptions()
    {
        return Module::orderBy('title')->pluck('title', 'id');
    }
}
