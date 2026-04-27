<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tiket;

class TiketSeeder extends Seeder
{
    public function run(): void
    {
        Tiket::create([
            'nama_tiket' => 'Tiket Camping',
            'harga' => 15000,
            'stok' => 100
        ]);

        Tiket::create([
            'nama_tiket' => 'Tiket Masuk',
            'harga' => 10000,
            'stok' => 200
        ]);
    }
}