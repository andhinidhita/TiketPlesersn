<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    protected $fillable = [
        'pemesanan_id',
        'order_id',
        'metode',
        'status',
        'jumlah_bayar',
        'paid_at',
    ];

    protected function casts(): array
    {
        return [
            'jumlah_bayar' => 'integer',
            'paid_at' => 'datetime',
        ];
    }

    public function pemesanan(): BelongsTo
    {
        return $this->belongsTo(Pemesanan::class);
    }
}
