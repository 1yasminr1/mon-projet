<?php
namespace App\Http\Controllers\Apprenant;

use App\Http\Controllers\Controller;
use App\Models\Inscription;
use App\Models\Certificat;
use Illuminate\Support\Facades\Auth;

class ApprenantController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $stats = [
            'formations_suivies' => Inscription::where('user_id', $user->id)
                                               ->where('statut', 'validee')->count(),
            'certificats'        => Certificat::where('user_id', $user->id)->count(),
            'en_attente'         => Inscription::where('user_id', $user->id)
                                               ->where('statut', 'en_attente')->count(),
        ];
        $inscriptions = Inscription::where('user_id', $user->id)
                                   ->with('formation')->latest()->take(5)->get();
        return view('apprenant.dashboard', compact('stats', 'inscriptions'));
    }
}