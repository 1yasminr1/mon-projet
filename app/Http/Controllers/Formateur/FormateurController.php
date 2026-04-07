<?php

namespace App\Http\Controllers\Formateur;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\Inscription;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class FormateurController extends Controller
{
    public function index()
    {
        $user  = Auth::user();
        $stats = [
            'total_formations'   => Formation::where('user_id', $user->id)->count(),
            'total_apprenants'   => Inscription::whereHas('formation', fn($q) =>
                                        $q->where('user_id', $user->id))->count(),
            'formations_valides' => Formation::where('user_id', $user->id)
                                             ->where('statut', 'validee')->count(),
            'en_attente'         => Formation::where('user_id', $user->id)
                                             ->where('statut', 'en_attente')->count(),
            'inscriptions_attente' => Inscription::whereHas('formation', fn($q) =>
                                          $q->where('user_id', $user->id))
                                          ->where('statut', 'en_attente')->count(),
        ];

        $formations = Formation::where('user_id', $user->id)
                               ->with(['sousCategorie', 'inscriptions'])
                               ->latest()->get();

        return view('formateur.dashboard', compact('stats', 'formations'));
    }

    public function progression()
    {
        $formations = Formation::where('user_id', Auth::id())
                               ->with(['inscriptions.apprenant'])
                               ->where('statut', 'validee')
                               ->get();
        return view('formateur.progression', compact('formations'));
    }

    // ==================== INSCRIPTIONS ====================
    public function inscriptions()
{
    $query = Inscription::whereHas('formation', function($q) {
                 $q->where('user_id', Auth::id());
             })->with(['apprenant', 'formation'])->latest();

    if (request('statut')) {
        $query->where('statut', request('statut'));
    }

    $inscriptions = $query->paginate(15);
    return view('formateur.inscriptions.index', compact('inscriptions'));
}

    public function validerInscription(Inscription $inscription)
    {
        // Vérifier que la formation appartient au formateur
        abort_if($inscription->formation->user_id !== Auth::id(), 403);

        $inscription->valider();

        Notification::envoyer(
            $inscription->user_id,
            'Inscription validée ✅',
            "Votre inscription à \"{$inscription->formation->titre}\" a été validée. Vous pouvez maintenant accéder au cours !"
        );

        return back()->with('success', 'Inscription validée — apprenant notifié.');
    }

    public function refuserInscription(Inscription $inscription)
    {
        abort_if($inscription->formation->user_id !== Auth::id(), 403);

        $inscription->annuler();

        Notification::envoyer(
            $inscription->user_id,
            'Inscription refusée ❌',
            "Votre inscription à \"{$inscription->formation->titre}\" a été refusée par le formateur."
        );

        return back()->with('success', 'Inscription refusée.');
    }
}