<?php

namespace Database\Seeders;

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
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'password' => 'admin123',
            'role' => 'admin',
            'phone' => '081234567890',
        ]);

        User::create([
            'name' => 'Siswa Example',
            'username' => 'siswa',
            'password' => 'siswa123',
            'role' => 'student',
            'nik' => '1234567890123456',
            'phone' => '081234567892',
        ]);
    }
}
