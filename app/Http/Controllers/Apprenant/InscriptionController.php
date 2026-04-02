<?php
namespace App\Http\Controllers\Apprenant;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\Inscription;
use App\Models\Contenu;
use Illuminate\Support\Facades\Auth;

class InscriptionController extends Controller
{
    public function index()
    {
        $inscriptions = Inscription::where('user_id', Auth::id())
                                   ->with('formation')->latest()->paginate(10);
        return view('apprenant.inscriptions.index', compact('inscriptions'));
    }

    public function formations()
    {
        $formations = Formation::where('statut', 'validee')
                               ->with(['sousCategorie.categorie', 'formateur'])
                               ->latest()->paginate(12);
        return view('apprenant.formations.index', compact('formations'));
    }

    public function detail(Formation $formation)
    {
        $formation->load(['modules.contenus', 'formateur', 'sousCategorie.categorie']);
        $inscription = Inscription::where('user_id', Auth::id())
                                  ->where('formation_id', $formation->id)->first();
        return view('apprenant.formations.detail', compact('formation', 'inscription'));
    }

    public function inscrire(Formation $formation)
    {
        $existant = Inscription::where('user_id', Auth::id())
                               ->where('formation_id', $formation->id)->first();
        if ($existant) {
            return back()->with('error', 'Vous êtes déjà inscrit.');
        }

        Inscription::create([
            'user_id'      => Auth::id(),
            'formation_id' => $formation->id,
            'statut'       => 'en_attente',
        ]);
        return back()->with('success', 'Inscription envoyée, en attente de validation.');
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
                                  ->where('statut', 'validee')->first();
        abort_if(!$inscription, 403, 'Accès non autorisé.');
        $formation->load(['modules.contenus']);
        return view('apprenant.formations.contenu', compact('formation', 'inscription'));
    }
}