<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'statut',
        'photo', 'diplome', 'specialite', 'experience',
        'cv', 'statut_formateur',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // Relations
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

    // Rôles
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isFormateur(): bool
    {
        return $this->role === 'formateur';
    }

    public function isApprenant(): bool
    {
        return $this->role === 'apprenant';
    }

    public function estBloque(): bool
    {
        return $this->statut === 'bloque';
    }
}