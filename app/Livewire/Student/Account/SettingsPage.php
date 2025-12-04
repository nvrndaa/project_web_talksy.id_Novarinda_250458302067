<?php

namespace App\Livewire\Student\Account;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Livewire\Component;
use Livewire\WithFileUploads; // Import trait untuk upload file
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Usernotnull\Toast\Concerns\WireToast;

#[Layout('components.layouts.app')]
#[Title('Pengaturan Akun - Talks.id')]
class SettingsPage extends Component
{
    use WithFileUploads, WireToast; // Gunakan trait

    // Properti untuk menampung state dari form
    public array $profileState = [];
    public array $passwordState = [];

    /**
     * Properti untuk upload foto profil.
     * @var \Livewire\Features\SupportFileUploads\TemporaryUploadedFile|null
     */
    public $photo;

    public function mount()
    {
        $user = Auth::user();
        $this->profileState = [
            'name' => $user->name,
            'email' => $user->email,
        ];
    }

    /**
     * Menyimpan avatar baru.
     */
    public function saveAvatar()
    {
        $this->validate([
            'photo' => 'required|image|max:2048', // Maks 2MB
        ]);

        $user = Auth::user();

        // Hapus avatar lama jika ada, untuk menghemat space
        if ($user->avatar_url) {
            $oldPath = str_replace('/storage', '', $user->avatar_url);
            Storage::disk('public')->delete($oldPath);
        }

        // Simpan file baru dan dapatkan path-nya
        $path = $this->photo->store('avatars', 'public');

        // Update database dengan URL yang bisa diakses publik
        $user->forceFill([
            'avatar_url' => Storage::url($path),
        ])->save();

        // Reset properti photo setelah upload
        $this->photo = null;

        toast()->success('Foto profil berhasil diperbarui.')->push();

        // Kirim event untuk refresh komponen lain yang menampilkan avatar
        $this->dispatch('profile-picture-updated');
    }

    /**
     * Memperbarui informasi profil pengguna.
     */
    public function updateProfile(UpdatesUserProfileInformation $updater)
    {
        $this->resetErrorBag();
        $updater->update(Auth::user(), $this->profileState);
        toast()->success('Profil berhasil diperbarui.')->push();
        $this->dispatch('user-profile-updated', name: $this->profileState['name']);
    }

    /**
     * Memperbarui password pengguna.
     */
    public function updatePassword(UpdatesUserPasswords $updater)
    {
        $this->resetErrorBag();
        $updater->update(Auth::user(), $this->passwordState);
        $this->passwordState = [];
        toast()->success('Password berhasil diperbarui.')->push();
    }

    public function render()
    {
        return view('livewire.student.account.settings-page');
    }
}
