<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tiket extends Model
{
    protected $fillable = [
        'nama_tiket',
        'harga',
        'stok',
    ];

    protected function casts(): array
    {
        return [
            'harga' => 'integer',
            'stok' => 'integer',
        ];
    }

    public function pemesanans(): HasMany
    {
        return $this->hasMany(Pemesanan::class);
    }
}
