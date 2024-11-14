<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Produk;
use Illuminate\Http\Request;

class ListProdukController extends Controller
{
    // Menampilkan daftar produk
    public function index(Request $request)
    {
        $query = Produk::query();

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nama', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('tipe', 'LIKE', "%{$searchTerm}%");
            });
        }

        $produks = $query->paginate(10)->withQueryString();

        return inertia('Produk/index', [
            'produks' => $produks,
            'filters' => $request->only(['search'])
        ]);
    }

    // Menampilkan form untuk menambah produk baru
    public function create()
    {
        return Inertia::render('Produk/create');
    }

    // Menyimpan produk baru
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'tipe' => 'required|string',
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0|max:100000',
            'stok' => 'required|integer|min:0',
        ]);

        // Create product with only validated fields
        Produk::create([
            'tipe' => $validated['tipe'],
            'nama' => $validated['nama'],
            'harga' => $validated['harga'],
            'stok' => $validated['stok']
        ]);

        return redirect()->route('dashboard.produk.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit produk
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return inertia('Produk/edit', [
            'produk' => $produk
        ]);
    }

    // Memperbarui data produk
    public function update(Request $request, $id)
    {
        // Validate input
        $validated = $request->validate([
            'tipe' => 'required|string',
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0|max:100000',
            'stok' => 'required|integer|min:0',
        ]);

        // Find product and update with only validated fields
        $produk = Produk::findOrFail($id);
        $produk->update([
            'tipe' => $validated['tipe'],
            'nama' => $validated['nama'],
            'harga' => $validated['harga'],
            'stok' => $validated['stok']
        ]);

        return redirect()->route('dashboard.produk.index')
            ->with('success', 'Produk berhasil diperbarui.');
    }

    // Menghapus produk
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('dashboard.produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
