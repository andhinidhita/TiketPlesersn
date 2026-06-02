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
            $table->string('paket_camping')->nullable()->after('tanggal');
            $table->integer('harga_paket')->default(0)->after('paket_camping');
            $table->unsignedInteger('durasi')->default(1)->after('harga_paket');
            $table->string('availability_status')->default('approved')->after('status');
            $table->text('catatan_admin')->nullable()->after('availability_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pemesanans', function (Blueprint $table) {
            $table->dropColumn([
                'paket_camping',
                'harga_paket',
                'durasi',
                'availability_status',
                'catatan_admin',
            ]);
        });
    }
};
