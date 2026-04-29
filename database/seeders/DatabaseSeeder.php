<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 🔥 User default untuk login
        User::create([
            'name' => 'Admin',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 🔥 Panggil tiket seeder
        $this->call(TiketSeeder::class);
    }
}
