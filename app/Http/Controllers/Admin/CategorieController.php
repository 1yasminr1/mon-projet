<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\SousCategorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function index()
    {
        $categories = Categorie::withCount('sousCategories')->latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(['nom' => 'required|string|max:255']);
        Categorie::create(['nom' => $request->nom, 'description' => $request->description]);
        return back()->with('success', 'Catégorie créée.');
    }

    public function update(Request $request, Categorie $categorie)
    {
        $request->validate(['nom' => 'required|string|max:255']);
        $categorie->update(['nom' => $request->nom, 'description' => $request->description]);
        return back()->with('success', 'Catégorie modifiée.');
    }

    public function destroy(Categorie $categorie)
    {
        $categorie->delete();
        return back()->with('success', 'Catégorie supprimée.');
    }

    public function storeSousCategorie(Request $request)
    {
        $request->validate([
            'nom'          => 'required|string|max:255',
            'categorie_id' => 'required|exists:categories,id',
        ]);
        SousCategorie::create(['nom' => $request->nom, 'categorie_id' => $request->categorie_id]);
        return back()->with('success', 'Sous-catégorie créée.');
    }

    public function destroySousCategorie(SousCategorie $sousCategorie)
    {
        $sousCategorie->delete();
        return back()->with('success', 'Sous-catégorie supprimée.');
    }
}