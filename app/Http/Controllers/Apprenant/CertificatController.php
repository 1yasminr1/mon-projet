<?php
namespace App\Http\Controllers\Apprenant;

use App\Http\Controllers\Controller;
use App\Models\Certificat;
use Illuminate\Support\Facades\Auth;

class CertificatController extends Controller
{
    public function index()
    {
        $certificats = Certificat::where('user_id', Auth::id())
                                 ->with('formation')->latest()->get();
        return view('apprenant.certificats.index', compact('certificats'));
    }

    public function telecharger(Certificat $certificat)
    {
        abort_if($certificat->user_id !== Auth::id(), 403);
        return view('apprenant.certificats.telecharger', compact('certificat'));
    }
}