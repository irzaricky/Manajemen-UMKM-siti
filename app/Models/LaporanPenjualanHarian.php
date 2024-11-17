<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanPenjualanHarian extends Model
{
    use HasFactory;

    protected $table = 'laporan_penjualan_harian';

    protected $fillable = [
        'tanggal',
        'total_penjualan',
        'total_item',
        'total_transaksi',
        'total_keuntungan',
        'status',
        'user_id'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'total_penjualan' => 'decimal:2',
        'total_keuntungan' => 'decimal:2',
        'total_item' => 'integer',
        'total_transaksi' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
