<?php

namespace Database\Seeders;

use App\Models\BahanBaku;
use Illuminate\Database\Seeder;

class BahanBakuSeeder extends Seeder
{
    public function run(): void
    {
        BahanBaku::insert([
            [
                'nama' => 'Daging Ayam',
                'stok' => 5,
                'satuan' => 'kg',
                'harga_per_unit' => 35000,
                'minimum_stok' => 1,
                'keterangan' => 'Daging ayam segar',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Kulit Ayam',
                'stok' => 3,
                'satuan' => 'kg',
                'harga_per_unit' => 15000,
                'minimum_stok' => 1,
                'keterangan' => 'Kulit ayam segar',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Ati Ayam',
                'stok' => 2,
                'satuan' => 'kg',
                'harga_per_unit' => 20000,
                'minimum_stok' => 1,
                'keterangan' => 'Ati ayam segar',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Balungan Ayam',
                'stok' => 2,
                'satuan' => 'kg',
                'harga_per_unit' => 10000,
                'minimum_stok' => 1,
                'keterangan' => 'Tulang ayam segar',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Kepala Ayam',
                'stok' => 2,
                'satuan' => 'kg',
                'harga_per_unit' => 12000,
                'minimum_stok' => 1,
                'keterangan' => 'Kepala ayam segar',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Telur',
                'stok' => 4,
                'satuan' => 'kg',
                'harga_per_unit' => 22000,
                'minimum_stok' => 2,
                'keterangan' => 'Telur ayam',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Jamur',
                'stok' => 2,
                'satuan' => 'kg',
                'harga_per_unit' => 18000,
                'minimum_stok' => 1,
                'keterangan' => 'Jamur tiram segar',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Bumbu Bakar',
                'stok' => 20,
                'satuan' => 'porsi',
                'harga_per_unit' => 4000,
                'minimum_stok' => 5,
                'keterangan' => 'Bumbu ayam bakar',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Bumbu Geprek',
                'stok' => 20,
                'satuan' => 'porsi',
                'harga_per_unit' => 6000,
                'minimum_stok' => 5,
                'keterangan' => 'Bumbu ayam geprek',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Bumbu Gongso',
                'stok' => 20,
                'satuan' => 'porsi',
                'harga_per_unit' => 3000,
                'minimum_stok' => 5,
                'keterangan' => 'Bumbu ayam gongso',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Bumbu Pecel',
                'stok' => 20,
                'satuan' => 'porsi',
                'harga_per_unit' => 3000,
                'minimum_stok' => 5,
                'keterangan' => 'Bumbu pecel',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Teh',
                'stok' => 30,
                'satuan' => 'sachet',
                'harga_per_unit' => 6500,
                'minimum_stok' => 10,
                'keterangan' => 'Teh celup',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Susu Sachet',
                'stok' => 20,
                'satuan' => 'sachet',
                'harga_per_unit' => 2000,
                'minimum_stok' => 10,
                'keterangan' => 'Susu sachet',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Nutrisari',
                'stok' => 25,
                'satuan' => 'sachet',
                'harga_per_unit' => 2000,
                'minimum_stok' => 10,
                'keterangan' => 'Minuman serbuk Nutrisari',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Kopi Sachet',
                'stok' => 15,
                'satuan' => 'sachet',
                'harga_per_unit' => 2000,
                'minimum_stok' => 10,
                'keterangan' => 'Kopi sachet',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Bubuk Pop Ice',
                'stok' => 25,
                'satuan' => 'sachet',
                'harga_per_unit' => 2000,
                'minimum_stok' => 10,
                'keterangan' => 'Minuman serbuk Pop Ice',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
