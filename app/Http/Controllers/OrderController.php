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
        $query = Produk::query();

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('nama', 'LIKE', "%{$searchTerm}%");
        }

        $produks = $query->paginate(9);

        // Get cart data from session
        $cartSession = session('order', []);

        return Inertia::render('Order/index', [
            'produks' => $produks,
            'filters' => $request->only(['search']),
            'hero' => 'Order Menu',
            'cart_session' => $cartSession // Pass session data to view
        ]);
    }

    // Method untuk menambah item ke order
    public function addToOrder(Request $request)
    {
        $items = $request->items;

        if (empty($items)) {
            return back()->with('error', 'No items to add');
        }

        // Simpan ke session
        $order = [];
        foreach ($items as $item) {
            $order[$item['id']] = [
                'id' => $item['id'],
                'name' => $item['nama'],
                'price' => $item['harga'],
                'quantity' => $item['quantity']
            ];
        }

        session()->put('order', $order);

        return back()->with('success', 'Items added to cart');
    }

    // Method untuk menghapus item dari order
    public function removeFromOrder(Request $request)
    {
        // If clear_all flag is set, clear entire order session
        if ($request->has('clear_all')) {
            session()->forget('order');
            return back()->with('success', 'Order cancelled successfully');
        }

        // Existing single item removal logic
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
        $cart = $request->cart;

        if (empty($cart)) {
            return back()->with('error', 'Cart is empty');
        }

        DB::beginTransaction();
        try {
            // Validate stock availability
            foreach ($cart as $item) {
                $product = Produk::find($item['id']);
                if (!$product || $product->stok < $item['quantity']) {
                    throw new \Exception("Insufficient stock for {$product->nama}");
                }
            }

            // Create transaction and reduce stock
            $transaction = Transaksi::create([
                'total_harga' => collect($cart)->sum(fn($item) => $item['harga'] * $item['quantity'])
            ]);

            foreach ($cart as $item) {
                $product = Produk::find($item['id']);
                $product->decrement('stok', $item['quantity']);

                TransaksiDetail::create([
                    'transaksi_id' => $transaction->id,
                    'produk_id' => $item['id'],
                    'jumlah' => $item['quantity'],
                    'harga_satuan' => $item['harga']
                ]);
            }

            DB::commit();
            return redirect()->route('order.invoice', $transaction->id);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
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

    // For POST request (from order)
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
                'transaction' => $transaction,
                'source' => 'order'
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

    // For GET request (from laporan)
    public function showInvoice($id)
    {
        $transaction = Transaksi::with(['transaksiDetail.produk'])->findOrFail($id);

        return Inertia::render('Order/Invoice', [
            'transaction' => $transaction,
            'source' => 'laporan'
        ]);
    }
}
