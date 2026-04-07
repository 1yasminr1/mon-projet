<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Formation;
use App\Models\Inscription;
use App\Models\Certificat;
use App\Models\Categorie;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_apprenants'   => User::where('role', 'apprenant')->count(),
            'total_formateurs'   => User::where('role', 'formateur')
                                        ->where('statut_formateur', 'approuve')->count(),
            'formateurs_attente' => User::where('role', 'formateur')
                                        ->where('statut_formateur', 'en_attente')->count(),
            'total_formations'   => Formation::count(),
            'formations_attente' => Formation::where('statut', 'en_attente')->count(),
            'formations_valides' => Formation::where('statut', 'validee')->count(),
            'total_inscriptions' => Inscription::count(),
            'total_certificats'  => Certificat::count(),
            'total_categories'   => Categorie::count(),
        ];

        $formateurs_attente = User::where('role', 'formateur')
                                  ->where('statut_formateur', 'en_attente')
                                  ->latest()->take(5)->get();

        $formations_attente = Formation::where('statut', 'en_attente')
                                       ->with(['formateur', 'sousCategorie'])
                                       ->latest()->take(5)->get();

        $derniers_apprenants = User::where('role', 'apprenant')
                                   ->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'stats',
            'formateurs_attente',
            'formations_attente',
            'derniers_apprenants'
        ));
    }
}