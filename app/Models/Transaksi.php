<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $fillable = ['tanggal', 'total_harga', 'tipe_pembayaran'];

    // Relasi ke TransaksiDetail
    public function transaksiDetail()
    {
        return $this->hasMany(DetailTransaksi::class);
    }
}

