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
                'stok' => 50,
                'satuan' => 'kg',
                'harga_per_unit' => 35000,
                'minimum_stok' => 5,
                'keterangan' => 'Daging ayam segar',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Kulit Ayam',
                'stok' => 30,
                'satuan' => 'kg',
                'harga_per_unit' => 15000,
                'minimum_stok' => 3,
                'keterangan' => 'Kulit ayam segar',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Ati Ayam',
                'stok' => 25,
                'satuan' => 'kg',
                'harga_per_unit' => 20000,
                'minimum_stok' => 3,
                'keterangan' => 'Ati ayam segar',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Balungan Ayam',
                'stok' => 20,
                'satuan' => 'kg',
                'harga_per_unit' => 10000,
                'minimum_stok' => 2,
                'keterangan' => 'Tulang ayam segar',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Kepala Ayam',
                'stok' => 20,
                'satuan' => 'kg',
                'harga_per_unit' => 12000,
                'minimum_stok' => 2,
                'keterangan' => 'Kepala ayam segar',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Telur',
                'stok' => 100,
                'satuan' => 'kg',
                'harga_per_unit' => 22000,
                'minimum_stok' => 10,
                'keterangan' => 'Telur ayam',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Jamur',
                'stok' => 15,
                'satuan' => 'kg',
                'harga_per_unit' => 18000,
                'minimum_stok' => 2,
                'keterangan' => 'Jamur tiram segar',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Bumbu Bakar',
                'stok' => 50,
                'satuan' => 'porsi',
                'harga_per_unit' => 4000,
                'minimum_stok' => 10,
                'keterangan' => 'Bumbu ayam bakar',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Bumbu Geprek',
                'stok' => 50,
                'satuan' => 'porsi',
                'harga_per_unit' => 6000,
                'minimum_stok' => 10,
                'keterangan' => 'Bumbu ayam geprek',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Bumbu Gongso',
                'stok' => 50,
                'satuan' => 'porsi',
                'harga_per_unit' => 3000,
                'minimum_stok' => 10,
                'keterangan' => 'Bumbu ayam gongso',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Bumbu Pecel',
                'stok' => 50,
                'satuan' => 'porsi',
                'harga_per_unit' => 3000,
                'minimum_stok' => 10,
                'keterangan' => 'Bumbu pecel',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Teh',
                'stok' => 100,
                'satuan' => 'sachet',
                'harga_per_unit' => 6500,
                'minimum_stok' => 20,
                'keterangan' => 'Teh celup',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Susu Sachet',
                'stok' => 100,
                'satuan' => 'sachet',
                'harga_per_unit' => 2000,
                'minimum_stok' => 20,
                'keterangan' => 'Susu sachet',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Nutrisari',
                'stok' => 100,
                'satuan' => 'sachet',
                'harga_per_unit' => 2000,
                'minimum_stok' => 20,
                'keterangan' => 'Minuman serbuk Nutrisari',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Kopi Sachet',
                'stok' => 100,
                'satuan' => 'sachet',
                'harga_per_unit' => 2000,
                'minimum_stok' => 20,
                'keterangan' => 'Kopi sachet',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Bubuk Pop Ice',
                'stok' => 100,
                'satuan' => 'sachet',
                'harga_per_unit' => 2000,
                'minimum_stok' => 20,
                'keterangan' => 'Minuman serbuk Pop Ice',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
