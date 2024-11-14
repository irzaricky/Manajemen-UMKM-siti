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
}
