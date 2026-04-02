<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Formation;
use App\Models\Inscription;
use App\Models\Certificat;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'total_apprenants'  => User::where('role', 'apprenant')->count(),
            'total_formateurs'  => User::where('role', 'formateur')->count(),
            'total_formations'  => Formation::count(),
            'formations_attente'=> Formation::where('statut', 'en_attente')->count(),
            'total_inscriptions'=> Inscription::count(),
            'total_certificats' => Certificat::count(),
        ];
        return view('admin.dashboard', compact('stats'));
    }
}