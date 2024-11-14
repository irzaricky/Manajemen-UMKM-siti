<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Inertia\Inertia;
use DB;

class OrderController extends Controller
{
    // Method untuk menampilkan halaman order
    public function index(Request $request)
    {
        $query = Produk::query()->where('stok', '>', 0);

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('nama', 'LIKE', "%{$searchTerm}%");
        }

        $products = $query->get();
        $selectedItems = session('selected_items', []);

        return Inertia::render('Order/index', [
            'products' => $products,
            'selectedItems' => $selectedItems,
            'filters' => $request->only(['search'])
        ]);
    }

    // Method untuk menambah item ke order
    public function addToOrder(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produks,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $product = Produk::findOrFail($request->product_id);

        if ($product->stok < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        $order = session()->get('order', []);

        if (isset($order[$request->product_id])) {
            $order[$request->product_id]['quantity'] += $request->quantity;
        } else {
            $order[$request->product_id] = [
                'id' => $product->id,
                'name' => $product->nama,
                'price' => $product->harga,
                'quantity' => $request->quantity
            ];
        }

        session()->put('order', $order);

        return back()->with('success', 'Produk berhasil ditambahkan ke order');
    }

    // Method untuk menghapus item dari order
    public function removeFromOrder(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produks,id'
        ]);

        $order = session()->get('order', []);

        if (isset($order[$request->product_id])) {
            unset($order[$request->product_id]);
            session()->put('order', $order);
        }

        return back()->with('success', 'Produk berhasil dihapus dari order');
    }

    // Method untuk memproses order
    public function processOrder(Request $request)
    {
        $items = $request->items;

        if (empty($items)) {
            return back()->with('error', 'Order kosong');
        }

        // Validasi stok
        foreach ($items as $item) {
            $product = Produk::find($item['id']);
            if ($product->stok < $item['quantity']) {
                return back()->with('error', "Stok {$product->nama} tidak mencukupi");
            }
        }

        // Simpan items ke session untuk digunakan kembali
        session()->put('selected_items', $items);

        return Inertia::render('Order/Kasir', [
            'orderItems' => $items,
            'total' => collect($items)->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            })
        ]);
    }

    public function kasir()
    {
        $orderItems = session('order', []);

        // Validate session data
        if (empty($orderItems)) {
            return redirect()->route('order.index')
                ->with('error', 'No items in order');
        }


        $total = collect($orderItems)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        return Inertia::render('Order/Kasir', [
            'orderItems' => $orderItems,
            'total' => $total
        ]);
    }

    public function invoice(Request $request)
    {
        // Validate request data
        if (empty($request->items)) {
            return redirect()->route('order.index')
                ->with('error', 'No items to process');
        }

        try {
            $transaction = $this->createTransaction($request->items);

            // Load required relations
            $transaction->load(['transaksiDetail.produk']);

            // Clear session data after successful transaction
            session()->forget(['order', 'selected_items']);

            return Inertia::render('Order/Invoice', [
                'transaction' => $transaction
            ]);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to process transaction: ' . $e->getMessage());
        }
    }

    private function createTransaction($order)
    {
        try {
            DB::beginTransaction();

            $transaction = Transaksi::create([
                'tanggal' => now(),
                'total_harga' => collect($order)->sum(function ($item) {
                    return $item['price'] * $item['quantity'];
                })
            ]);

            foreach ($order as $item) {
                TransaksiDetail::create([
                    'transaksi_id' => $transaction->id,
                    'produk_id' => $item['id'],
                    'jumlah' => $item['quantity'],
                    'harga_satuan' => $item['price']
                ]);

                $product = Produk::find($item['id']);
                $product->kurangiStok($item['quantity']);
            }

            DB::commit();
            return $transaction;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}