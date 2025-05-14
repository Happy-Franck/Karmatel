<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Liste avec recherche
    public function index(Request $request)
    {
        $query = Product::query()->with('categorie');

        if ($request->filled('nom')) {
            $query->where('nom', 'like', '%' . $request->nom . '%');
        }

        if ($request->filled('categorie_id')) {
            $query->where('categorie_id', $request->categorie_id);
        }

        $produits = $query->latest()->get();
        return response()->json($produits);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'quantite' => 'required|integer|min:0',
            'marque' => 'nullable|string',
            'prix' => 'required|numeric|min:0',
            'couleur' => 'nullable|string',
            'config' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|string',
            'categorie_id' => 'required|exists:categories,id',
        ]);

        $produit = Product::create($request->all());
        return response()->json($produit, 201);
    }

    public function show($id)
    {
        $produit = Product::with('categorie')->findOrFail($id);
        return response()->json($produit);
    }

    public function update(Request $request, $id)
    {
        $produit = Product::findOrFail($id);
        $produit->update($request->all());
        return response()->json($produit);
    }

    public function destroy($id)
    {
        $produit = Product::findOrFail($id);
        $produit->delete();
        return response()->json(['message' => 'Produit supprimé']);
    }
}
