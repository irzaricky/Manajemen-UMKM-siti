<?php

namespace App\Http\Controllers;

use App\Models\LaporanKeuntungan;
use Illuminate\Http\Request;
use Inertia\Inertia;
use DB;

class LaporanKeuntunganController extends Controller
{
    public function index(Request $request)
    {
        $period = $request->get('period', 'daily');

        $salesQuery = DB::table('transaksi')
            ->join('detail_transaksi', 'transaksi.id', '=', 'detail_transaksi.transaksi_id')
            ->join('produks', 'detail_transaksi.produk_id', '=', 'produks.id');

        switch ($period) {
            case 'daily':
                // Subquery untuk pembelian
                $purchaseSubQuery = DB::table('pembelian_bahan_baku')
                    ->select(
                        DB::raw('DATE(tanggal_pembelian) as tanggal'),
                        DB::raw('SUM(total_harga) as total_pembelian')
                    )
                    ->groupBy('tanggal');

                // Query utama
                $reports = $salesQuery
                    ->select([
                        DB::raw('DATE(transaksi.tanggal) as tanggal'),
                        DB::raw('SUM(detail_transaksi.jumlah * detail_transaksi.harga_satuan) as total_penjualan'),
                        DB::raw('SUM(detail_transaksi.jumlah) as total_item'),
                        DB::raw('COUNT(DISTINCT produks.id) as total_produk'),
                        DB::raw('COUNT(DISTINCT transaksi.id) as total_transaksi')
                    ])
                    ->groupBy(DB::raw('DATE(transaksi.tanggal)'));

                // Get results
                $results = $reports->get();

                // Get purchases data
                $purchases = $purchaseSubQuery->get()->keyBy('tanggal');

                // Combine and save data
                $results = $results->map(function ($item) use ($purchases, $period) {
                    $modal = $purchases->get($item->tanggal)?->total_pembelian ?? 0;
                    $keuntungan = $item->total_penjualan - $modal;

                    // Save to database
                    LaporanKeuntungan::updateOrCreate(
                        [
                            'tanggal' => $item->tanggal,
                            'periode_laporan' => $period
                        ],
                        [
                            'total_penjualan' => $item->total_penjualan,
                            'total_modal' => $modal,
                            'total_keuntungan' => $keuntungan,
                            'total_item' => $item->total_item,
                            'total_produk' => $item->total_produk,
                            'total_transaksi' => $item->total_transaksi
                        ]
                    );

                    $item->total_modal = $modal;
                    return $item;
                });

                // Convert to paginator
                $perPage = 10;
                $page = request()->get('page', 1);
                $results = new \Illuminate\Pagination\LengthAwarePaginator(
                    $results->forPage($page, $perPage),
                    $results->count(),
                    $perPage,
                    $page,
                    ['path' => request()->url()]
                );
                break;

            case 'weekly':
                // Purchase subquery for weekly
                $purchaseSubQuery = DB::table('pembelian_bahan_baku')
                    ->select(
                        DB::raw('YEARWEEK(tanggal_pembelian) as periode'),
                        DB::raw('MIN(tanggal_pembelian) as tanggal'),
                        DB::raw('SUM(total_harga) as total_pembelian')
                    )
                    ->groupBy(DB::raw('YEARWEEK(tanggal_pembelian)'));

                // Sales query
                $reports = $salesQuery->select([
                    DB::raw('YEARWEEK(transaksi.tanggal) as periode'),
                    DB::raw('MIN(transaksi.tanggal) as tanggal'),
                    DB::raw('SUM(detail_transaksi.jumlah * detail_transaksi.harga_satuan) as total_penjualan'),
                    DB::raw('SUM(detail_transaksi.jumlah) as total_item'),
                    DB::raw('COUNT(DISTINCT produks.id) as total_produk'),
                    DB::raw('COUNT(DISTINCT transaksi.id) as total_transaksi')
                ])
                ->groupBy(DB::raw('YEARWEEK(transaksi.tanggal)'));

                // Get results and combine
                $results = $reports->get();
                $purchases = $purchaseSubQuery->get()->keyBy('periode');

                // Process and save
                $results = $results->map(function ($item) use ($purchases, $period) {
                    $modal = $purchases->get($item->periode)?->total_pembelian ?? 0;
                    $keuntungan = $item->total_penjualan - $modal;

                    LaporanKeuntungan::updateOrCreate(
                        [
                            'tanggal' => $item->tanggal,
                            'periode_laporan' => $period
                        ],
                        [
                            'total_penjualan' => $item->total_penjualan,
                            'total_modal' => $modal,
                            'total_keuntungan' => $keuntungan,
                            'total_item' => $item->total_item,
                            'total_produk' => $item->total_produk,
                            'total_transaksi' => $item->total_transaksi
                        ]
                    );

                    $item->total_modal = $modal;
                    return $item;
                });

                // Paginate
                $perPage = 10;
                $page = request()->get('page', 1);
                $results = new \Illuminate\Pagination\LengthAwarePaginator(
                    $results->forPage($page, $perPage),
                    $results->count(),
                    $perPage,
                    $page,
                    ['path' => request()->url()]
                );
                break;

            case 'monthly':
                // Purchase subquery for monthly
                $purchaseSubQuery = DB::table('pembelian_bahan_baku')
                    ->select(
                        DB::raw('DATE_FORMAT(tanggal_pembelian, "%Y-%m") as periode'),
                        DB::raw('MIN(tanggal_pembelian) as tanggal'),
                        DB::raw('SUM(total_harga) as total_pembelian')
                    )
                    ->groupBy(DB::raw('DATE_FORMAT(tanggal_pembelian, "%Y-%m")'));

                // Sales query
                $reports = $salesQuery->select([
                    DB::raw('DATE_FORMAT(transaksi.tanggal, "%Y-%m") as periode'),
                    DB::raw('MIN(transaksi.tanggal) as tanggal'),
                    DB::raw('SUM(detail_transaksi.jumlah * detail_transaksi.harga_satuan) as total_penjualan'),
                    DB::raw('SUM(detail_transaksi.jumlah) as total_item'),
                    DB::raw('COUNT(DISTINCT produks.id) as total_produk'),
                    DB::raw('COUNT(DISTINCT transaksi.id) as total_transaksi')
                ])
                ->groupBy(DB::raw('DATE_FORMAT(transaksi.tanggal, "%Y-%m")'));

                // Get results and combine
                $results = $reports->get();
                $purchases = $purchaseSubQuery->get()->keyBy('periode');

                // Process and save
                $results = $results->map(function ($item) use ($purchases, $period) {
                    $modal = $purchases->get($item->periode)?->total_pembelian ?? 0;
                    $keuntungan = $item->total_penjualan - $modal;

                    LaporanKeuntungan::updateOrCreate(
                        [
                            'tanggal' => $item->tanggal,
                            'periode_laporan' => $period
                        ],
                        [
                            'total_penjualan' => $item->total_penjualan,
                            'total_modal' => $modal,
                            'total_keuntungan' => $keuntungan,
                            'total_item' => $item->total_item,
                            'total_produk' => $item->total_produk,
                            'total_transaksi' => $item->total_transaksi
                        ]
                    );

                    $item->total_modal = $modal;
                    return $item;
                });

                // Paginate
                $perPage = 10;
                $page = request()->get('page', 1);
                $results = new \Illuminate\Pagination\LengthAwarePaginator(
                    $results->forPage($page, $perPage),
                    $results->count(),
                    $perPage,
                    $page,
                    ['path' => request()->url()]
                );
                break;
        }

        return Inertia::render('Laporan/Keuntungan/Index', [
            'reports' => $results,
            'period' => $period
        ]);
    }
}