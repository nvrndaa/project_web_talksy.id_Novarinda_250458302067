<?php

namespace App\Livewire;

use App\Services\LandingPageService;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.guest')]
class HomePage extends Component
{
    public array $navLinks = [];
    public array $stats = [];
    public $modules; // Bisa jadi collection, jadi tidak perlu di-type-hint array

    public function mount(LandingPageService $landingPageService)
    {
        // Tetap statis karena ini data presentasional
        $this->navLinks = [
            ['href' => '#kurikulum', 'text' => 'Kurikulum'],
            ['href' => '/verify', 'text' => 'Verifikasi Sertifikat'],
        ];

        // Ambil data dari service
        $this->stats = $landingPageService->getStats();
        $this->modules = $landingPageService->getCurriculumPreview();
    }

    public function render()
    {
        return view('livewire.home-page');
    }
}
