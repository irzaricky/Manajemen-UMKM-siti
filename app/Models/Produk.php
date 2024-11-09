<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produk extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'produks'; // Changed to match migration table name

    protected $fillable = [
        'tipe',
        'nama',
        'harga',
        'stok',
        'minimum_stok',
        'harga_modal',
        'keterangan'
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

    // Method untuk cek stok minimum
    public function isStokMinimum(): bool
    {
        return $this->stok <= $this->minimum_stok;
    }

    // Method untuk menghitung keuntungan per produk
    public function getKeuntunganAttribute(): float
    {
        return $this->harga - $this->harga_modal;
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

    // Method untuk menambah stok
    public function tambahStok(int $jumlah): bool
    {
        $this->stok += $jumlah;
        return $this->save();
    }

    // Method untuk mengupdate harga modal
    public function updateHargaModal(float $hargaBaru): bool
    {
        $this->harga_modal = $hargaBaru;
        return $this->save();
    }

    // Scope untuk produk dengan stok dibawah minimum
    public function scopeStokMinimum($query)
    {
        return $query->whereRaw('stok <= minimum_stok');
    }

    // Scope untuk mencari produk berdasarkan tipe
    public function scopeTipe($query, string $tipe)
    {
        return $query->where('tipe', $tipe);
    }
}

