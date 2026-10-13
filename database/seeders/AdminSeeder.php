<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Membuat akun administrator dengan kata sandi yang disimpan dalam bentuk hash.
        User::create([
            'name' => 'Admin',
            'email' => 'richou@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('admin123')
        ]);
    }
}
