<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OrderController extends Controller
{
    // Method untuk menampilkan halaman order
    public function index()
    {
        $products = Produk::where('stok', '>', 0)->get();
        $orderItems = session('order', []);

        return Inertia::render('Order/index', [
            'products' => $products,
            'orderItems' => $orderItems
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
        $request->validate([
            'payment_type' => 'required|in:tunai,transfer'
        ]);

        $order = session()->get('order', []);

        if (empty($order)) {
            return back()->with('error', 'Order kosong');
        }

        try {
            // Begin transaction
            \DB::beginTransaction();

            // Create transaction
            $transaction = Transaksi::create([
                'tanggal' => now(),
                'total_harga' => collect($order)->sum(function ($item) {
                    return $item['price'] * $item['quantity'];
                }),
                'tipe_pembayaran' => $request->payment_type
            ]);

            // Create transaction details and update stock
            foreach ($order as $productId => $item) {
                TransaksiDetail::create([
                    'transaksi_id' => $transaction->id,
                    'produk_id' => $productId,
                    'jumlah' => $item['quantity'],
                    'harga_satuan' => $item['price']
                ]);

                $product = Produk::findOrFail($productId);
                if (!$product->kurangiStok($item['quantity'])) {
                    throw new \Exception("Stok produk {$product->nama} tidak mencukupi");
                }
            }

            // Clear order session
            session()->forget('order');

            // Commit transaction
            \DB::commit();

            return redirect()->route('order.index')
                ->with('success', 'Order berhasil diproses');

        } catch (\Exception $e) {
            // Rollback transaction
            \DB::rollBack();

            return back()->with('error', $e->getMessage());
        }
    }

    // Method untuk mengupdate quantity item dalam order
    public function updateQuantity(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produks,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $order = session()->get('order', []);
        $product = Produk::findOrFail($request->product_id);

        if ($product->stok < $request->quantity) {
            return back()->with('error', 'Stok tidak mencukupi');
        }

        if (isset($order[$request->product_id])) {
            $order[$request->product_id]['quantity'] = $request->quantity;
            session()->put('order', $order);
        }

        return back()->with('success', 'Quantity berhasil diupdate');
    }
}