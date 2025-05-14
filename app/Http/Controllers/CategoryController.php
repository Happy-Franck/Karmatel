<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $exist = Category::where('nom', $request->nom)->first();
        if ($exist) {
            return redirect()->route('categories.index')->with('success', 'Catégorie existe déjà.');
        }

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        Category::create([
            'nom' => $request->nom,
            'image' => $imagePath,
            'user_id' => Auth::id(),
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
        $request->validate([
            'nom' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $categorie = Category::findOrFail($id);

        $data = [
            'nom' => $request->nom,
        ];

        if ($request->hasFile('image')) {
            // Optionnel : supprimer l'ancienne image
            if ($categorie->image && Storage::disk('public')->exists($categorie->image)) {
                Storage::disk('public')->delete($categorie->image);
            }

            $imagePath = $request->file('image')->store('categories', 'public');
            $data['image'] = $imagePath;
        }

        $categorie->update($data);

        return redirect()->route('categories.index')->with('success', 'Catégorie modifiée avec succès.');
    }


    public function destroy($id)
    {
        $categorie = Category::findOrFail($id);
        $categorie->delete();
        return redirect()->route('categories.index')->with('success', 'Catégorie supprimée.');
    }
}
