<?php

namespace App\Livewire\Admin\Users\Forms;

use Livewire\Form;
use App\Models\User;
use App\Enums\UserRole;
use App\Services\UserService;
use Illuminate\Validation\Rule;

class UserFormObject extends Form
{
    public ?User $user;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role = UserRole::STUDENT->value;

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($this->user)],
            'password' => $this->user ? 'nullable|string|min:8|confirmed' : 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in(array_column(UserRole::cases(), 'value'))],
        ];
    }

    public function setUser(?User $user = null)
    {
        $this->user = $user;
        $this->fill(
            $user ? $user->toArray() : [
                'name' => '',
                'email' => '',
                'password' => '',
                'password_confirmation' => '',
                'role' => UserRole::STUDENT->value,
            ]
        );
        // Pastikan password tidak terisi saat edit
        if ($this->user) {
            $this->password = '';
            $this->password_confirmation = '';
        }
    }

    public function save(UserService $userService)
    {
        $this->validate();

        if ($this->user) {
            $userService->update($this->user, $this->all());
        } else {
            $userService->create($this->all());
        }
    }
}
