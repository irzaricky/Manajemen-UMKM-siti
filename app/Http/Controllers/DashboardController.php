<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use App\Models\BahanBaku;
use Illuminate\Http\Request;
use Inertia\Inertia;
use DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Get total sales today
        $totalPenjualanHariIni = Transaksi::whereDate('tanggal', today())
            ->sum('total_harga');

        // Get total transactions today
        $totalTransaksiHariIni = Transaksi::whereDate('tanggal', today())
            ->count();

        // Get products low in stock
        $productLowStock = Produk::where('stok', '<=', 5)
            ->get();

        // Get bahan baku low in stock
        $bahanBakuLowStock = BahanBaku::where('stok', '<=', DB::raw('minimum_stok'))
            ->get();

        // Get sales data for last 7 days
        $salesData = Transaksi::select(
            DB::raw('DATE(tanggal) as date'),
            DB::raw('SUM(total_harga) as total_sales'),
            DB::raw('COUNT(*) as transaction_count')
        )
            ->whereDate('tanggal', '>=', now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Get best selling products
        $bestSellers = TransaksiDetail::select(
            'produk_id',
            'produks.nama',
            DB::raw('SUM(jumlah) as total_sold'),
            DB::raw('SUM(jumlah * harga_satuan) as total_revenue')
        )
            ->join('produks', 'produk_id', '=', 'produks.id')
            ->groupBy('produk_id', 'produks.nama')
            ->orderByDesc('total_sold')
            ->limit(5)
            ->get();

        // Get sales and purchase data for today
        $todayData = [
            'sales' => Transaksi::select(
                DB::raw('HOUR(tanggal) as hour'),
                DB::raw('SUM(total_harga) as total')
            )
                ->whereDate('tanggal', today())
                ->groupBy(DB::raw('HOUR(tanggal)'))
                ->get(),
            'purchases' => DB::table('pembelian_bahan_baku')
                ->select(
                    DB::raw('HOUR(tanggal_pembelian) as hour'),
                    DB::raw('SUM(total_harga) as total')
                )
                ->whereDate('tanggal_pembelian', today())
                ->groupBy(DB::raw('HOUR(tanggal_pembelian)'))
                ->get()
        ];

        return Inertia::render('Dashboard', [
            'statistics' => [
                'totalPenjualanHariIni' => $totalPenjualanHariIni,
                'totalTransaksiHariIni' => $totalTransaksiHariIni,
                'productLowStock' => $productLowStock,
                'bahanBakuLowStock' => $bahanBakuLowStock,
                'salesData' => $salesData,
                'bestSellers' => $bestSellers,
                'todayData' => $todayData
            ],
            'hero' => 'Dashboard'
        ]);
    }
}
