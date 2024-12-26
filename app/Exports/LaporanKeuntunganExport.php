<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanKeuntunganExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return DB::table('laporan_keuntungan')
            ->select(
                'tanggal',
                'total_penjualan',
                'total_modal',
                'total_keuntungan',
                'total_item',
                'total_produk',
                'total_transaksi'
            )
            ->orderBy('tanggal', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Total Penjualan',
            'Total Modal',
            'Total Keuntungan',
            'Total Item',
            'Total Produk',
            'Total Transaksi'
        ];
    }
}