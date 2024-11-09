<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BahanBaku extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'bahan_baku';

    protected $fillable = [
        'nama',
        'stok',
        'satuan',
        'harga_per_unit',
        'minimum_stok',
        'keterangan'
    ];

    protected $casts = [
        'harga_per_unit' => 'decimal:2',
        'stok' => 'integer',
        'minimum_stok' => 'integer'
    ];

    // Relasi ke Resep
    public function resepProduk()
    {
        return $this->hasMany(ResepProduk::class);
    }

    // Relasi ke Produk melalui Resep
    public function produk()
    {
        return $this->belongsToMany(Produk::class, 'resep_produk')
                    ->withPivot('jumlah_bahan')
                    ->withTimestamps();
    }

    // Relasi ke Pembelian
    public function pembelian()
    {
        return $this->hasMany(PembelianBahanBaku::class);
    }

    // Method untuk cek stok minimum
    public function isStokMinimum()
    {
        return $this->stok <= $this->minimum_stok;
    }
}
