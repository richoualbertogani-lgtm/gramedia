<?php

namespace Database\Seeders;

use App\Models\SubscriptionPackage;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Menambahkan akun contoh untuk kebutuhan awal aplikasi.
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Menyediakan paket bawaan; firstOrCreate mencegah duplikasi berdasarkan nama.
        $defaultPackages = [
            [
                'name' => 'Paket Silver',
                'description' => 'Akses e-book dasar dengan fitur membaca ringan.',
                'price' => 49000,
                'color' => '#cfe2ff',
            ],
            [
                'name' => 'Paket Gold',
                'description' => 'Akses penuh untuk membaca lebih banyak judul premium.',
                'price' => 99000,
                'color' => '#fff3cd',
            ],
            [
                'name' => 'Paket Platinum',
                'description' => 'Nikmati semua fitur plus prioritas akses konten baru.',
                'price' => 149000,
                'color' => '#d1e7dd',
            ],
        ];

        foreach ($defaultPackages as $package) {
            SubscriptionPackage::firstOrCreate(
                ['name' => $package['name']],
                $package
            );
        }
    }
}
