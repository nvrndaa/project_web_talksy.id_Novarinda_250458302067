<?php

namespace App\Livewire\Admin\Analytics;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Queries\GetMaterialCompletionsQuery;

#[Layout('components.layouts.app')]
#[Title('Laporan Progres Materi - Talksy.id')]
class MaterialCompletionsReport extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render(GetMaterialCompletionsQuery $query)
    {
        $completions = $query->get(
            search: $this->search,
            perPage: 15
        );

        return view('livewire.admin.analytics.material-completions-report', [
            'completions' => $completions,
        ]);
    }
}
