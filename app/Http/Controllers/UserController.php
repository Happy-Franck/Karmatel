<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    // Cette méthode est appelée par un Admin
    public function store(Request $request)
    {
        // Vérifie si l'utilisateur connecté est Admin
        if (Auth::user()->role !== 'Admin') {
            abort(403, 'Accès refusé');
        }

        $request->validate([
            'pseudo' => 'required|string|max:255',
            'tel' => 'required|string|max:20',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'image' => 'nullable|string',
        ]);

        $vendeur = User::create([
            'pseudo' => $request->pseudo,
            'tel' => $request->tel,
            'email' => $request->email,
            'image' => $request->image,
            'password' => Hash::make($request->password),
            'role' => 'Vendeur', // Forcé en tant que Vendeur
        ]);

        return response()->json([
            'message' => 'Vendeur créé avec succès',
            'user' => $vendeur
        ], 201);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
