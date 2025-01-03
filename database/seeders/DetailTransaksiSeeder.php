<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class DetailTransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $details = collect([
            ['transaksi_id' => 1, 'produk_id' => 20, 'jumlah' => 4, 'harga_satuan' => 9000, 'created_at' => '2024-11-12 12:00:00', 'updated_at' => '2024-11-13 12:00:00'],
            ['transaksi_id' => 1, 'produk_id' => 1, 'jumlah' => 4, 'harga_satuan' => 15000, 'created_at' => '2024-11-12 12:00:00', 'updated_at' => '2024-11-13 12:00:00'],
            ['transaksi_id' => 1, 'produk_id' => 29, 'jumlah' => 2, 'harga_satuan' => 12000, 'created_at' => '2024-11-12 12:00:00', 'updated_at' => '2024-11-13 12:00:00'],
            ['transaksi_id' => 1, 'produk_id' => 2, 'jumlah' => 1, 'harga_satuan' => 3000, 'created_at' => '2024-11-12 12:00:00', 'updated_at' => '2024-11-13 12:00:00'],
            ['transaksi_id' => 1, 'produk_id' => 11, 'jumlah' => 4, 'harga_satuan' => 12000, 'created_at' => '2024-11-12 12:00:00', 'updated_at' => '2024-11-13 12:00:00'],
            ['transaksi_id' => 1, 'produk_id' => 10, 'jumlah' => 5, 'harga_satuan' => 3000, 'created_at' => '2024-11-12 12:00:00', 'updated_at' => '2024-11-13 12:00:00'],
            ['transaksi_id' => 2, 'produk_id' => 6, 'jumlah' => 3, 'harga_satuan' => 9000, 'created_at' => '2024-11-12 15:00:00', 'updated_at' => '2024-11-12 15:00:00'],
            ['transaksi_id' => 2, 'produk_id' => 16, 'jumlah' => 2, 'harga_satuan' => 6000, 'created_at' => '2024-11-12 15:00:00', 'updated_at' => '2024-11-12 15:00:00'],
            ['transaksi_id' => 2, 'produk_id' => 14, 'jumlah' => 4, 'harga_satuan' => 3000, 'created_at' => '2024-11-12 15:00:00', 'updated_at' => '2024-11-12 15:00:00'],
            ['transaksi_id' => 2, 'produk_id' => 21, 'jumlah' => 2, 'harga_satuan' => 12000, 'created_at' => '2024-11-12 15:00:00', 'updated_at' => '2024-11-12 15:00:00'],
            ['transaksi_id' => 2, 'produk_id' => 17, 'jumlah' => 1, 'harga_satuan' => 12000, 'created_at' => '2024-11-12 15:00:00', 'updated_at' => '2024-11-12 15:00:00'],
            ['transaksi_id' => 2, 'produk_id' => 17, 'jumlah' => 4, 'harga_satuan' => 6000, 'created_at' => '2024-11-12 15:00:00', 'updated_at' => '2024-11-12 15:00:00'],
            ['transaksi_id' => 2, 'produk_id' => 7, 'jumlah' => 2, 'harga_satuan' => 3000, 'created_at' => '2024-11-12 15:00:00', 'updated_at' => '2024-11-12 15:00:00'],
            ['transaksi_id' => 2, 'produk_id' => 7, 'jumlah' => 1, 'harga_satuan' => 3000, 'created_at' => '2024-11-12 15:00:00', 'updated_at' => '2024-11-12 15:00:00'],
            ['transaksi_id' => 3, 'produk_id' => 13, 'jumlah' => 3, 'harga_satuan' => 15000, 'created_at' => '2024-11-13 12:00:00', 'updated_at' => '2024-11-13 12:00:00'],
            ['transaksi_id' => 3, 'produk_id' => 6, 'jumlah' => 3, 'harga_satuan' => 3000, 'created_at' => '2024-11-13 12:00:00', 'updated_at' => '2024-11-13 12:00:00'],
            ['transaksi_id' => 3, 'produk_id' => 1, 'jumlah' => 2, 'harga_satuan' => 15000, 'created_at' => '2024-11-13 12:00:00', 'updated_at' => '2024-11-13 12:00:00'],
            ['transaksi_id' => 3, 'produk_id' => 5, 'jumlah' => 1, 'harga_satuan' => 6000, 'created_at' => '2024-11-13 12:00:00', 'updated_at' => '2024-11-13 12:00:00'],
            ['transaksi_id' => 3, 'produk_id' => 1, 'jumlah' => 2, 'harga_satuan' => 15000, 'created_at' => '2024-11-13 12:00:00', 'updated_at' => '2024-11-13 12:00:00'],
            ['transaksi_id' => 3, 'produk_id' => 1, 'jumlah' => 1, 'harga_satuan' => 6000, 'created_at' => '2024-11-13 12:00:00', 'updated_at' => '2024-11-13 12:00:00'],
            ['transaksi_id' => 3, 'produk_id' => 20, 'jumlah' => 2, 'harga_satuan' => 9000, 'created_at' => '2024-11-13 12:00:00', 'updated_at' => '2024-11-13 12:00:00'],
            ['transaksi_id' => 3, 'produk_id' => 1, 'jumlah' => 1, 'harga_satuan' => 3000, 'created_at' => '2024-11-13 12:00:00', 'updated_at' => '2024-11-13 12:00:00'],
            ['transaksi_id' => 4, 'produk_id' => 16, 'jumlah' => 2, 'harga_satuan' => 9000, 'created_at' => '2024-11-13 15:00:00', 'updated_at' => '2024-11-13 15:00:00'],
            ['transaksi_id' => 4, 'produk_id' => 20, 'jumlah' => 4, 'harga_satuan' => 15000, 'created_at' => '2024-11-13 15:00:00', 'updated_at' => '2024-11-13 15:00:00'],
            ['transaksi_id' => 4, 'produk_id' => 23, 'jumlah' => 3, 'harga_satuan' => 6000, 'created_at' => '2024-11-13 15:00:00', 'updated_at' => '2024-11-13 15:00:00'],
            ['transaksi_id' => 4, 'produk_id' => 9, 'jumlah' => 3, 'harga_satuan' => 15000, 'created_at' => '2024-11-13 15:00:00', 'updated_at' => '2024-11-13 15:00:00'],
            ['transaksi_id' => 4, 'produk_id' => 27, 'jumlah' => 4, 'harga_satuan' => 9000, 'created_at' => '2024-11-13 15:00:00', 'updated_at' => '2024-11-13 15:00:00'],
            ['transaksi_id' => 4, 'produk_id' => 19, 'jumlah' => 4, 'harga_satuan' => 12000, 'created_at' => '2024-11-13 15:00:00', 'updated_at' => '2024-11-13 15:00:00'],
            ['transaksi_id' => 4, 'produk_id' => 10, 'jumlah' => 3, 'harga_satuan' => 6000, 'created_at' => '2024-11-13 15:00:00', 'updated_at' => '2024-11-13 15:00:00'],
            ['transaksi_id' => 4, 'produk_id' => 22, 'jumlah' => 3, 'harga_satuan' => 9000, 'created_at' => '2024-11-13 15:00:00', 'updated_at' => '2024-11-13 15:00:00'],
            ['transaksi_id' => 5, 'produk_id' => 29, 'jumlah' => 3, 'harga_satuan' => 6000, 'created_at' => '2024-11-14 12:00:00', 'updated_at' => '2024-11-14 12:00:00'],
            ['transaksi_id' => 5, 'produk_id' => 16, 'jumlah' => 1, 'harga_satuan' => 9000, 'created_at' => '2024-11-14 12:00:00', 'updated_at' => '2024-11-14 12:00:00'],
            ['transaksi_id' => 5, 'produk_id' => 7, 'jumlah' => 4, 'harga_satuan' => 6000, 'created_at' => '2024-11-14 12:00:00', 'updated_at' => '2024-11-14 12:00:00'],
            ['transaksi_id' => 5, 'produk_id' => 24, 'jumlah' => 2, 'harga_satuan' => 12000, 'created_at' => '2024-11-14 12:00:00', 'updated_at' => '2024-11-14 12:00:00'],
            ['transaksi_id' => 5, 'produk_id' => 15, 'jumlah' => 5, 'harga_satuan' => 12000, 'created_at' => '2024-11-14 12:00:00', 'updated_at' => '2024-11-14 12:00:00'],
            ['transaksi_id' => 5, 'produk_id' => 4, 'jumlah' => 5, 'harga_satuan' => 15000, 'created_at' => '2024-11-14 12:00:00', 'updated_at' => '2024-11-14 12:00:00'],
            ['transaksi_id' => 5, 'produk_id' => 19, 'jumlah' => 2, 'harga_satuan' => 9000, 'created_at' => '2024-11-14 12:00:00', 'updated_at' => '2024-11-14 12:00:00'],
            ['transaksi_id' => 5, 'produk_id' => 24, 'jumlah' => 1, 'harga_satuan' => 6000, 'created_at' => '2024-11-14 12:00:00', 'updated_at' => '2024-11-14 12:00:00'],
            ['transaksi_id' => 6, 'produk_id' => 8, 'jumlah' => 4, 'harga_satuan' => 6000, 'created_at' => '2024-11-14 15:00:00', 'updated_at' => '2024-11-14 15:00:00'],
            ['transaksi_id' => 6, 'produk_id' => 26, 'jumlah' => 1, 'harga_satuan' => 15000, 'created_at' => '2024-11-14 15:00:00', 'updated_at' => '2024-11-14 15:00:00'],
            ['transaksi_id' => 6, 'produk_id' => 28, 'jumlah' => 3, 'harga_satuan' => 9000, 'created_at' => '2024-11-14 15:00:00', 'updated_at' => '2024-11-14 15:00:00'],
            ['transaksi_id' => 6, 'produk_id' => 21, 'jumlah' => 2, 'harga_satuan' => 9000, 'created_at' => '2024-11-14 15:00:00', 'updated_at' => '2024-11-14 15:00:00'],
            ['transaksi_id' => 6, 'produk_id' => 22, 'jumlah' => 1, 'harga_satuan' => 15000, 'created_at' => '2024-11-14 15:00:00', 'updated_at' => '2024-11-14 15:00:00'],
            ['transaksi_id' => 6, 'produk_id' => 3, 'jumlah' => 1, 'harga_satuan' => 9000, 'created_at' => '2024-11-14 15:00:00', 'updated_at' => '2024-11-14 15:00:00'],
            ['transaksi_id' => 6, 'produk_id' => 18, 'jumlah' => 3, 'harga_satuan' => 9000, 'created_at' => '2024-11-14 15:00:00', 'updated_at' => '2024-11-14 15:00:00'],
            ['transaksi_id' => 6, 'produk_id' => 20, 'jumlah' => 3, 'harga_satuan' => 15000, 'created_at' => '2024-11-14 15:00:00', 'updated_at' => '2024-11-14 15:00:00'],
            ['transaksi_id' => 6, 'produk_id' => 21, 'jumlah' => 3, 'harga_satuan' => 12000, 'created_at' => '2024-11-14 15:00:00', 'updated_at' => '2024-11-14 15:00:00'],
            ['transaksi_id' => 7, 'produk_id' => 13, 'jumlah' => 5, 'harga_satuan' => 3000, 'created_at' => '2024-11-15 12:00:00', 'updated_at' => '2024-11-15 12:00:00'],
            ['transaksi_id' => 7, 'produk_id' => 28, 'jumlah' => 5, 'harga_satuan' => 9000, 'created_at' => '2024-11-15 12:00:00', 'updated_at' => '2024-11-15 12:00:00'],
            ['transaksi_id' => 7, 'produk_id' => 8, 'jumlah' => 4, 'harga_satuan' => 12000, 'created_at' => '2024-11-15 12:00:00', 'updated_at' => '2024-11-15 12:00:00'],
            ['transaksi_id' => 7, 'produk_id' => 29, 'jumlah' => 4, 'harga_satuan' => 15000, 'created_at' => '2024-11-15 12:00:00', 'updated_at' => '2024-11-15 12:00:00'],
            ['transaksi_id' => 7, 'produk_id' => 9, 'jumlah' => 1, 'harga_satuan' => 6000, 'created_at' => '2024-11-15 12:00:00', 'updated_at' => '2024-11-15 12:00:00'],
            ['transaksi_id' => 7, 'produk_id' => 10, 'jumlah' => 1, 'harga_satuan' => 3000, 'created_at' => '2024-11-15 12:00:00', 'updated_at' => '2024-11-15 12:00:00'],
            ['transaksi_id' => 7, 'produk_id' => 6, 'jumlah' => 4, 'harga_satuan' => 6000, 'created_at' => '2024-11-15 12:00:00', 'updated_at' => '2024-11-15 12:00:00'],
            ['transaksi_id' => 7, 'produk_id' => 1, 'jumlah' => 5, 'harga_satuan' => 12000, 'created_at' => '2024-11-15 12:00:00', 'updated_at' => '2024-11-15 12:00:00'],
            ['transaksi_id' => 7, 'produk_id' => 4, 'jumlah' => 3, 'harga_satuan' => 3000, 'created_at' => '2024-11-15 12:00:00', 'updated_at' => '2024-11-15 12:00:00'],
            ['transaksi_id' => 8, 'produk_id' => 8, 'jumlah' => 3, 'harga_satuan' => 6000, 'created_at' => '2024-11-15 15:00:00', 'updated_at' => '2024-11-15 15:00:00'],
            ['transaksi_id' => 8, 'produk_id' => 7, 'jumlah' => 3, 'harga_satuan' => 15000, 'created_at' => '2024-11-15 15:00:00', 'updated_at' => '2024-11-15 15:00:00'],
            ['transaksi_id' => 8, 'produk_id' => 13, 'jumlah' => 1, 'harga_satuan' => 3000, 'created_at' => '2024-11-15 15:00:00', 'updated_at' => '2024-11-15 15:00:00'],
            ['transaksi_id' => 8, 'produk_id' => 25, 'jumlah' => 1, 'harga_satuan' => 9000, 'created_at' => '2024-11-15 15:00:00', 'updated_at' => '2024-11-15 15:00:00'],
            ['transaksi_id' => 8, 'produk_id' => 1, 'jumlah' => 5, 'harga_satuan' => 15000, 'created_at' => '2024-11-15 15:00:00', 'updated_at' => '2024-11-15 15:00:00'],
            ['transaksi_id' => 8, 'produk_id' => 27, 'jumlah' => 1, 'harga_satuan' => 12000, 'created_at' => '2024-11-15 15:00:00', 'updated_at' => '2024-11-15 15:00:00'],
            ['transaksi_id' => 8, 'produk_id' => 22, 'jumlah' => 4, 'harga_satuan' => 15000, 'created_at' => '2024-11-15 15:00:00', 'updated_at' => '2024-11-15 15:00:00'],
            ['transaksi_id' => 8, 'produk_id' => 9, 'jumlah' => 5, 'harga_satuan' => 9000, 'created_at' => '2024-11-15 15:00:00', 'updated_at' => '2024-11-15 15:00:00'],
            ['transaksi_id' => 8, 'produk_id' => 13, 'jumlah' => 4, 'harga_satuan' => 15000, 'created_at' => '2024-11-15 15:00:00', 'updated_at' => '2024-11-15 15:00:00'],
            ['transaksi_id' => 8, 'produk_id' => 10, 'jumlah' => 4, 'harga_satuan' => 15000, 'created_at' => '2024-11-15 15:00:00', 'updated_at' => '2024-11-15 15:00:00'],
            ['transaksi_id' => 9, 'produk_id' => 21, 'jumlah' => 4, 'harga_satuan' => 15000, 'created_at' => '2024-11-15 18:00:00', 'updated_at' => '2024-11-15 18:00:00'],
            ['transaksi_id' => 9, 'produk_id' => 2, 'jumlah' => 5, 'harga_satuan' => 3000, 'created_at' => '2024-11-15 18:00:00', 'updated_at' => '2024-11-15 18:00:00'],
            ['transaksi_id' => 9, 'produk_id' => 17, 'jumlah' => 2, 'harga_satuan' => 3000, 'created_at' => '2024-11-15 18:00:00', 'updated_at' => '2024-11-15 18:00:00'],
            ['transaksi_id' => 9, 'produk_id' => 14, 'jumlah' => 5, 'harga_satuan' => 6000, 'created_at' => '2024-11-15 18:00:00', 'updated_at' => '2024-11-15 18:00:00'],
            ['transaksi_id' => 9, 'produk_id' => 28, 'jumlah' => 3, 'harga_satuan' => 6000, 'created_at' => '2024-11-15 18:00:00', 'updated_at' => '2024-11-15 18:00:00'],
            ['transaksi_id' => 9, 'produk_id' => 4, 'jumlah' => 5, 'harga_satuan' => 15000, 'created_at' => '2024-11-15 18:00:00', 'updated_at' => '2024-11-15 18:00:00'],
            ['transaksi_id' => 9, 'produk_id' => 6, 'jumlah' => 1, 'harga_satuan' => 9000, 'created_at' => '2024-11-15 18:00:00', 'updated_at' => '2024-11-15 18:00:00'],
            ['transaksi_id' => 9, 'produk_id' => 12, 'jumlah' => 3, 'harga_satuan' => 15000, 'created_at' => '2024-11-15 18:00:00', 'updated_at' => '2024-11-15 18:00:00'],
            ['transaksi_id' => 9, 'produk_id' => 8, 'jumlah' => 2, 'harga_satuan' => 3000, 'created_at' => '2024-11-15 18:00:00', 'updated_at' => '2024-11-15 18:00:00'],
            ['transaksi_id' => 9, 'produk_id' => 21, 'jumlah' => 4, 'harga_satuan' => 6000, 'created_at' => '2024-11-15 18:00:00', 'updated_at' => '2024-11-15 18:00:00'],
            ['transaksi_id' => 10, 'produk_id' => 28, 'jumlah' => 3, 'harga_satuan' => 6000, 'created_at' => '2024-11-16 15:00:00', 'updated_at' => '2024-11-16 15:00:00'],
            ['transaksi_id' => 10, 'produk_id' => 23, 'jumlah' => 1, 'harga_satuan' => 3000, 'created_at' => '2024-11-16 15:00:00', 'updated_at' => '2024-11-16 15:00:00'],
            ['transaksi_id' => 10, 'produk_id' => 12, 'jumlah' => 2, 'harga_satuan' => 12000, 'created_at' => '2024-11-16 15:00:00', 'updated_at' => '2024-11-16 15:00:00'],
            ['transaksi_id' => 10, 'produk_id' => 15, 'jumlah' => 2, 'harga_satuan' => 6000, 'created_at' => '2024-11-16 15:00:00', 'updated_at' => '2024-11-16 15:00:00'],
            ['transaksi_id' => 10, 'produk_id' => 15, 'jumlah' => 2, 'harga_satuan' => 12000, 'created_at' => '2024-11-16 15:00:00', 'updated_at' => '2024-11-16 15:00:00'],
            ['transaksi_id' => 10, 'produk_id' => 10, 'jumlah' => 3, 'harga_satuan' => 6000, 'created_at' => '2024-11-16 15:00:00', 'updated_at' => '2024-11-16 15:00:00'],
            ['transaksi_id' => 10, 'produk_id' => 11, 'jumlah' => 5, 'harga_satuan' => 6000, 'created_at' => '2024-11-16 15:00:00', 'updated_at' => '2024-11-16 15:00:00'],
            ['transaksi_id' => 10, 'produk_id' => 8, 'jumlah' => 3, 'harga_satuan' => 6000, 'created_at' => '2024-11-16 15:00:00', 'updated_at' => '2024-11-16 15:00:00'],
            ['transaksi_id' => 10, 'produk_id' => 3, 'jumlah' => 4, 'harga_satuan' => 9000, 'created_at' => '2024-11-16 15:00:00', 'updated_at' => '2024-11-16 15:00:00'],
            ['transaksi_id' => 10, 'produk_id' => 16, 'jumlah' => 2, 'harga_satuan' => 3000, 'created_at' => '2024-11-16 15:00:00', 'updated_at' => '2024-11-16 15:00:00'],
            ['transaksi_id' => 10, 'produk_id' => 16, 'jumlah' => 5, 'harga_satuan' => 9000, 'created_at' => '2024-11-16 15:00:00', 'updated_at' => '2024-11-16 15:00:00'],
            ['transaksi_id' => 10, 'produk_id' => 20, 'jumlah' => 4, 'harga_satuan' => 3000, 'created_at' => '2024-11-16 15:00:00', 'updated_at' => '2024-11-16 15:00:00'],
            ['transaksi_id' => 10, 'produk_id' => 6, 'jumlah' => 3, 'harga_satuan' => 9000, 'created_at' => '2024-11-16 15:00:00', 'updated_at' => '2024-11-16 15:00:00'],
            ['transaksi_id' => 11, 'produk_id' => 3, 'jumlah' => 3, 'harga_satuan' => 15000, 'created_at' => '2024-11-16 12:00:00', 'updated_at' => '2024-11-17 12:00:00'],
            ['transaksi_id' => 11, 'produk_id' => 14, 'jumlah' => 3, 'harga_satuan' => 12000, 'created_at' => '2024-11-16 12:00:00', 'updated_at' => '2024-11-17 12:00:00'],
            ['transaksi_id' => 11, 'produk_id' => 12, 'jumlah' => 2, 'harga_satuan' => 9000, 'created_at' => '2024-11-16 12:00:00', 'updated_at' => '2024-11-17 12:00:00'],
            ['transaksi_id' => 11, 'produk_id' => 3, 'jumlah' => 2, 'harga_satuan' => 3000, 'created_at' => '2024-11-16 12:00:00', 'updated_at' => '2024-11-17 12:00:00'],
            ['transaksi_id' => 11, 'produk_id' => 17, 'jumlah' => 4, 'harga_satuan' => 12000, 'created_at' => '2024-11-16 12:00:00', 'updated_at' => '2024-11-17 12:00:00'],
            ['transaksi_id' => 11, 'produk_id' => 7, 'jumlah' => 1, 'harga_satuan' => 9000, 'created_at' => '2024-11-16 12:00:00', 'updated_at' => '2024-11-17 12:00:00'],
            ['transaksi_id' => 11, 'produk_id' => 4, 'jumlah' => 1, 'harga_satuan' => 15000, 'created_at' => '2024-11-16 12:00:00', 'updated_at' => '2024-11-17 12:00:00'],
            ['transaksi_id' => 11, 'produk_id' => 12, 'jumlah' => 2, 'harga_satuan' => 6000, 'created_at' => '2024-11-16 12:00:00', 'updated_at' => '2024-11-17 12:00:00'],
            ['transaksi_id' => 11, 'produk_id' => 26, 'jumlah' => 4, 'harga_satuan' => 15000, 'created_at' => '2024-11-16 12:00:00', 'updated_at' => '2024-11-17 12:00:00'],
            ['transaksi_id' => 11, 'produk_id' => 1, 'jumlah' => 2, 'harga_satuan' => 12000, 'created_at' => '2024-11-16 12:00:00', 'updated_at' => '2024-11-17 12:00:00'],
            ['transaksi_id' => 11, 'produk_id' => 27, 'jumlah' => 5, 'harga_satuan' => 6000, 'created_at' => '2024-11-16 12:00:00', 'updated_at' => '2024-11-17 12:00:00'],
            ['transaksi_id' => 12, 'produk_id' => 24, 'jumlah' => 1, 'harga_satuan' => 3000, 'created_at' => '2024-11-17 12:00:00', 'updated_at' => '2024-11-17 12:00:00'],
            ['transaksi_id' => 12, 'produk_id' => 21, 'jumlah' => 5, 'harga_satuan' => 3000, 'created_at' => '2024-11-17 12:00:00', 'updated_at' => '2024-11-17 12:00:00'],
            ['transaksi_id' => 12, 'produk_id' => 12, 'jumlah' => 3, 'harga_satuan' => 15000, 'created_at' => '2024-11-17 12:00:00', 'updated_at' => '2024-11-17 12:00:00'],
            ['transaksi_id' => 12, 'produk_id' => 11, 'jumlah' => 3, 'harga_satuan' => 15000, 'created_at' => '2024-11-17 12:00:00', 'updated_at' => '2024-11-17 12:00:00'],
            ['transaksi_id' => 12, 'produk_id' => 25, 'jumlah' => 5, 'harga_satuan' => 12000, 'created_at' => '2024-11-17 12:00:00', 'updated_at' => '2024-11-17 12:00:00'],
            ['transaksi_id' => 12, 'produk_id' => 14, 'jumlah' => 4, 'harga_satuan' => 3000, 'created_at' => '2024-11-17 12:00:00', 'updated_at' => '2024-11-17 12:00:00'],
            ['transaksi_id' => 12, 'produk_id' => 11, 'jumlah' => 1, 'harga_satuan' => 15000, 'created_at' => '2024-11-17 12:00:00', 'updated_at' => '2024-11-17 12:00:00'],
            ['transaksi_id' => 12, 'produk_id' => 3, 'jumlah' => 1, 'harga_satuan' => 6000, 'created_at' => '2024-11-17 12:00:00', 'updated_at' => '2024-11-17 12:00:00'],
            ['transaksi_id' => 12, 'produk_id' => 16, 'jumlah' => 1, 'harga_satuan' => 6000, 'created_at' => '2024-11-17 12:00:00', 'updated_at' => '2024-11-17 12:00:00'],
            ['transaksi_id' => 12, 'produk_id' => 12, 'jumlah' => 1, 'harga_satuan' => 15000, 'created_at' => '2024-11-17 12:00:00', 'updated_at' => '2024-11-17 12:00:00'],
            ['transaksi_id' => 12, 'produk_id' => 17, 'jumlah' => 1, 'harga_satuan' => 15000, 'created_at' => '2024-11-17 12:00:00', 'updated_at' => '2024-11-17 12:00:00'],
            ['transaksi_id' => 12, 'produk_id' => 25, 'jumlah' => 4, 'harga_satuan' => 12000, 'created_at' => '2024-11-17 12:00:00', 'updated_at' => '2024-11-17 12:00:00'],
            ['transaksi_id' => 13, 'produk_id' => 19, 'jumlah' => 2, 'harga_satuan' => 9000, 'created_at' => '2024-11-17 15:00:00', 'updated_at' => '2024-11-17 15:00:00'],
            ['transaksi_id' => 13, 'produk_id' => 8, 'jumlah' => 1, 'harga_satuan' => 15000, 'created_at' => '2024-11-17 15:00:00', 'updated_at' => '2024-11-17 15:00:00'],
            ['transaksi_id' => 13, 'produk_id' => 20, 'jumlah' => 3, 'harga_satuan' => 15000, 'created_at' => '2024-11-17 15:00:00', 'updated_at' => '2024-11-17 15:00:00'],
            ['transaksi_id' => 13, 'produk_id' => 27, 'jumlah' => 1, 'harga_satuan' => 12000, 'created_at' => '2024-11-17 15:00:00', 'updated_at' => '2024-11-17 15:00:00'],
            ['transaksi_id' => 13, 'produk_id' => 29, 'jumlah' => 2, 'harga_satuan' => 9000, 'created_at' => '2024-11-17 15:00:00', 'updated_at' => '2024-11-17 15:00:00'],
            ['transaksi_id' => 13, 'produk_id' => 22, 'jumlah' => 1, 'harga_satuan' => 12000, 'created_at' => '2024-11-17 15:00:00', 'updated_at' => '2024-11-17 15:00:00'],
            ['transaksi_id' => 13, 'produk_id' => 9, 'jumlah' => 1, 'harga_satuan' => 9000, 'created_at' => '2024-11-17 15:00:00', 'updated_at' => '2024-11-17 15:00:00'],
            ['transaksi_id' => 13, 'produk_id' => 7, 'jumlah' => 3, 'harga_satuan' => 6000, 'created_at' => '2024-11-17 15:00:00', 'updated_at' => '2024-11-17 15:00:00'],
            ['transaksi_id' => 13, 'produk_id' => 21, 'jumlah' => 3, 'harga_satuan' => 12000, 'created_at' => '2024-11-17 15:00:00', 'updated_at' => '2024-11-17 15:00:00'],
            ['transaksi_id' => 13, 'produk_id' => 20, 'jumlah' => 1, 'harga_satuan' => 6000, 'created_at' => '2024-11-17 15:00:00', 'updated_at' => '2024-11-17 15:00:00'],
            ['transaksi_id' => 13, 'produk_id' => 25, 'jumlah' => 5, 'harga_satuan' => 9000, 'created_at' => '2024-11-17 15:00:00', 'updated_at' => '2024-11-17 15:00:00'],
            ['transaksi_id' => 13, 'produk_id' => 23, 'jumlah' => 3, 'harga_satuan' => 9000, 'created_at' => '2024-11-17 15:00:00', 'updated_at' => '2024-11-17 15:00:00'],
            ['transaksi_id' => 14, 'produk_id' => 7, 'jumlah' => 5, 'harga_satuan' => 3000, 'created_at' => '2024-11-18 12:00:00', 'updated_at' => '2024-11-18 12:00:00'],
            ['transaksi_id' => 14, 'produk_id' => 4, 'jumlah' => 1, 'harga_satuan' => 9000, 'created_at' => '2024-11-18 12:00:00', 'updated_at' => '2024-11-18 12:00:00'],
            ['transaksi_id' => 14, 'produk_id' => 1, 'jumlah' => 4, 'harga_satuan' => 15000, 'created_at' => '2024-11-18 12:00:00', 'updated_at' => '2024-11-18 12:00:00'],
            ['transaksi_id' => 14, 'produk_id' => 12, 'jumlah' => 1, 'harga_satuan' => 6000, 'created_at' => '2024-11-18 12:00:00', 'updated_at' => '2024-11-18 12:00:00'],
            ['transaksi_id' => 14, 'produk_id' => 9, 'jumlah' => 4, 'harga_satuan' => 6000, 'created_at' => '2024-11-18 12:00:00', 'updated_at' => '2024-11-18 12:00:00'],
            ['transaksi_id' => 14, 'produk_id' => 1, 'jumlah' => 3, 'harga_satuan' => 15000, 'created_at' => '2024-11-18 12:00:00', 'updated_at' => '2024-11-18 12:00:00'],
            ['transaksi_id' => 14, 'produk_id' => 29, 'jumlah' => 2, 'harga_satuan' => 3000, 'created_at' => '2024-11-18 12:00:00', 'updated_at' => '2024-11-18 12:00:00'],
            ['transaksi_id' => 14, 'produk_id' => 1, 'jumlah' => 3, 'harga_satuan' => 15000, 'created_at' => '2024-11-18 12:00:00', 'updated_at' => '2024-11-18 12:00:00'],
            ['transaksi_id' => 14, 'produk_id' => 2, 'jumlah' => 3, 'harga_satuan' => 6000, 'created_at' => '2024-11-18 12:00:00', 'updated_at' => '2024-11-18 12:00:00'],
            ['transaksi_id' => 14, 'produk_id' => 24, 'jumlah' => 3, 'harga_satuan' => 6000, 'created_at' => '2024-11-18 12:00:00', 'updated_at' => '2024-11-18 12:00:00'],
            ['transaksi_id' => 14, 'produk_id' => 7, 'jumlah' => 3, 'harga_satuan' => 15000, 'created_at' => '2024-11-18 12:00:00', 'updated_at' => '2024-11-18 12:00:00'],
            ['transaksi_id' => 15, 'produk_id' => 8, 'jumlah' => 1, 'harga_satuan' => 6000, 'created_at' => '2024-11-18 15:00:00', 'updated_at' => '2024-11-18 15:00:00'],
            ['transaksi_id' => 15, 'produk_id' => 9, 'jumlah' => 4, 'harga_satuan' => 12000, 'created_at' => '2024-11-18 15:00:00', 'updated_at' => '2024-11-18 15:00:00'],
            ['transaksi_id' => 15, 'produk_id' => 27, 'jumlah' => 4, 'harga_satuan' => 6000, 'created_at' => '2024-11-18 15:00:00', 'updated_at' => '2024-11-18 15:00:00'],
            ['transaksi_id' => 15, 'produk_id' => 29, 'jumlah' => 1, 'harga_satuan' => 15000, 'created_at' => '2024-11-18 15:00:00', 'updated_at' => '2024-11-18 15:00:00'],
            ['transaksi_id' => 15, 'produk_id' => 14, 'jumlah' => 2, 'harga_satuan' => 15000, 'created_at' => '2024-11-18 15:00:00', 'updated_at' => '2024-11-18 15:00:00'],
            ['transaksi_id' => 15, 'produk_id' => 16, 'jumlah' => 2, 'harga_satuan' => 6000, 'created_at' => '2024-11-18 15:00:00', 'updated_at' => '2024-11-18 15:00:00'],
            ['transaksi_id' => 15, 'produk_id' => 15, 'jumlah' => 1, 'harga_satuan' => 9000, 'created_at' => '2024-11-18 15:00:00', 'updated_at' => '2024-11-18 15:00:00'],
            ['transaksi_id' => 15, 'produk_id' => 21, 'jumlah' => 5, 'harga_satuan' => 6000, 'created_at' => '2024-11-18 15:00:00', 'updated_at' => '2024-11-18 15:00:00'],
            ['transaksi_id' => 15, 'produk_id' => 13, 'jumlah' => 4, 'harga_satuan' => 9000, 'created_at' => '2024-11-18 15:00:00', 'updated_at' => '2024-11-18 15:00:00'],
            ['transaksi_id' => 15, 'produk_id' => 29, 'jumlah' => 2, 'harga_satuan' => 12000, 'created_at' => '2024-11-18 15:00:00', 'updated_at' => '2024-11-18 15:00:00'],
            ['transaksi_id' => 15, 'produk_id' => 4, 'jumlah' => 2, 'harga_satuan' => 9000, 'created_at' => '2024-11-18 15:00:00', 'updated_at' => '2024-11-18 15:00:00'],
            ['transaksi_id' => 15, 'produk_id' => 19, 'jumlah' => 4, 'harga_satuan' => 6000, 'created_at' => '2024-11-18 15:00:00', 'updated_at' => '2024-11-18 15:00:00'],
            ['transaksi_id' => 15, 'produk_id' => 18, 'jumlah' => 1, 'harga_satuan' => 12000, 'created_at' => '2024-11-18 15:00:00', 'updated_at' => '2024-11-18 15:00:00'],
            ['transaksi_id' => 15, 'produk_id' => 26, 'jumlah' => 2, 'harga_satuan' => 3000, 'created_at' => '2024-11-18 15:00:00', 'updated_at' => '2024-11-18 15:00:00'],
        ])->map(function ($item) {
            $item['created_at'] = \Carbon\Carbon::parse($item['created_at']);
            $item['updated_at'] = \Carbon\Carbon::parse($item['updated_at']);
            return $item;
        })->toArray();

        // Chunk insert for better performance
        collect($details)->chunk(100)->each(function ($chunk) {
            DB::table('detail_transaksi')->insert($chunk->toArray());
        });
    }
}
