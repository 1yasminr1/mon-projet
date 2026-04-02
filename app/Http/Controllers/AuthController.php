<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // ==================== LOGIN ====================
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'Email introuvable.')->withInput();
        }

        if ($user->estBloque()) {
            return back()->with('error', 'Votre compte est bloqué. Contactez l\'administrateur.')->withInput();
        }

        if ($user->isFormateur() && $user->statut_formateur === 'en_attente') {
            return back()->with('error', 'Votre compte formateur est en attente de validation.')->withInput();
        }

        if ($user->isFormateur() && $user->statut_formateur === 'rejete') {
            return back()->with('error', 'Votre demande formateur a été rejetée.')->withInput();
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();

            if ($user->isAdmin())     return redirect()->route('admin.dashboard');
            if ($user->isFormateur()) return redirect()->route('formateur.dashboard');
            return redirect()->route('apprenant.dashboard');
        }

        return back()->with('error', 'Mot de passe incorrect.')->withInput();
    }

    // ==================== REGISTER APPRENANT ====================
    public function showRegisterApprenant()
    {
        return view('auth.register-apprenant');
    }

    public function registerApprenant(Request $request)
    {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users',
            'password'              => 'required|min:6|confirmed',
        ], [
            'name.required'         => 'Le nom est obligatoire.',
            'email.required'        => 'L\'email est obligatoire.',
            'email.unique'          => 'Cet email est déjà utilisé.',
            'password.min'          => 'Le mot de passe doit avoir au moins 6 caractères.',
            'password.confirmed'    => 'Les mots de passe ne correspondent pas.',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'apprenant',
            'statut'   => 'actif',
        ]);

        return redirect()->route('login')->with('success', 'Compte apprenant créé ! Connectez-vous.');
    }

    // ==================== REGISTER FORMATEUR ====================
    public function showRegisterFormateur()
    {
        return view('auth.register-formateur');
    }

    public function registerFormateur(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|min:6|confirmed',
            'diplome'    => 'required|string|max:255',
            'specialite' => 'required|string|max:255',
            'experience' => 'required|integer|min:0|max:50',
            'cv'         => 'required|file|mimes:pdf|max:5120',
        ], [
            'name.required'       => 'Le nom est obligatoire.',
            'email.unique'        => 'Cet email est déjà utilisé.',
            'password.confirmed'  => 'Les mots de passe ne correspondent pas.',
            'diplome.required'    => 'Le diplôme est obligatoire.',
            'specialite.required' => 'La spécialité est obligatoire.',
            'experience.required' => 'L\'expérience est obligatoire.',
            'cv.required'         => 'Le CV est obligatoire.',
            'cv.mimes'            => 'Le CV doit être en format PDF.',
        ]);

        $cvPath = $request->file('cv')->store('cvs', 'public');

        User::create([
            'name'             => $request->name,
            'email'            => $request->email,
            'password'         => Hash::make($request->password),
            'role'             => 'formateur',
            'statut'           => 'actif',
            'diplome'          => $request->diplome,
            'specialite'       => $request->specialite,
            'experience'       => $request->experience,
            'cv'               => $cvPath,
            'statut_formateur' => 'en_attente',
        ]);

        return redirect()->route('login')
                         ->with('success', 'Demande envoyée ! En attente de validation par l\'administrateur.');
    }

    // ==================== LOGOUT ====================
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}