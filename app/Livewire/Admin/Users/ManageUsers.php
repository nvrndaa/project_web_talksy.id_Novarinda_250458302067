<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Enums\UserRole;
use App\Services\UserService;
use Livewire\Attributes\Layout;
use App\Queries\GetUsersQuery;
use Usernotnull\Toast\Concerns\WireToast;

#[Layout('components.layouts.app')]
#[Title('Manajemen Pengguna - Talksy.id')]
class ManageUsers extends Component
{
    use WithPagination, WireToast;

    public string $search = '';
    public ?string $filterRole = null; // Filter berdasarkan role (null, 'admin', 'student')
    public bool $isModalOpen = false;
    public ?User $editingUser = null; // Pengguna yang sedang diedit

    #[On('user-saved')]
    #[On('user-deleted')]
    public function refreshList()
    {
        $this->resetPage(); // Reset halaman ke 1 setelah ada perubahan data
    }

    public function openCreateModal()
    {
        $this->isModalOpen = true;
        $this->editingUser = null;
    }

    public function openEditModal(User $user)
    {
        $this->isModalOpen = true;
        $this->editingUser = $user;
    }

    #[On('delete-confirmed')]
    public function delete(int $id, UserService $userService)
    {
        try {
            $user = User::findOrFail($id);
            $userService->delete($user);
            toast()->info('Pengguna berhasil dihapus!')->sticky()->push();
            $this->refreshList();
        } catch (\Exception $e) {
            toast()->danger('Gagal menghapus pengguna: ' . $e->getMessage())->sticky()->push();
        }
    }

    public function render(GetUsersQuery $query)
    {
        $users = $query->get(
            search: $this->search,
            filterRole: $this->filterRole,
            perPage: 10
        );

        // Ambil semua role yang tersedia untuk filter dropdown
        $roles = UserRole::cases();

        return view('livewire.admin.users.manage-users', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }
}
