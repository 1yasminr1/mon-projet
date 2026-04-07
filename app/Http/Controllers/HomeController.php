<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Formation;
use App\Models\Categorie;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        // Formations validées depuis la BDD
        $formations = Formation::where('statut', 'validee')
                               ->with(['sousCategorie.categorie', 'formateur', 'inscriptions'])
                               ->latest()
                               ->take(6)
                               ->get();

        // Catégories depuis la BDD
        $categories = Categorie::with('sousCategories')
                               ->withCount(['sousCategories'])
                               ->get();

        // Stats réelles
        $stats = [
            'formations'  => Formation::where('statut', 'validee')->count(),
            'apprenants'  => User::where('role', 'apprenant')->count(),
            'formateurs'  => User::where('role', 'formateur')
                                 ->where('statut_formateur', 'approuve')->count(),
        ];

        return view('home', compact('formations', 'categories', 'stats'));
    }
}