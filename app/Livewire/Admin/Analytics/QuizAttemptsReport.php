<?php

namespace App\Livewire\Admin\Analytics;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use App\Queries\GetQuizAttemptsQuery;

#[Layout('components.layouts.app')]
#[Title('Laporan Hasil Kuis - Talksy.id')]
class QuizAttemptsReport extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterStatus = 'all';

    // Reset page when user types in search or changes filter
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterStatus()
    {
        $this->resetPage();
    }

    #[Computed]
    public function statusOptions()
    {
        return [
            ['value' => 'all', 'label' => 'Semua Status'],
            ['value' => 'passed', 'label' => 'Lulus'],
            ['value' => 'failed', 'label' => 'Gagal'],
        ];
    }

    public function render(GetQuizAttemptsQuery $query)
    {
        $attempts = $query->get(
            search: $this->search,
            filterStatus: $this->filterStatus,
            perPage: 15
        );

        return view('livewire.admin.analytics.quiz-attempts-report', [
            'attempts' => $attempts,
        ]);
    }
}
