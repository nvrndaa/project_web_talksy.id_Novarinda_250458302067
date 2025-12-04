<?php

namespace App\Livewire;

use App\Models\Certificate;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.auth')] // Menggunakan layout auth agar tampilan konsisten
#[Title('Verifikasi Sertifikat - Talks.id')]
class CertificateValidationPage extends Component
{
    /**
     * Kode sertifikat yang diinput oleh user.
     * @var string
     */
    public string $code = '';

    /**
     * Hasil pencarian sertifikat.
     * @var Certificate|null
     */
    public ?Certificate $certificate = null;

    /**
     * Flag untuk menandai apakah pencarian sudah dilakukan.
     * @var bool
     */
    public bool $searched = false;

    /**
     * Aturan validasi untuk input kode.
     */
    protected $rules = [
        'code' => 'required|string|min:10',
    ];

    /**
     * Pesan validasi kustom.
     */
    protected $messages = [
        'code.required' => 'Kode sertifikat tidak boleh kosong.',
        'code.min' => 'Format kode sertifikat tidak sesuai.',
    ];

    /**
     * Fungsi yang dipanggil saat form disubmit untuk verifikasi.
     */
    public function verify()
    {
        $this->validate();
        $this->searched = true;

        $this->certificate = Certificate::with('user')
            ->where('certificate_code', $this->code)
            ->first();
    }

    public function render()
    {
        return view('livewire.certificate-validation-page');
    }
}
