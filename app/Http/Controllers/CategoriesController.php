<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function __construct()
    {
        // examples:
        $this->middleware(['permission:category-list'],["only" =>["index","show"]]);
        $this->middleware(['permission:category-create'],["only" =>["create","store"]]);
        $this->middleware(['permission:category-edit'],["only" =>["edit","update"]]);
        $this->middleware(['permission:category-delete'],["only" =>["destroy"]]);

    }
    // Afficher toutes les catégories
    public function index()
    {
        $categories = Categories::all();
        return view('categories.index', compact('categories'));
    }

    // Afficher le formulaire pour créer une nouvelle catégorie
    public function create()
    {
        return view('categories.create');
    }

    // Sauvegarder une nouvelle catégorie
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Categories::create([
            'name' => $request->name,
        ]);

        return redirect()->route('categories.index')->with('success', 'Catégorie ajoutée avec succès!');
    }

    // Afficher le formulaire pour éditer une catégorie existante
    public function edit($id)
    {
        $category = Categories::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    // Mettre à jour une catégorie existante
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Categories::findOrFail($id);
        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('categories.index')->with('success', 'Catégorie mise à jour avec succès!');
    }

    // Supprimer une catégorie
    public function destroy($id)
    {
        $category = Categories::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Catégorie supprimée avec succès!');
    }
}
