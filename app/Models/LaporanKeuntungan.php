<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKeuntungan extends Model
{
    use HasFactory;

    protected $table = 'laporan_keuntungan';

    protected $fillable = [
        'tanggal',
        'total_penjualan',
        'total_modal',
        'total_keuntungan',
        'total_item',
        'total_produk',
        'total_transaksi',
        'periode_laporan',
        'catatan'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'total_penjualan' => 'decimal:2',
        'total_modal' => 'decimal:2',
        'total_keuntungan' => 'decimal:2',
        'total_item' => 'integer',
        'total_produk' => 'integer',
        'total_transaksi' => 'integer'
    ];

    // Scope untuk filter berdasarkan periode
    public function scopePeriode($query, $periode)
    {
        return $query->where('periode_laporan', $periode);
    }

    // Tambahkan scope dan method helper
    public function scopeFilterByPeriod($query, $start, $end)
    {
        return $query->whereBetween('tanggal', [$start, $end]);
    }

    public function hitungKeuntungan()
    {
        return $this->total_penjualan - $this->total_modal;
    }

    public function hitungMarginKeuntungan()
    {
        return $this->total_penjualan > 0 ? 
            ($this->total_keuntungan / $this->total_penjualan) * 100 : 0;
    }
}

