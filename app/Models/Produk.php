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
        'harga_modal',
        'stok',
        'minimum_stok',
        'keterangan',
        'gambar'
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'stok' => 'integer',
        'minimum_stok' => 'integer',
        'deleted_at' => 'datetime'
    ];

    // Relasi ke TransaksiDetail
    public function transaksiDetail()
    {
        return $this->hasMany(TransaksiDetail::class);
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

    public function hitungKeuntungan()
    {
        return $this->harga - $this->harga_modal;
    }
}

