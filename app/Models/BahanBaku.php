<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class BahanBaku extends Model
{
    use HasFactory;

    protected $table = 'bahan_baku';

    protected $fillable = [
        'nama',
        'stok',
        'satuan',
        'minimum_stok',
        'keterangan',
        'gambar'
    ];

    protected $casts = [
        'stok' => 'integer',
        'minimum_stok' => 'integer'
    ];

    // Relasi ke Pembelian
    public function pembelian()
    {
        return $this->hasMany(PembelianBahanBaku::class);
    }
}
