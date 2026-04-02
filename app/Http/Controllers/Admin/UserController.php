<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('role', '!=', 'admin')->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function bloquer(User $user)
    {
        $user->update(['statut' => 'bloque']);
        Notification::envoyer($user->id, 'Compte bloqué', 'Votre compte a été bloqué par un administrateur.');
        return back()->with('success', 'Compte bloqué.');
    }

    public function debloquer(User $user)
    {
        $user->update(['statut' => 'actif']);
        Notification::envoyer($user->id, 'Compte débloqué', 'Votre compte a été débloqué.');
        return back()->with('success', 'Compte débloqué.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'Utilisateur supprimé.');
    }

    public function envoyerNotification(Request $request, User $user)
    {
        $request->validate([
            'titre'   => 'required|string',
            'message' => 'required|string',
        ]);
        Notification::envoyer($user->id, $request->titre, $request->message);
        return back()->with('success', 'Notification envoyée.');
    }
    public function formateurs()
{
    $formateurs = User::where('role', 'formateur')
                      ->latest()->paginate(10);
    return view('admin.users.formateurs', compact('formateurs'));
}

public function validerFormateur(User $user)
{
    $user->update(['statut_formateur' => 'approuve']);
    Notification::envoyer(
        $user->id,
        'Compte approuvé !',
        'Votre compte formateur a été approuvé. Vous pouvez maintenant vous connecter.'
    );
    return back()->with('success', 'Formateur approuvé.');
}

public function rejeterFormateur(User $user)
{
    $user->update(['statut_formateur' => 'rejete']);
    Notification::envoyer(
        $user->id,
        'Demande rejetée',
        'Votre demande de compte formateur a été rejetée.'
    );
    return back()->with('success', 'Formateur rejeté.');
}
}