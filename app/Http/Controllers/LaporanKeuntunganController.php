<?php

namespace App\Http\Controllers;

use App\Models\LaporanKeuntungan;
use Illuminate\Http\Request;
use Inertia\Inertia;
use DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanKeuntunganExport;

class LaporanKeuntunganController extends Controller
{
    public function index(Request $request)
    {
        try {
            $period = $request->get('period', 'daily');

            // Validate period
            if (!in_array($period, ['daily', 'weekly', 'monthly', 'yearly'])) {
                return Inertia::render('Error', [
                    'message' => 'Invalid period selected'
                ]);
            }

            $salesQuery = DB::table('transaksi')
                ->join('detail_transaksi', 'transaksi.id', '=', 'detail_transaksi.transaksi_id')
                ->join('produks', 'detail_transaksi.produk_id', '=', 'produks.id');

            $results = $this->processReportsByPeriod($salesQuery, $period);

            // Paginate results
            $perPage = 10;
            $page = request()->get('page', 1);
            $paginatedResults = new \Illuminate\Pagination\LengthAwarePaginator(
                $results->forPage($page, $perPage),
                $results->count(),
                $perPage,
                $page,
                ['path' => request()->url()]
            );

            return Inertia::render('Laporan/Keuntungan/Index', [
                'reports' => $paginatedResults,
                'period' => $period
            ]);

        } catch (\Exception $e) {
            return Inertia::render('Error', [
                'message' => 'Failed to generate report: ' . $e->getMessage()
            ]);
        }
    }

    private function processReportsByPeriod($salesQuery, $period)
    {
        switch ($period) {
            case 'daily':
                return $this->processDailyReports($salesQuery);
            case 'weekly':
                return $this->processWeeklyReports($salesQuery);
            case 'monthly':
                return $this->processMonthlyReports($salesQuery);
            case 'yearly':
                return $this->processYearlyReports($salesQuery);
            default:
                throw new \InvalidArgumentException('Invalid period');
        }
    }

    private function processDailyReports($salesQuery)
    {
        $purchaseSubQuery = $this->getDailyPurchaseSubquery();

        $reports = $salesQuery
            ->select([
                DB::raw('DATE(transaksi.tanggal) as tanggal'),
                DB::raw('SUM(detail_transaksi.jumlah * detail_transaksi.harga_satuan) as total_penjualan'),
                DB::raw('SUM(detail_transaksi.jumlah) as total_item'),
                DB::raw('COUNT(DISTINCT produks.id) as total_produk'),
                DB::raw('COUNT(DISTINCT transaksi.id) as total_transaksi')
            ])
            ->groupBy(DB::raw('DATE(transaksi.tanggal)'))
            ->get();

        $purchases = $purchaseSubQuery->get()->keyBy('tanggal');

        return $this->processResults($reports, $purchases, 'daily');
    }

    private function processWeeklyReports($salesQuery)
    {
        $purchaseSubQuery = DB::table('pembelian_bahan_baku')
            ->select(
                DB::raw('YEARWEEK(tanggal_pembelian, 1) as periode'),
                DB::raw('MIN(tanggal_pembelian) as tanggal'),
                DB::raw('SUM(total_harga) as total_pembelian')
            )
            ->groupBy(DB::raw('YEARWEEK(tanggal_pembelian, 1)'));

        $reports = $salesQuery->select([
            DB::raw('YEARWEEK(transaksi.tanggal, 1) as periode'),
            DB::raw('MIN(transaksi.tanggal) as tanggal'),
            DB::raw('SUM(detail_transaksi.jumlah * detail_transaksi.harga_satuan) as total_penjualan'),
            DB::raw('SUM(detail_transaksi.jumlah) as total_item'),
            DB::raw('COUNT(DISTINCT produks.id) as total_produk'),
            DB::raw('COUNT(DISTINCT transaksi.id) as total_transaksi')
        ])
            ->groupBy(DB::raw('YEARWEEK(transaksi.tanggal, 1)'))
            ->get();

        $purchases = $purchaseSubQuery->get()->keyBy('periode');

        return $this->processResults($reports, $purchases, 'weekly');
    }

    private function processMonthlyReports($salesQuery)
    {
        $purchaseSubQuery = DB::table('pembelian_bahan_baku')
            ->select(
                DB::raw('DATE_FORMAT(tanggal_pembelian, "%Y-%m") as periode'),
                DB::raw('MIN(tanggal_pembelian) as tanggal'),
                DB::raw('SUM(total_harga) as total_pembelian')
            )
            ->groupBy(DB::raw('DATE_FORMAT(tanggal_pembelian, "%Y-%m")'));

        $reports = $salesQuery->select([
            DB::raw('DATE_FORMAT(transaksi.tanggal, "%Y-%m") as periode'),
            DB::raw('MIN(transaksi.tanggal) as tanggal'),
            DB::raw('SUM(detail_transaksi.jumlah * detail_transaksi.harga_satuan) as total_penjualan'),
            DB::raw('SUM(detail_transaksi.jumlah) as total_item'),
            DB::raw('COUNT(DISTINCT produks.id) as total_produk'),
            DB::raw('COUNT(DISTINCT transaksi.id) as total_transaksi')
        ])
            ->groupBy(DB::raw('DATE_FORMAT(transaksi.tanggal, "%Y-%m")'))
            ->get();

        $purchases = $purchaseSubQuery->get()->keyBy('periode');

        return $this->processResults($reports, $purchases, 'monthly');
    }

    private function processYearlyReports($salesQuery)
    {
        $purchaseSubQuery = DB::table('pembelian_bahan_baku')
            ->select(
                DB::raw('YEAR(tanggal_pembelian) as periode'),
                DB::raw('MIN(tanggal_pembelian) as tanggal'),
                DB::raw('SUM(total_harga) as total_pembelian')
            )
            ->groupBy(DB::raw('YEAR(tanggal_pembelian)'));

        $reports = $salesQuery->select([
            DB::raw('YEAR(transaksi.tanggal) as periode'),
            DB::raw('MIN(transaksi.tanggal) as tanggal'),
            DB::raw('SUM(detail_transaksi.jumlah * detail_transaksi.harga_satuan) as total_penjualan'),
            DB::raw('SUM(detail_transaksi.jumlah) as total_item'),
            DB::raw('COUNT(DISTINCT produks.id) as total_produk'),
            DB::raw('COUNT(DISTINCT transaksi.id) as total_transaksi')
        ])
            ->groupBy(DB::raw('YEAR(transaksi.tanggal)'))
            ->get();

        $purchases = $purchaseSubQuery->get()->keyBy('periode');

        return $this->processResults($reports, $purchases, 'yearly');
    }

    private function processResults($results, $purchases, $period)
    {
        return $results->map(function ($item) use ($purchases, $period) {
            $modal = $purchases->get($item->tanggal)?->total_pembelian ?? 0;
            $keuntungan = max(0, $item->total_penjualan - $modal);

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
    }

    private function getDailyPurchaseSubquery()
    {
        return DB::table('pembelian_bahan_baku')
            ->select(
                DB::raw('DATE(tanggal_pembelian) as tanggal'),
                DB::raw('SUM(total_harga) as total_pembelian')
            )
            ->groupBy('tanggal');
    }


    public function exportExcel()
    {
        return Excel::download(new LaporanKeuntunganExport, 'laporan-keuntungan.xlsx');
    }
}