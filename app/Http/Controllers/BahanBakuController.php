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
}
