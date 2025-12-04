<?php

namespace App\Livewire\Student;

use App\Queries\GetUserQuizAttemptsQuery;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
#[Title('Riwayat Kuis Saya - Talks.id')]
class MyResultsPage extends Component
{
    // Gunakan trait paginasi dari Livewire
    use WithPagination;

    public function render(GetUserQuizAttemptsQuery $query)
    {
        // Ambil data dengan paginasi
        $attempts = $query->get(Auth::user());

        return view('livewire.student.my-results-page', [
            'attempts' => $attempts,
        ]);
    }
}
