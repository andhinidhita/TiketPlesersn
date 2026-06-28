<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaketCamping extends Model
{
    protected $fillable = [
        'nama_paket',
        'harga',
        'fasilitas',
    ];

    protected function casts(): array
    {
        return [
            'harga' => 'integer',
        ];
    }

    public function pemesanans(): HasMany
    {
        return $this->hasMany(Pemesanan::class);
    }
}
