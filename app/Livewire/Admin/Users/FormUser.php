<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Usernotnull\Toast\Concerns\WireToast;
use App\Livewire\Admin\Users\Forms\UserFormObject;
use App\Enums\UserRole;

use App\Services\UserService;

class FormUser extends Component
{
    use WireToast;

    public UserFormObject $form;

    public function mount(?User $user = null)
    {
        $this->form->setUser($user);
    }

    public function save(UserService $userService)
    {
        try {
            $isEditing = (bool)$this->form->user;

            $this->form->save($userService);

            if ($isEditing) {
                toast()->info('Pengguna berhasil diperbarui!')->push();
            } else {
                toast()->success('Pengguna berhasil ditambahkan!')->push();
            }

            $this->dispatch('close-modal');
            $this->dispatch('user-saved'); // Beri tahu komponen induk untuk refresh
        } catch (\Exception $e) {
            $this->danger('Gagal menyimpan pengguna: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.admin.users.form-user', [
            'roles' => UserRole::cases(), // Kirim enum roles ke view
        ]);
    }
}
