<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LaporanPenjualanExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return DB::table('detail_transaksi')
            ->join('transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.id')
            ->select(
                DB::raw('DATE(transaksi.tanggal) as tanggal'),
                DB::raw('COUNT(DISTINCT transaksi.id) as total_transaksi'),
                DB::raw('SUM(detail_transaksi.jumlah) as total_item'),
                DB::raw('SUM(detail_transaksi.jumlah * detail_transaksi.harga_satuan) as total_penjualan')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Total Transaksi',
            'Total Item',
            'Total Penjualan'
        ];
    }
}