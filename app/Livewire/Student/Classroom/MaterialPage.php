<?php

namespace App\Livewire\Student\Classroom;

use App\Models\Material;
use App\Services\LearningService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Usernotnull\Toast\Concerns\WireToast;

#[Layout('components.layouts.app')]
class MaterialPage extends Component
{
    use WireToast;
    public Material $material;
    public bool $isCompleted = false;
    public ?string $videoUrl = null;

    // Properti untuk navigasi
    public ?Material $previousMaterial = null;
    public ?Material $nextMaterial = null;

    #[Title('Loading...')]
    public function mount(Material $material)
    {
        $this->material = $material->load('module'); // Eager load module
        $this->isCompleted = $this->checkIfCompleted();

        if ($this->material->type === 'video') {
            $this->videoUrl = $this->getEmbedUrl($this->material->content_url);
        }

        $this->loadNavigation();

        // Set judul halaman secara dinamis
        $this->dispatch('set-title', title: $this->material->title);
    }

    private function loadNavigation(): void
    {
        // Ambil semua materi dalam modul yang sama, terurut
        $materialsInModule = $this->material->module->materials()->orderBy('id')->get();

        // Cari index dari materi saat ini
        $currentIndex = $materialsInModule->search(fn($item) => $item->id === $this->material->id);

        if ($currentIndex === false) return; // Materi tidak ditemukan, skip

        // Set materi sebelumnya jika ada
        if ($currentIndex > 0) {
            $this->previousMaterial = $materialsInModule[$currentIndex - 1];
        }

        // Set materi selanjutnya jika ada
        if ($currentIndex < $materialsInModule->count() - 1) {
            $this->nextMaterial = $materialsInModule[$currentIndex + 1];
        }
    }

    private function checkIfCompleted(): bool
    {
        return Auth::user()->completions()->where('material_id', $this->material->id)->exists();
    }

    public function markAsComplete(LearningService $learningService)
    {
        // Panggil service untuk menandai selesai
        $learningService->markMaterialAsComplete(Auth::user(), $this->material);

        // Update status di UI dan berikan feedback
        $this->isCompleted = true;
        toast()->success('Materi berhasil diselesaikan!')->push();
    }

    /**
     * Mengubah URL YouTube biasa menjadi URL embed.
     */
    private function getEmbedUrl(?string $url): ?string
    {
        if (!$url) {
            return null;
        }

        // Pattern Regex yang lebih robust untuk menangani short link (youtu.be) & parameter (si, feature, dll)
        $pattern = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';

        if (preg_match($pattern, $url, $match)) {
            $videoId = $match[1];

            // Return URL Embed standar
            // rel=0: Agar rekomendasi video di akhir berasal dari channel yang sama
            return 'https://www.youtube.com/embed/' . $videoId . '?rel=0&modestbranding=1';
        }

        return null;
    }

    public function render()
    {
        return view('livewire.student.classroom.material-page');
    }
}
