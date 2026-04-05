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
            'nama' => 'Admin MaBooks',
            'email' => 'admin@mabooks.id',
            'nomor_telepon' => '081234567890',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);
    }
}
