<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Panggil seeder default untuk user (jika diperlukan)
        // \App\Models\User::factory(10)->create();

        // Panggil seeder kustom untuk data Talksy.id
        $this->call([
            TalksySeeder::class,
        ]);
    }
}

