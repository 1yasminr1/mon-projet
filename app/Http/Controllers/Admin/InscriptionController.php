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
                                   ->latest()
                                   ->paginate(15);
        return view('admin.inscriptions.index', compact('inscriptions'));
    }

    public function validerFormation(Formation $formation)
    {
        $formation->update(['statut' => 'validee']);

        Notification::envoyer(
            $formation->user_id,
            'Formation validée ✅',
            "Votre formation \"{$formation->titre}\" a été validée et est maintenant publiée."
        );

        return back()->with('success', 'Formation validée.');
    }

    public function rejeterFormation(Formation $formation)
    {
        $formation->update(['statut' => 'rejetee']);

        Notification::envoyer(
            $formation->user_id,
            'Formation rejetée ❌',
            "Votre formation \"{$formation->titre}\" a été rejetée par l'administrateur."
        );

        return back()->with('success', 'Formation rejetée.');
    }

    public function formations()
    {
        $formations = Formation::with(['formateur', 'sousCategorie'])
                               ->latest()
                               ->paginate(15);
        return view('admin.formations.index', compact('formations'));
    }
}