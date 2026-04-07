<?php

namespace App\Http\Controllers\Apprenant;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\Inscription;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InscriptionController extends Controller
{
    public function index()
    {
        $inscriptions = Inscription::where('user_id', Auth::id())
                                   ->with('formation')
                                   ->latest()
                                   ->paginate(10);
        return view('apprenant.inscriptions.index', compact('inscriptions'));
    }

    public function formations(Request $request)
    {
        $query = Formation::where('statut', 'validee')
                          ->with(['sousCategorie.categorie', 'formateur', 'inscriptions']);

        // Recherche par mot clé
        if ($request->filled('search')) {
            $query->where('titre', 'like', '%'.$request->search.'%')
                  ->orWhere('description', 'like', '%'.$request->search.'%');
        }

        // Filtre par catégorie
        if ($request->filled('categorie')) {
            $query->whereHas('sousCategorie', function($q) use ($request) {
                $q->where('categorie_id', $request->categorie);
            });
        }

        // Filtre par prix
        if ($request->filled('prix')) {
            if ($request->prix === 'gratuit') {
                $query->where('prix', 0);
            } elseif ($request->prix === 'payant') {
                $query->where('prix', '>', 0);
            }
        }

        $formations  = $query->latest()->paginate(12);
        $categories  = \App\Models\Categorie::all();

        return view('apprenant.formations.index', compact('formations', 'categories'));
    }

    public function detail(Formation $formation)
    {
        $formation->load(['modules.contenus', 'formateur', 'sousCategorie.categorie', 'evaluations']);

        $inscription = Inscription::where('user_id', Auth::id())
                                  ->where('formation_id', $formation->id)
                                  ->first();

        return view('apprenant.formations.detail', compact('formation', 'inscription'));
    }

    public function inscrire(Formation $formation)
    {
        $existant = Inscription::where('user_id', Auth::id())
                               ->where('formation_id', $formation->id)
                               ->first();

        if ($existant) {
            return back()->with('error', 'Vous êtes déjà inscrit à cette formation.');
        }

        Inscription::create([
            'user_id'      => Auth::id(),
            'formation_id' => $formation->id,
            'statut'       => 'en_attente',
            'progression'  => 0,
        ]);

        // Notifier le formateur
        Notification::envoyer(
            $formation->user_id,
            'Nouvelle inscription',
            "Un apprenant s'est inscrit à votre formation \"{$formation->titre}\"."
        );

        return back()->with('success', 'Inscription envoyée — en attente de validation.');
    }

    public function annuler(Inscription $inscription)
    {
        abort_if($inscription->user_id !== Auth::id(), 403);
        $inscription->annuler();
        return back()->with('success', 'Inscription annulée.');
    }

    public function consulterContenu(Formation $formation)
    {
        $inscription = Inscription::where('user_id', Auth::id())
                                  ->where('formation_id', $formation->id)
                                  ->where('statut', 'validee')
                                  ->first();

        abort_if(!$inscription, 403, 'Accès refusé — inscription non validée.');

        $formation->load(['modules.contenus', 'evaluations']);

        return view('apprenant.formations.contenu', compact('formation', 'inscription'));
    }
}