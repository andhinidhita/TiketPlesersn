<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pemesanans', function (Blueprint $table) {
            $table->foreignId('paket_camping_id')
                ->nullable()
                ->after('tiket_id')
                ->constrained('paket_campings')
                ->nullOnDelete();
        });

        DB::table('pemesanans')
            ->whereNotNull('paket_camping')
            ->orderBy('id')
            ->get(['id', 'paket_camping'])
            ->each(function ($pemesanan) {
                $paketId = DB::table('paket_campings')
                    ->where('nama_paket', $pemesanan->paket_camping)
                    ->value('id');

                if ($paketId) {
                    DB::table('pemesanans')
                        ->where('id', $pemesanan->id)
                        ->update(['paket_camping_id' => $paketId]);
                }
            });
    }

    public function down(): void
    {
        Schema::table('pemesanans', function (Blueprint $table) {
            $table->dropConstrainedForeignId('paket_camping_id');
        });
    }
};
