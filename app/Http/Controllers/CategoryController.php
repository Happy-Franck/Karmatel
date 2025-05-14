<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query()->with('user');
        if ($request->filled('nom')) {
            $query->where('nom', 'like', '%' . $request->nom . '%');
        }
        $categories = $query->latest()->get();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'image' => 'nullable|string',
        ]);

        $exist = Category::where('nom', $request->nom)->first();
        if ($exist) {
            return redirect()->route('categories.index')->with('success', 'Catégorie existe déjà.');
        }

        Category::create([
            'nom' => $request->nom,
            'image' => $request->image,
            'user_id' => Auth::id(), // 👈 automatiquement l'utilisateur connecté
        ]);

        return redirect()->route('categories.index')->with('success', 'Catégorie créée avec succès.');
    }



    public function show($id)
    {
        $categorie = Category::with('produits')->findOrFail($id);
        return response()->json($categorie);
    }

    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $categorie = Category::findOrFail($id);
        $categorie->update($request->all());
        return redirect()->route('categories.index')->with('success', 'Catégorie modifié avec succes.');
    }

    public function destroy($id)
    {
        $categorie = Category::findOrFail($id);
        $categorie->delete();
        return redirect()->route('categories.index')->with('success', 'Catégorie supprimée.');
    }
}
