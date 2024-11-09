<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PembelianBahanBaku extends Model
{
    use HasFactory;

    protected $table = 'pembelian_bahan_baku';

    protected $fillable = [
        'bahan_baku_id',
        'jumlah',
        'harga_per_unit',
        'total_harga',
        'tanggal_pembelian',
        'nomor_invoice',
    ];

    protected $casts = [
        'tanggal_pembelian' => 'date',
        'harga_per_unit' => 'decimal:2',
        'total_harga' => 'decimal:2',
        'jumlah' => 'integer'
    ];

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
