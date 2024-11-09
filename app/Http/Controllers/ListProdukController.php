<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Produk;
use Illuminate\Http\Request;

class ListProdukController extends Controller
{
    // Menampilkan daftar produk
    public function index()
    {
        $produks = Produk::paginate(10);
        return inertia('Produk/index', [
            'produks' => $produks
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
        $request->validate([
            'tipe' => 'required|string',
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0|max:100000',
            'stok' => 'required|integer|min:0',
        ]);

        Produk::create($request->all());

        return redirect()->route('dashboard.produk.index')->with('success', 'Produk berhasil ditambahkan.');
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
        $request->validate([
            'tipe' => 'required|string',
            'nama' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0|max:100000',
            'stok' => 'required|integer|min:0',
        ]);

        $produk = Produk::findOrFail($id);
        $produk->update($request->all());

        return redirect()->route('dashboard.produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    // Menghapus produk
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();

        return redirect()->route('dashboard.produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
