<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat akun Admin tunggal
        User::create([
            'nisn' => 'admin', 
            'password' => Hash::make('admin123'), 
            'role' => 'admin',
        ]);
    }
}