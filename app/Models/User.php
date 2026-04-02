<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
    'name', 'email', 'password', 'role', 'statut',
    'photo', 'diplome', 'specialite', 'experience',
    'cv', 'statut_formateur',
];

    protected $hidden = ['password', 'remember_token'];

    public function formations()
    {
        return $this->hasMany(Formation::class);
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    public function certificats()
    {
        return $this->hasMany(Certificat::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function resultats()
    {
        return $this->hasMany(Resultat::class);
    }

    public function isAdmin() { return $this->role === 'admin'; }
    public function isFormateur() { return $this->role === 'formateur'; }
    public function isApprenant() { return $this->role === 'apprenant'; }
    public function estBloque() { return $this->statut === 'bloque'; }
}