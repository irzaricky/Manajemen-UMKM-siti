<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResepProduk extends Model
{
    use HasFactory;

    protected $table = 'resep_produk';

    protected $fillable = [
        'produk_id',
        'bahan_baku_id',
        'jumlah_bahan'
    ];

    // Relasi ke Produk
    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    // Relasi ke Bahan Baku
    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class);
    }
}
