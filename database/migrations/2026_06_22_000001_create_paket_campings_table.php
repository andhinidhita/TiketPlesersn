<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('paket_campings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket');
            $table->integer('harga');
            $table->text('fasilitas')->nullable();
            $table->timestamps();
        });

        $now = now();
        DB::table('paket_campings')->insert([
            [
                'nama_paket' => 'Paket A',
                'harga' => 275000,
                'fasilitas' => 'Tenda kaps 4, kasur 2, sleeping bag 2, matras 1, kursi set 1, listrik 1, kayu bakar 1',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_paket' => 'Paket B',
                'harga' => 250000,
                'fasilitas' => 'Tenda kaps 4, kasur 3, sleeping bag 3, kursi set 1, listrik 1',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_paket' => 'Paket C',
                'harga' => 185000,
                'fasilitas' => 'Tenda kaps 4, kasur 2, sleeping bag 2, kursi set 1',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_paket' => 'Paket D',
                'harga' => 150000,
                'fasilitas' => 'Tenda kaps 4, kasur 3, sleeping bag 3',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_paket' => 'Paket A+',
                'harga' => 450000,
                'fasilitas' => 'Tenda kaps 6-8, kasur oscar 4, sleeping bag 4, kursi PTL 1, kompor set',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_paket' => 'Paket B+',
                'harga' => 500000,
                'fasilitas' => 'Tenda kaps 6-8, kasur busa 1, bantal guling 1, bed cover 1, kursi PTL 1, kompor set 1, tikar 1, kayu bakar 1, listrik 1',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_paket' => 'Paket Camping Deck Weekday',
                'harga' => 500000,
                'fasilitas' => 'Tenda kaps 6-8, kasur busa, bantal guling, bed cover, alas spons, kursi set, kompor dan cooking set, listrik + lampu, free HTM 4 orang, free parkir, free MCK',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_paket' => 'Paket Camping Deck Weekend',
                'harga' => 700000,
                'fasilitas' => 'Tenda kaps 6-8, kasur busa, bantal guling, bed cover, alas spons, kursi set, kompor dan cooking set, listrik + lampu, free HTM 4 orang, free parkir, free MCK',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('paket_campings');
    }
};
