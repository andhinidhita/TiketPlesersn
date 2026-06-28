<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemesanan_id')->constrained('pemesanans')->cascadeOnDelete();
            $table->string('order_id')->nullable();
            $table->string('metode')->default('midtrans');
            $table->string('status')->default('pending');
            $table->integer('jumlah_bayar');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });

        DB::table('pemesanans')
            ->whereNotNull('midtrans_order_id')
            ->orWhereNotNull('midtrans_status')
            ->orderBy('id')
            ->get()
            ->each(function ($pemesanan) {
                DB::table('pembayarans')->insert([
                    'pemesanan_id' => $pemesanan->id,
                    'order_id' => $pemesanan->midtrans_order_id,
                    'metode' => 'midtrans',
                    'status' => $pemesanan->midtrans_status ?? $pemesanan->status,
                    'jumlah_bayar' => $pemesanan->total_harga,
                    'paid_at' => $pemesanan->paid_at,
                    'created_at' => $pemesanan->created_at,
                    'updated_at' => $pemesanan->updated_at,
                ]);
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
