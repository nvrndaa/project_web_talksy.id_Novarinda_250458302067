<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat akun Admin
        User::firstOrCreate(
            ['email' => 'admin@talksy.id'],
            [
                'name' => 'Admin Talksy',
                'password' => Hash::make('password'), // Ganti dengan password yang lebih kuat di produksi
                'role' => UserRole::ADMIN,
                'email_verified_at' => now(),
                'avatar_url' => 'https://ui-avatars.com/api/?name=Admin+Talksy&background=065F46&color=fff',
            ]
        );

        // Membuat akun Student
        User::firstOrCreate(
            ['email' => 'student@talksy.id'],
            [
                'name' => 'Student Talksy',
                'password' => Hash::make('password'), // Ganti dengan password yang lebih kuat di produksi
                'role' => UserRole::STUDENT,
                'email_verified_at' => now(),
                'avatar_url' => 'https://ui-avatars.com/api/?name=Student+Talksy&background=D4AF37&color=fff',
            ]
        );

        $this->command->info('Akun Admin dan Student telah berhasil dibuat!');
    }
}
