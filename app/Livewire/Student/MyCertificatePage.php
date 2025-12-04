<?php

namespace App\Livewire\Student;

use App\Models\Certificate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;

class MyCertificatePage extends Component
{
    public ?Certificate $certificate;

    public function mount()
    {
        $this->certificate = Certificate::where('user_id', Auth::id())->first();
    }

    /**
     * Membuat dan mengunduh sertifikat dalam format PDF.
     */
    public function downloadCertificate()
    {
        // Pastikan user memiliki sertifikat sebelum mencoba mengunduh
        if (!$this->certificate) {
            toast()->danger('Sertifikat tidak ditemukan.')->push();
            return;
        }

        $data = ['certificate' => $this->certificate];

        $pdf = Pdf::loadView('pdf.certificate', $data)
            ->setPaper('a4', 'portrait');

        $filename = 'sertifikat-talksy-' . Str::slug($this->certificate->user->name) . '.pdf';

        // Menggunakan streamDownload untuk mengirim PDF ke browser
        return response()->streamDownload(
            fn() => print($pdf->output()),
            $filename
        );
    }

    public function render()
    {
        return view('livewire.student.my-certificate-page')
            ->layout('components.layouts.app', ['title' => 'Sertifikat Kelulusan']);
    }
}
