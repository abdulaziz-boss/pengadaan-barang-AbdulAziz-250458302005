<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin Sistem',
            'email' => 'admin@example.com',
            'email_verified_at' => now(), // Sudah verified
            'password' => Hash::make('123456'),
            'remember_token' => Str::random(10),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Manager Utama',
            'email' => 'manager@example.com',
            'email_verified_at' => now(), // Sudah verified
            'password' => Hash::make('123456'),
            'remember_token' => Str::random(10),
            'role' => 'manager',
        ]);

        User::create([
            'name' => 'Staff Operasional',
            'email' => 'staff@example.com',
            'email_verified_at' => now(), // Sudah verified
            'password' => Hash::make('123456'),
            'remember_token' => Str::random(10),
            'role' => 'staff',
        ]);

        User::create([
            'name' => 'Staff Keuangan',
            'email' => 'staffkeuangan@example.com',
            'email_verified_at' => now(), // Sudah verified
            'password' => Hash::make('123456'),
            'remember_token' => Str::random(10),
            'role' => 'admin',
        ]);
    }
}
