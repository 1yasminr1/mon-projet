<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inscription;
use App\Models\Formation;
use App\Models\Notification;

class InscriptionController extends Controller
{
    public function index()
    {
        $inscriptions = Inscription::with(['apprenant', 'formation'])
                                   ->latest()->paginate(10);
        return view('admin.inscriptions.index', compact('inscriptions'));
    }

    public function validerFormation(Formation $formation)
    {
        $formation->update(['statut' => 'validee']);
        Notification::envoyer(
            $formation->user_id,
            'Formation validée',
            "Votre formation '{$formation->titre}' a été validée."
        );
        return back()->with('success', 'Formation validée.');
    }

    public function rejeterFormation(Formation $formation)
    {
        $formation->update(['statut' => 'rejetee']);
        Notification::envoyer(
            $formation->user_id,
            'Formation rejetée',
            "Votre formation '{$formation->titre}' a été rejetée."
        );
        return back()->with('success', 'Formation rejetée.');
    }

    public function formations()
    {
        $formations = Formation::with(['formateur', 'sousCategorie'])
                               ->where('statut', 'en_attente')
                               ->latest()->get();
        return view('admin.formations.index', compact('formations'));
    }
}