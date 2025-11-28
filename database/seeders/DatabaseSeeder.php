<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Contoh user dummy
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Jalankan seeder tambahan
        $this->call([
            UserSeeder::class,
            PengadaanSeeder::class,
            PengadaanItemSeeder::class,
        ]);
    }
}
