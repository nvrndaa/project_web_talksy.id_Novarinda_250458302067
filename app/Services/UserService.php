<?php

namespace App\Services;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function create(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $data['password'] = Hash::make($data['password']);
            $data['email_verified_at'] = now(); // Langsung verifikasi email untuk user yang dibuat admin
            return User::create($data);
        });
    }

    public function update(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data) {
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                // Jangan update password jika kosong
                unset($data['password']);
            }
            $user->update($data);
            return $user;
        });
    }

    public function delete(User $user): void
    {
        DB::transaction(function () use ($user) {
            // Logika keamanan: Admin tidak boleh menghapus akunnya sendiri
            if ($user->id === auth()->id()) {
                throw new \Exception("Tidak dapat menghapus akun Anda sendiri.");
            }
            $user->delete();
        });
    }
}
