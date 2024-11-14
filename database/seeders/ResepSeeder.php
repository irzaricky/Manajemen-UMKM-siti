<?php

namespace Database\Seeders;

use App\Models\ResepProduk;
use Illuminate\Database\Seeder;

class ResepSeeder extends Seeder
{
    public function run(): void
    {
        ResepProduk::insert([
            // Ayam Bakar
            [
                'produk_id' => 1,
                'bahan_baku_id' => 1, // Daging Ayam
                'jumlah_bahan' => 0.25,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'produk_id' => 1,
                'bahan_baku_id' => 8, // Bumbu Bakar
                'jumlah_bahan' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Ayam Penyet/Geprek Original
            [
                'produk_id' => 2,
                'bahan_baku_id' => 1, // Daging Ayam
                'jumlah_bahan' => 0.25,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'produk_id' => 2,
                'bahan_baku_id' => 9, // Bumbu Geprek
                'jumlah_bahan' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Gongso Ayam
            [
                'produk_id' => 3,
                'bahan_baku_id' => 1, // Daging Ayam
                'jumlah_bahan' => 0.25,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'produk_id' => 3,
                'bahan_baku_id' => 10, // Bumbu Gongso
                'jumlah_bahan' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Gongso Kulit
            [
                'produk_id' => 4,
                'bahan_baku_id' => 2, // Kulit Ayam
                'jumlah_bahan' => 0.15,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'produk_id' => 4,
                'bahan_baku_id' => 10, // Bumbu Gongso
                'jumlah_bahan' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Pecel Telur Dada
            [
                'produk_id' => 9,
                'bahan_baku_id' => 1, // Daging Ayam
                'jumlah_bahan' => 0.2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'produk_id' => 9,
                'bahan_baku_id' => 6, // Telur
                'jumlah_bahan' => 0.1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'produk_id' => 9,
                'bahan_baku_id' => 11, // Bumbu Pecel
                'jumlah_bahan' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],

            // Minuman
            // Teh
            [
                'produk_id' => 22,
                'bahan_baku_id' => 12, // Teh
                'jumlah_bahan' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Susu
            [
                'produk_id' => 24,
                'bahan_baku_id' => 13, // Susu Sachet
                'jumlah_bahan' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Nutrisari
            [
                'produk_id' => 25,
                'bahan_baku_id' => 14, // Nutrisari
                'jumlah_bahan' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            // Pop Ice
            [
                'produk_id' => 29,
                'bahan_baku_id' => 16, // Bubuk Pop Ice
                'jumlah_bahan' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
