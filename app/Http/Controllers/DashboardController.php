<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Models\Produk;
use App\Models\BahanBaku;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $startDate = $request->startDate ?? Carbon::now()->subDays(30)->format('Y-m-d');
        $endDate = $request->endDate ?? Carbon::now()->format('Y-m-d');

        // Base query for transactions
        $query = DB::table('transaksi')
            ->join('detail_transaksi', 'transaksi.id', '=', 'detail_transaksi.transaksi_id')
            ->join('produks', 'detail_transaksi.produk_id', '=', 'produks.id')
            ->whereBetween('transaksi.tanggal', [$startDate, $endDate]);

        // Get chart data
        $chartData = (clone $query)
            ->select([
                'transaksi.tanggal',
                DB::raw('SUM(detail_transaksi.jumlah * detail_transaksi.harga_satuan) as revenue'),
                DB::raw('COUNT(DISTINCT transaksi.id) as transactions')
            ])
            ->groupBy('transaksi.tanggal')
            ->orderBy('transaksi.tanggal')
            ->get();

        // Update the peak hours query to get all hours
        $hourlyData = (clone $query)
            ->select([
                DB::raw('HOUR(transaksi.created_at) as hour'),
                DB::raw('COUNT(*) as transaction_count')
            ])
            ->groupBy(DB::raw('HOUR(transaksi.created_at)'))
            ->orderBy('hour')
            ->get();

        $statistics = [
            'dates' => $chartData->pluck('tanggal')->map(fn($date) => Carbon::parse($date)->format('Y-m-d')),
            'daily_revenue' => $chartData->pluck('revenue'),
            'daily_transactions' => $chartData->pluck('transactions'),
            'total_pendapatan' => $chartData->sum('revenue'),
            'total_transaksi' => $chartData->sum('transactions'),
            'hourly_transactions' => $hourlyData->pluck('transaction_count'),
            'hours' => $hourlyData->pluck('hour')->map(fn($hour) => sprintf('%02d:00', $hour))
        ];

        // Get best selling products
        $bestSellers = (clone $query)
            ->select([
                'produks.id',
                'produks.nama',
                'produks.tipe',
                DB::raw('SUM(detail_transaksi.jumlah) as total_terjual'),
                DB::raw('SUM(detail_transaksi.jumlah * detail_transaksi.harga_satuan) as total_pendapatan')
            ])
            ->groupBy('produks.id', 'produks.nama', 'produks.tipe')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();

        // Get low stock products (independent of time filter)
        $lowStockProducts = Produk::select(['id', 'nama', 'stok', 'tipe'])
            ->whereRaw('stok <= COALESCE(minimum_stok, 5)')
            ->orderBy('stok')
            ->limit(5)
            ->get();

        // Get low stock raw materials (independent of time filter)
        $lowStockMaterials = BahanBaku::select(['id', 'nama', 'stok', 'satuan', 'minimum_stok'])
            ->whereColumn('stok', '<=', 'minimum_stok')
            ->orderBy('stok')
            ->get();

        return Inertia::render('Dashboard', [
            'hero' => 'Dashboard',
            'statistics' => $statistics,
            'filters' => [
                'startDate' => $startDate,
                'endDate' => $endDate
            ],
            'bestSellers' => $bestSellers,
            'lowStockProducts' => $lowStockProducts,
            'lowStockMaterials' => $lowStockMaterials
        ]);
    }
}
