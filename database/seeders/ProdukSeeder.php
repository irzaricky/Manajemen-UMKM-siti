<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Produk;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Produk::insert([
            ['nama' => 'Paket ayam bakar', 'tipe' => 'Makanan', 'harga' => '16000'],
            ['nama' => 'Paket ayam penyet', 'tipe' => 'Makanan', 'harga' => '15000'],
            ['nama' => 'Paket gongso ayam', 'tipe' => 'Makanan', 'harga' => '16000'],
            ['nama' => 'Paket gongso kulit', 'tipe' => 'Makanan', 'harga' => '14000'],
            ['nama' => 'Paket gongso kulit ati', 'tipe' => 'Makanan', 'harga' => '16000'],
            ['nama' => 'Paket gongso ati', 'tipe' => 'Makanan', 'harga' => '14000'],
            ['nama' => 'paket goreng ati', 'tipe' => 'Makanan', 'harga' => '14000'],
            ['nama' => 'Paket rica ayam jamur', 'tipe' => 'Makanan', 'harga' => '14000'],
            ['nama' => 'Paket pecel telur dada', 'tipe' => 'Makanan', 'harga' => '13000'],
            ['nama' => 'Paket pecel jamur', 'tipe' => 'Makanan', 'harga' => '12000'],
            ['nama' => 'Paket kepala gongso', 'tipe' => 'Makanan', 'harga' => '13000'],
            ['nama' => 'Paket kepala goreng', 'tipe' => 'Makanan', 'harga' => '13000'],
            ['nama' => 'Paket balungan ayam', 'tipe' => 'Makanan', 'harga' => '10000'],
            ['nama' => 'Paket geprek original', 'tipe' => 'Makanan', 'harga' => '13000'],
            ['nama' => 'Paket geprek bakar', 'tipe' => 'Makanan', 'harga' => '16000'],
            ['nama' => 'Paket geprek keju', 'tipe' => 'Makanan', 'harga' => '16000'],
            ['nama' => 'Paket geprek sambal kacang', 'tipe' => 'Makanan', 'harga' => '14000'],
            ['nama' => 'Paket geprek lada hitam', 'tipe' => 'Makanan', 'harga' => '15000'],
            ['nama' => 'Paket geprek BBQ', 'tipe' => 'Makanan', 'harga' => '15000'],
            ['nama' => 'Paket geprek hot Lava', 'tipe' => 'Makanan', 'harga' => '15000'],
            ['nama' => 'Paket geprek extra hot lava', 'tipe' => 'Makanan', 'harga' => '16000'],
            ['nama' => 'Teh', 'tipe' => 'Minuman', 'harga' => '3000'],
            ['nama' => 'Air putih', 'tipe' => 'Minuman', 'harga' => '2000'],
            ['nama' => 'Susu sachet', 'tipe' => 'Minuman', 'harga' => '4000'],
            ['nama' => 'Nutrisari', 'tipe' => 'Minuman', 'harga' => '4000'],
            ['nama' => 'Kopi gooddays', 'tipe' => 'Minuman', 'harga' => '4000'],
            ['nama' => 'kopi torabika', 'tipe' => 'Minuman', 'harga' => '4000'],
            ['nama' => 'kopi kapal api', 'tipe' => 'Minuman', 'harga' => '3000'],
            ['nama' => 'Popice', 'tipe' => 'Minuman', 'harga' => '4000']
        ]);
    }
}
