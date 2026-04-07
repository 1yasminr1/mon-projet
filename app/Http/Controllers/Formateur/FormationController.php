<?php

namespace App\Http\Controllers\Formateur;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\SousCategorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class FormationController extends Controller
{
    public function index()
    {
        $formations = Formation::where('user_id', Auth::id())
                               ->with(['sousCategorie', 'inscriptions'])
                               ->latest()
                               ->paginate(10);
        return view('formateur.formations.index', compact('formations'));
    }

    public function create()
    {
        $sousCategories = SousCategorie::with('categorie')->get();
        return view('formateur.formations.create', compact('sousCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre'             => 'required|string|max:255',
            'description'       => 'required|string',
            'prix'              => 'required|numeric|min:0',
            'duree'             => 'nullable|integer|min:1',
            'sous_categorie_id' => 'required|exists:sous_categories,id',
            'image' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data                  = $request->all();
        $data['user_id']       = Auth::id();
        $data['statut']        = 'en_attente';

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('formations', 'public');
        }

        Formation::creerFormation($data);

        return redirect()->route('formateur.formations.index')
                         ->with('success', 'Formation créée — en attente de validation.');
    }

    public function edit(Formation $formation)
    {
        abort_if($formation->user_id !== Auth::id(), 403);
        $sousCategories = SousCategorie::with('categorie')->get();
        return view('formateur.formations.edit', compact('formation', 'sousCategories'));
    }

    public function update(Request $request, Formation $formation)
    {
        abort_if($formation->user_id !== Auth::id(), 403);

        $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'required|string',
            'prix'        => 'required|numeric|min:0',
            'duree'       => 'nullable|integer|min:1',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            if ($formation->image) {
                Storage::disk('public')->delete($formation->image);
            }
            $data['image'] = $request->file('image')->store('formations', 'public');
        }

        $formation->gererFormation($data);

        return redirect()->route('formateur.formations.index')
                         ->with('success', 'Formation modifiée avec succès.');
    }

    public function destroy(Formation $formation)
    {
        abort_if($formation->user_id !== Auth::id(), 403);

        if ($formation->image) {
            Storage::disk('public')->delete($formation->image);
        }

        $formation->delete();
        return back()->with('success', 'Formation supprimée.');
    }
}