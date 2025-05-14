<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query()->with('user');

        if ($request->filled('nom')) {
            $query->where('nom', 'like', '%' . $request->nom . '%');
        }

        $categories = $query->latest()->get();
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'image' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
        ]);

        $categorie = Category::create($request->all());
        return response()->json($categorie, 201);
    }

    public function show($id)
    {
        $categorie = Category::with('produits')->findOrFail($id);
        return response()->json($categorie);
    }

    public function update(Request $request, $id)
    {
        $categorie = Category::findOrFail($id);
        $categorie->update($request->all());
        return response()->json($categorie);
    }

    public function destroy($id)
    {
        $categorie = Category::findOrFail($id);
        $categorie->delete();
        return response()->json(['message' => 'Catégorie supprimée']);
    }
}
