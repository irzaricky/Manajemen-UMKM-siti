<?php

namespace App\Http\Controllers;

use App\Models\ResepProduk;
use App\Models\Produk;
use App\Models\BahanBaku;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ResepController extends Controller
{
    public function index(Request $request)
    {
        $query = ResepProduk::with(['produk', 'bahanBaku']);

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->whereHas('produk', function ($q) use ($searchTerm) {
                $q->where('nama', 'LIKE', "%{$searchTerm}%");
            });
        }

        $resep = $query->paginate(10)->withQueryString();

        return Inertia::render('Resep/Index', [
            'resep' => $resep,
            'filters' => $request->only(['search'])
        ]);
    }

    public function create()
    {
        $produk = Produk::all();
        $bahanBaku = BahanBaku::all();
        
        return Inertia::render('Resep/Create', [
            'produk' => $produk,
            'bahanBaku' => $bahanBaku
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'bahan_baku_id' => 'required|exists:bahan_baku,id',
            'jumlah_bahan' => 'required|numeric|min:0',
        ]);

        ResepProduk::create($request->all());

        return redirect()->route('resep.index')
            ->with('message', 'Resep berhasil ditambahkan');
    }

    public function edit($id)
    {
        $resep = ResepProduk::with(['produk', 'bahanBaku'])->findOrFail($id);
        $produk = Produk::all();
        $bahanBaku = BahanBaku::all();

        return Inertia::render('Resep/Edit', [
            'resep' => $resep,
            'produk' => $produk,
            'bahanBaku' => $bahanBaku
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'produk_id' => 'required|exists:produk,id',
            'bahan_baku_id' => 'required|exists:bahan_baku,id',
            'jumlah_bahan' => 'required|numeric|min:0',
        ]);

        $resep = ResepProduk::findOrFail($id);
        $resep->update($request->all());

        return redirect()->route('resep.index')
            ->with('message', 'Resep berhasil diupdate');
    }

    public function destroy($id)
    {
        $resep = ResepProduk::findOrFail($id);
        $resep->delete();

        return redirect()->route('resep.index')
            ->with('message', 'Resep berhasil dihapus');
    }
}
