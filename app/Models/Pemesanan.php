<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    protected $fillable = [
        'user_id',
        'tiket_id',
        'jumlah_tiket',
        'total_harga',
        'status',
        'bukti_pembayaran'
    ];

    public function tiket()
    {
        return $this->belongsTo(Tiket::class);
    }
    public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}
}