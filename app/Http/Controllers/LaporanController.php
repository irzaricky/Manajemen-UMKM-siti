<?php

namespace App\Http\Controllers;

use App\Models\LaporanPenjualanHarian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class LaporanController extends Controller
{
    public function index()
    {
        $reports = DB::table('detail_transaksi')
            ->join('transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.id')
            ->join('produks', 'detail_transaksi.produk_id', '=', 'produks.id')
            ->select(
                DB::raw('DATE(transaksi.tanggal) as tanggal'),
                DB::raw('SUM(detail_transaksi.jumlah * detail_transaksi.harga_satuan) as total_penjualan'),
                DB::raw('SUM(detail_transaksi.jumlah) as total_item'),
                DB::raw('COUNT(DISTINCT transaksi.id) as total_transaksi')
            )
            ->groupBy('tanggal') // Only group by date
            ->orderBy('tanggal', 'desc')
            ->paginate(10);

        return Inertia::render('Laporan/Index', [
            'reports' => $reports
        ]);
    }

    public function edit($date)
    {
        $report = DB::table('detail_transaksi')
            ->join('transaksi', 'detail_transaksi.transaksi_id', '=', 'transaksi.id')
            ->where(DB::raw('DATE(transaksi.tanggal)'), $date)
            ->select(
                DB::raw('DATE(transaksi.tanggal) as tanggal'),
                DB::raw('SUM(detail_transaksi.jumlah * detail_transaksi.harga_satuan) as total_penjualan'),
                DB::raw('SUM(detail_transaksi.jumlah) as total_item'),
                DB::raw('COUNT(DISTINCT transaksi.id) as total_transaksi')
            )
            ->groupBy('tanggal')
            ->first();

        return Inertia::render('Laporan/Edit', [
            'report' => $report
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'total_penjualan' => 'required|numeric|min:0',
            'total_item' => 'required|integer|min:0',
            'total_transaksi' => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($request, $id) {
            // Update transaksi
            DB::table('transaksi')
                ->where('id', $id)
                ->update([
                    'total_harga' => $request->total_penjualan,
                    'updated_at' => now()
                ]);

            // Update detail_transaksi 
            // Asumsi: mengupdate harga_satuan berdasarkan total dan jumlah
            $harga_satuan = $request->total_penjualan / $request->total_item;
            DB::table('detail_transaksi')
                ->where('transaksi_id', $id)
                ->update([
                    'harga_satuan' => $harga_satuan,
                    'jumlah' => $request->total_item
                ]);
        });

        return redirect()->route('laporan.index')
            ->with('message', 'Laporan berhasil diperbarui');
    }

    public function destroy($date)
    {
        DB::transaction(function () use ($date) {
            // Get all transaction IDs for the given date
            $transactionIds = DB::table('transaksi')
                ->whereDate('tanggal', $date)
                ->pluck('id');

            // Delete related transaction details
            DB::table('detail_transaksi')
                ->whereIn('transaksi_id', $transactionIds)
                ->delete();

            // Delete the transactions
            DB::table('transaksi')
                ->whereDate('tanggal', $date)
                ->delete();
        });

        return redirect()->route('laporan.index')
            ->with('message', 'Laporan berhasil dihapus');
    }

    public function detail($date)
    {
        $transactions = DB::table('transaksi')
            ->join('detail_transaksi', 'transaksi.id', '=', 'detail_transaksi.transaksi_id')
            ->join('produks', 'detail_transaksi.produk_id', '=', 'produks.id')
            ->select(
                'transaksi.id',
                'transaksi.tanggal',
                'transaksi.total_harga',
                'detail_transaksi.id as detail_id',
                'detail_transaksi.jumlah',
                'detail_transaksi.harga_satuan',
                'produks.nama as nama_produk'
            )
            ->whereDate('transaksi.tanggal', $date)
            ->get()
            ->groupBy('id');

        return Inertia::render('Laporan/Detail', [
            'transactions' => $transactions,
            'date' => $date
        ]);
    }

    public function destroyTransaction($id)
    {
        try {
            DB::beginTransaction();

            // Get transaction date first for redirect
            $transaction = DB::table('transaksi')
                ->where('id', $id)
                ->first();

            if (!$transaction) {
                return back()->with('error', 'Transaksi tidak ditemukan');
            }

            $date = date('Y-m-d', strtotime($transaction->tanggal));

            // Delete detail_transaksi first due to foreign key constraint
            DB::table('detail_transaksi')
                ->where('transaksi_id', $id)
                ->delete();

            // Delete the transaction
            DB::table('transaksi')
                ->where('id', $id)
                ->delete();

            DB::commit();

            return redirect()->route('laporan.detail', [
                'date' => $date
            ])->with('message', 'Transaksi berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }
}
