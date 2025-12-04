<?php

namespace App\Livewire\Admin\Materials;

use App\Models\Material;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;
use App\Livewire\Admin\Materials\Forms\MaterialFormObject;
use App\Enums\MaterialType;
use App\Services\MaterialService;
use Livewire\WithFileUploads;

class FormMaterial extends Component
{
    use WireToast, WithFileUploads;

    public MaterialFormObject $form;
    public int $moduleId;

    /**
     * Properti untuk menampung file PDF yang di-upload.
     * @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile|null
     */
    public $pdf_file;

    public function mount(int $moduleId, ?Material $material = null)
    {
        $this->moduleId = $moduleId;
        $this->form->setMaterial($moduleId, $material);
    }

    public function save(MaterialService $materialService)
    {
        $this->validate(); // Gunakan method rules() untuk validasi dinamis

        try {
            // Jika tipenya PDF dan ada file yang di-upload, proses dulu filenya
            if ($this->form->type === 'pdf' && $this->pdf_file) {
                // Simpan file PDF ke storage/app/public/pdfs
                $path = $this->pdf_file->store('pdfs', 'public');
                // Simpan path-nya ke form object
                $this->form->content_url = $path;
            }

            $isEditing = (bool)$this->form->material;
            $this->form->save($materialService);

            if ($isEditing) {
                toast()->info('Materi berhasil diperbarui!')->push();
            } else {
                toast()->success('Materi berhasil ditambahkan!')->push();
            }

            $this->dispatch('close-modal');
            $this->dispatch('material-saved');
        } catch (\Exception $e) {
            toast()->danger('Gagal menyimpan materi: ' . $e->getMessage())->push();
        }
    }

    /**
     * Aturan validasi dinamis berdasarkan tipe materi.
     */
    public function rules(): array
    {
        $rules = [
            'form.title' => 'required|string|max:255',
            'form.type' => 'required|in:' . implode(',', array_column(MaterialType::cases(), 'value')),
        ];

        switch ($this->form->type) {
            case 'video':
                $rules['form.content_url'] = 'required|url';
                break;
            case 'pdf':
                // Jika sedang edit dan tidak upload file baru, URL lama (path) yg divalidasi
                // Jika upload file baru, validasi file upload-nya
                if ($this->pdf_file) {
                    $rules['pdf_file'] = 'required|file|mimes:pdf|max:10240'; // max 10MB
                } else {
                    $rules['form.content_url'] = 'required|string';
                }
                break;
            case 'text':
                $rules['form.content_body'] = 'required|string';
                break;
        }

        return $rules;
    }

    public function render()
    {
        return view('livewire.admin.materials.form-material', [
            'materialTypes' => MaterialType::cases(),
        ]);
    }
}
