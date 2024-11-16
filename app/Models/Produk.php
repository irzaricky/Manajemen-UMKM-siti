<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produks'; // Changed to match migration table name

    protected $fillable = [
        'tipe',
        'nama',
        'harga',
        'stok',
        'harga_modal',
        'keterangan',
        'gambar'
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'harga_modal' => 'decimal:2',
        'stok' => 'integer',
        'minimum_stok' => 'integer',
        'deleted_at' => 'datetime'
    ];

    // Relasi ke TransaksiDetail
    public function transaksiDetail()
    {
        return $this->hasMany(TransaksiDetail::class);
    }

    // Relasi ke Resep
    public function resepProduk()
    {
        return $this->hasMany(ResepProduk::class);
    }

    // Relasi ke Bahan Baku melalui Resep
    public function bahanBaku()
    {
        return $this->belongsToMany(BahanBaku::class, 'resep_produk')
            ->withPivot('jumlah_bahan')
            ->withTimestamps();
    }

    // Relasi ke PenggunaanBahanBaku
    public function penggunaanBahanBaku()
    {
        return $this->hasMany(PenggunaanBahanBaku::class);
    }


    // Method untuk mengurangi stok
    public function kurangiStok(int $jumlah): bool
    {
        if ($this->stok >= $jumlah) {
            $this->stok -= $jumlah;
            return $this->save();
        }
        return false;
    }
}

