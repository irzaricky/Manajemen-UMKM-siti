<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenggunaanBahanBaku extends Model
{
    use HasFactory;

    protected $table = 'penggunaan_bahan_baku';

    protected $fillable = [
        'bahan_baku_id',
        'jumlah_digunakan',
        'tanggal_penggunaan',
        'produk_id'
    ];

    protected $casts = [
        'tanggal_penggunaan' => 'date',
        'jumlah_digunakan' => 'integer'
    ];

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }
}
