<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    // Liste des ventes avec produit et vendeur
    public function index(Request $request)
    {
        $query = Sale::with(['produit', 'vendeur']);

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('produit_id')) {
            $query->where('produit_id', $request->produit_id);
        }

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        }

        $ventes = $query->latest()->get();
        return response()->json($ventes);
    }

    public function show($id)
    {
        $vente = Sale::with(['produit', 'vendeur'])->findOrFail($id);
        return response()->json($vente);
    }
}
