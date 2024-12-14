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
        $period = $request->get('period', 'daily');
        $startDate = $request->get('startDate');
        $endDate = $request->get('endDate');

        // Base query for transactions
        $query = DB::table('transaksi')
            ->join('detail_transaksi', 'transaksi.id', '=', 'detail_transaksi.transaksi_id')
            ->join('produks', 'detail_transaksi.produk_id', '=', 'produks.id');

        // Apply date filters if provided
        if ($startDate && $endDate) {
            $query->whereBetween('transaksi.tanggal', [$startDate, $endDate]);
        } else {
            switch ($period) {
                case 'weekly':
                    $query->whereBetween('transaksi.tanggal', [
                        Carbon::now()->startOfWeek(),
                        Carbon::now()->endOfWeek()
                    ]);
                    break;
                case 'monthly':
                    $query->whereBetween('transaksi.tanggal', [
                        Carbon::now()->startOfMonth(),
                        Carbon::now()->endOfMonth()
                    ]);
                    break;
                default: // daily
                    $query->whereDate('transaksi.tanggal', Carbon::today());
                    break;
            }
        }

        // Get sales statistics
        $statistics = $query->select([
            DB::raw('SUM(detail_transaksi.jumlah * detail_transaksi.harga_satuan) as total_pendapatan'),
            DB::raw('COUNT(DISTINCT transaksi.id) as total_transaksi')
        ])->first();

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
            'currentPeriod' => $period,
            'filters' => $request->only(['startDate', 'endDate']),
            'bestSellers' => $bestSellers,
            'lowStockProducts' => $lowStockProducts,
            'lowStockMaterials' => $lowStockMaterials
        ]);
    }
}
