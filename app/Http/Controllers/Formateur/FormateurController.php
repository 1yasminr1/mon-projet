<?php
namespace App\Http\Controllers\Formateur;

use App\Http\Controllers\Controller;
use App\Models\Formation;
use App\Models\Inscription;
use Illuminate\Support\Facades\Auth;

class FormateurController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $stats = [
            'total_formations'  => Formation::where('user_id', $user->id)->count(),
            'total_apprenants'  => Inscription::whereHas('formation', fn($q) =>
                                       $q->where('user_id', $user->id))->count(),
            'formations_valides'=> Formation::where('user_id', $user->id)
                                            ->where('statut', 'validee')->count(),
            'en_attente'        => Formation::where('user_id', $user->id)
                                            ->where('statut', 'en_attente')->count(),
        ];
        $formations = Formation::where('user_id', $user->id)->latest()->take(5)->get();
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
}