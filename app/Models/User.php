<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function laporanPenjualanHarian()
    {
        return $this->hasMany(LaporanPenjualanHarian::class);
    }

    public function pembelianBahanBaku()
    {
        return $this->hasMany(PembelianBahanBaku::class);
    }
}
