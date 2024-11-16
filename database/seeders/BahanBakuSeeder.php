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
                'stok' => 0,
                'satuan' => 'kg',
                'minimum_stok' => 1,
                'keterangan' => 'Daging ayam segar',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Kulit Ayam',
                'stok' => 0,
                'satuan' => 'kg',
                'minimum_stok' => 1,
                'keterangan' => 'Kulit ayam segar',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Ati Ayam',
                'stok' => 0,
                'satuan' => 'kg',
                'minimum_stok' => 1,
                'keterangan' => 'Ati ayam segar',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Balungan Ayam',
                'stok' => 0,
                'satuan' => 'kg',
                'minimum_stok' => 1,
                'keterangan' => 'Tulang ayam segar',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Kepala Ayam',
                'stok' => 0,
                'satuan' => 'kg',
                'minimum_stok' => 1,
                'keterangan' => 'Kepala ayam segar',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Telur',
                'stok' => 0,
                'satuan' => 'kg',
                'minimum_stok' => 2,
                'keterangan' => 'Telur ayam',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Jamur',
                'stok' => 0,
                'satuan' => 'kg',
                'minimum_stok' => 1,
                'keterangan' => 'Jamur tiram segar',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Bumbu Bakar',
                'stok' => 0,
                'satuan' => 'porsi',
                'minimum_stok' => 5,
                'keterangan' => 'Bumbu ayam bakar',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Bumbu Geprek',
                'stok' => 0,
                'satuan' => 'porsi',
                'minimum_stok' => 5,
                'keterangan' => 'Bumbu ayam geprek',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Bumbu Gongso',
                'stok' => 0,
                'satuan' => 'porsi',
                'minimum_stok' => 5,
                'keterangan' => 'Bumbu ayam gongso',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Bumbu Pecel',
                'stok' => 0,
                'satuan' => 'porsi',
                'minimum_stok' => 5,
                'keterangan' => 'Bumbu pecel',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Teh',
                'stok' => 0,
                'satuan' => 'sachet',
                'minimum_stok' => 10,
                'keterangan' => 'Teh celup',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Susu Sachet',
                'stok' => 0,
                'satuan' => 'sachet',
                'minimum_stok' => 10,
                'keterangan' => 'Susu sachet',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Nutrisari',
                'stok' => 0,
                'satuan' => 'sachet',
                'minimum_stok' => 10,
                'keterangan' => 'Minuman serbuk Nutrisari',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Kopi Sachet',
                'stok' => 0,
                'satuan' => 'sachet',
                'minimum_stok' => 10,
                'keterangan' => 'Kopi sachet',
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'nama' => 'Bubuk Pop Ice',
                'stok' => 0,
                'satuan' => 'sachet',
                'minimum_stok' => 10,
                'keterangan' => 'Minuman serbuk Pop Ice',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
