<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pemesanans', function (Blueprint $table) {
            $table->string('midtrans_order_id')->nullable()->after('bukti_pembayaran');
            $table->string('midtrans_status')->nullable()->after('midtrans_order_id');
            $table->timestamp('paid_at')->nullable()->after('midtrans_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemesanans', function (Blueprint $table) {
            $table->dropColumn(['midtrans_order_id', 'midtrans_status', 'paid_at']);
        });
    }
};
