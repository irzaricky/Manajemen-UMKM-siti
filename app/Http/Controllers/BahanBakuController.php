<?php

namespace App\Http\Controllers;

use App\Models\BahanBaku;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BahanBakuController extends Controller
{
    public function index(Request $request)
    {
        $query = BahanBaku::query();

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('nama', 'LIKE', "%{$searchTerm}%")
                ->orWhere('satuan', 'LIKE', "%{$searchTerm}%");
        }

        $bahanBaku = $query->paginate(10)->withQueryString();

        return Inertia::render('BahanBaku/Index', [
            'bahanBaku' => $bahanBaku,
            'filters' => $request->only(['search'])
        ]);
    }

    public function create()
    {
        return Inertia::render('BahanBaku/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string|max:50',
            'harga_per_unit' => 'required|numeric|min:0',
            'minimum_stok' => 'required|integer|min:0',
            'keterangan' => 'nullable|string'
        ]);

        BahanBaku::create($validated);

        return redirect()->route('bahan-baku.index')
            ->with('success', 'Bahan baku berhasil ditambahkan');
    }

    public function edit($id)
    {
        $bahanBaku = BahanBaku::findOrFail($id);
        
        return Inertia::render('BahanBaku/Edit', [
            'bahanBaku' => $bahanBaku
        ]);
    }

    public function update(Request $request, $id)
    {
        $bahanBaku = BahanBaku::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'satuan' => 'required|string|max:50',
            'harga_per_unit' => 'required|numeric|min:0',
            'minimum_stok' => 'required|integer|min:0',
            'keterangan' => 'nullable|string'
        ]);

        $bahanBaku->update($validated);

        return redirect()->route('bahan-baku.index')
            ->with('success', 'Bahan baku berhasil diperbarui');
    }

    public function destroy($id)
    {
        $bahanBaku = BahanBaku::findOrFail($id);
        $bahanBaku->delete();

        return redirect()->route('bahan-baku.index')
            ->with('success', 'Bahan baku berhasil dihapus');
    }
}
