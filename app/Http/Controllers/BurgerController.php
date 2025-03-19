<?php

namespace App\Http\Controllers;

use App\Models\Burger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BurgerController extends Controller
{
    /**
     * Affiche la liste des burgers.
     */
    public function index()
    {
        if (Auth::user()->role === 'gestionnaire') {
            $burgers = Burger::all(); // Tous les burgers pour le gestionnaire
        } else {
            $burgers = Burger::where('is_published', true)->get(); // Seuls les burgers publiés pour les clients
        }

        return view('burgers.index', compact('burgers'));
    }

    /**
     * Affiche le formulaire de création d'un burger.
     */
    public function create()
    {
        // Vérifie que l'utilisateur est un gestionnaire
        if (Auth::user()->role !== 'gestionnaire') {
            abort(403, 'Accès non autorisé.');
        }

        return view('burgers.create');
    }

    /**
     * Enregistre un nouveau burger dans la base de données.
     */
    public function store(Request $request)
    {
        // Vérifie que l'utilisateur est un gestionnaire
        if (Auth::user()->role !== 'gestionnaire') {
            abort(403, 'Accès non autorisé.');
        }

        // Validation des données
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Gestion de l'image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('burgers', 'public');
        }

        // Création du burger
        Burger::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imagePath,
            'is_published' => false, // Par défaut, le burger n'est pas publié
        ]);

        return redirect()->route('gestionnaire.home')->with('success', 'Burger créé avec succès !');
    }

    /**
     * Affiche les détails d'un burger.
     */
    public function show(Burger $burger)
    {
        return view('burgers.show', compact('burger'));
    }

    /**
     * Affiche le formulaire de modification d'un burger.
     */
    public function edit(Burger $burger)
    {
        // Vérifie que l'utilisateur est un gestionnaire
        if (Auth::user()->role !== 'gestionnaire') {
            abort(403, 'Accès non autorisé.');
        }

        return view('burgers.edit', compact('burger'));
    }

    /**
     * Met à jour un burger dans la base de données.
     */
    public function update(Request $request, Burger $burger)
    {
        // Vérifie que l'utilisateur est un gestionnaire
        if (Auth::user()->role !== 'gestionnaire') {
            abort(403, 'Accès non autorisé.');
        }

        // Validation des données
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Gestion de l'image
        $imagePath = $burger->image; // Conserve l'ancienne image par défaut
        if ($request->hasFile('image')) {
            // Supprime l'ancienne image si elle existe
            if ($burger->image) {
                Storage::disk('public')->delete($burger->image);
            }
            $imagePath = $request->file('image')->store('burgers', 'public');
        }

        // Mise à jour du burger
        $burger->update([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('gestionnaire.home')->with('success', 'Burger mis à jour avec succès !');
    }

    /**
     * Supprime un burger de la base de données.
     */
    public function destroy(Burger $burger)
    {
        // Vérifie que l'utilisateur est un gestionnaire
        if (Auth::user()->role !== 'gestionnaire') {
            abort(403, 'Accès non autorisé.');
        }

        // Supprime l'image associée si elle existe
        if ($burger->image) {
            Storage::disk('public')->delete($burger->image);
        }

        $burger->delete(); // Supprime le burger
        return redirect()->route('gestionnaire.home')->with('success', 'Burger supprimé avec succès !');
    }

    /**
     * Publie ou dépublie un burger.
     */
    public function togglePublish(Burger $burger)
    {
        // Vérifie que l'utilisateur est un gestionnaire
        if (Auth::user()->role !== 'gestionnaire') {
            abort(403, 'Accès non autorisé.');
        }

        $burger->update(['is_published' => !$burger->is_published]);
        return redirect()->route('gestionnaire.home')->with('success', 'Statut de publication mis à jour.');
    }
}
