<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash; // Tambahkan ini
use App\Models\User; // Tambahkan ini

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat User Admin
        User::create([
            'name' => 'Admin Library',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        // Buat User Biasa
        User::create([
            'name' => 'User Biasa',
            'email' => 'user@example.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);

        // Anda bisa tambahkan user lain di sini jika perlu
        User::create([
            'name' => 'User Kedua',
            'email' => 'user2@example.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
        ]);
    }
}