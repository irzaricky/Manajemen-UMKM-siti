<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanKeuntungan extends Model
{
    use HasFactory;

    protected $table = 'laporan_keuntungan';
    protected $fillable = ['bulan', 'tahun', 'total_pendapatan', 'total_transaksi'];
}

