<?php

namespace App\Livewire\Student;

use App\Queries\Curriculum\GetStudentCurriculumQuery;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MyLearningPage extends Component
{
    public $curriculum;

    // Properti untuk statistik di header
    public int $totalModules = 0;
    public int $completedModules = 0;
    public int $totalQuizzes = 0;
    public int $passedQuizzes = 0;
    public int $overallProgress = 0;


    public function mount(GetStudentCurriculumQuery $curriculumQuery)
    {
        $user = Auth::user();
        $this->curriculum = $curriculumQuery->get($user);

        $this->calculateGlobalStats();
    }

    protected function calculateGlobalStats()
    {
        if ($this->curriculum->isEmpty()) {
            return;
        }

        $this->totalModules = $this->curriculum->count();
        $this->totalQuizzes = $this->curriculum->whereNotNull('quiz')->count();

        $completedMaterialsCount = 0;
        $totalMaterialsCount = 0;

        foreach ($this->curriculum as $module) {
            $materialsInModule = $module->materials;
            $totalMaterialsInModule = $materialsInModule->count();
            $completedMaterialsInModule = $materialsInModule->where('is_completed', true)->count();

            $completedMaterialsCount += $completedMaterialsInModule;
            $totalMaterialsCount += $totalMaterialsInModule;

            $quizPassed = $module->quiz?->latestAttempt?->is_passed ?? false;

            if ($completedMaterialsInModule >= $totalMaterialsInModule && $quizPassed) {
                $this->completedModules++;
            }

            if ($quizPassed) {
                $this->passedQuizzes++;
            }
        }

        $totalCompletionPoints = $totalMaterialsCount + $this->totalQuizzes;
        $userCompletionPoints = $completedMaterialsCount + $this->passedQuizzes;

        if ($totalCompletionPoints > 0) {
            $this->overallProgress = round(($userCompletionPoints / $totalCompletionPoints) * 100);
        }
    }


    public function render()
    {
        return view('livewire.student.my-learning-page')
            ->layout('components.layouts.app', ['title' => 'My Learning Path']);
    }
}
