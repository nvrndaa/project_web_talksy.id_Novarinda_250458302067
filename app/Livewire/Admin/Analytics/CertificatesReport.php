<?php

namespace App\Livewire\Admin\Analytics;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use App\Queries\GetCertificatesQuery;

#[Layout('components.layouts.app')]
#[Title('Daftar Sertifikat - Talksy.id')]
class CertificatesReport extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render(GetCertificatesQuery $query)
    {
        $certificates = $query->get(
            search: $this->search,
            perPage: 15
        );

        return view('livewire.admin.analytics.certificates-report', [
            'certificates' => $certificates,
        ]);
    }
}
