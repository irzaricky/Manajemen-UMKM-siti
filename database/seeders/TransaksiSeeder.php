<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transactions = collect([
            ['tanggal' => '2024-11-12', 'total_harga' => 54000, 'created_at' => '2024-11-12 12:00:00', 'updated_at' => '2024-11-12 12:00:00'],
            ['tanggal' => '2024-11-12', 'total_harga' => 54000, 'created_at' => '2024-11-12 15:00:00', 'updated_at' => '2024-11-12 15:00:00'],
            ['tanggal' => '2024-11-13', 'total_harga' => 72000, 'created_at' => '2024-11-13 12:00:00', 'updated_at' => '2024-11-13 12:00:00'],
            ['tanggal' => '2024-11-13', 'total_harga' => 81000, 'created_at' => '2024-11-13 15:00:00', 'updated_at' => '2024-11-13 15:00:00'],
            ['tanggal' => '2024-11-14', 'total_harga' => 75000, 'created_at' => '2024-11-14 12:00:00', 'updated_at' => '2024-11-14 12:00:00'],
            ['tanggal' => '2024-11-14', 'total_harga' => 99000, 'created_at' => '2024-11-14 15:00:00', 'updated_at' => '2024-11-14 15:00:00'],
            ['tanggal' => '2024-11-15', 'total_harga' => 69000, 'created_at' => '2024-11-15 12:00:00', 'updated_at' => '2024-11-15 12:00:00'],
            ['tanggal' => '2024-11-15', 'total_harga' => 114000, 'created_at' => '2024-11-15 15:00:00', 'updated_at' => '2024-11-15 15:00:00'],
            ['tanggal' => '2024-11-15', 'total_harga' => 81000, 'created_at' => '2024-11-15 18:00:00', 'updated_at' => '2024-11-15 18:00:00'],
            ['tanggal' => '2024-11-16', 'total_harga' => 90000, 'created_at' => '2024-11-16 12:00:00', 'updated_at' => '2024-11-16 12:00:00'],
            ['tanggal' => '2024-11-16', 'total_harga' => 114000, 'created_at' => '2024-11-16 15:00:00', 'updated_at' => '2024-11-16 15:00:00'],
            ['tanggal' => '2024-11-17', 'total_harga' => 120000, 'created_at' => '2024-11-17 12:00:00', 'updated_at' => '2024-11-17 12:00:00'],
            ['tanggal' => '2024-11-17', 'total_harga' => 123000, 'created_at' => '2024-11-17 15:00:00', 'updated_at' => '2024-11-17 15:00:00'],
            ['tanggal' => '2024-11-18', 'total_harga' => 99000, 'created_at' => '2024-11-18 12:00:00', 'updated_at' => '2024-11-18 12:00:00'],
            ['tanggal' => '2024-11-18', 'total_harga' => 126000, 'created_at' => '2024-11-18 12:00:00', 'updated_at' => '2024-11-18 12:00:00'],
        ]);

        // Insert transactions in chunks for better performance
        $transactions->chunk(100)->each(function ($chunk) {
            DB::table('transaksi')->insert($chunk->toArray());
        });
    }
}
