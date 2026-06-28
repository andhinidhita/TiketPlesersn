<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pemesanan extends Model
{
    protected $fillable = [
        'user_id',
        'tiket_id',
        'paket_camping_id',
        'jumlah_tiket',
        'tanggal',
        'paket_camping',
        'harga_paket',
        'rental_items',
        'unavailable_rental_items',
        'rental_total',
        'durasi',
        'total_harga',
        'status',
        'availability_status',
        'catatan_admin',
        'bukti_pembayaran',
        'midtrans_order_id',
        'midtrans_status',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'harga_paket' => 'integer',
            'rental_items' => 'array',
            'unavailable_rental_items' => 'array',
            'rental_total' => 'integer',
            'durasi' => 'integer',
            'paid_at' => 'datetime',
        ];
    }

    public function tiket(): BelongsTo
    {
        return $this->belongsTo(Tiket::class);
    }

    public function paketCamping(): BelongsTo
    {
        return $this->belongsTo(PaketCamping::class);
    }

    public function pembayaran(): HasOne
    {
        return $this->hasOne(Pembayaran::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
