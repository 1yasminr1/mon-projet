<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Formation extends Model
{
    protected $fillable = [
        'titre', 'description', 'prix', 'image',
        'duree', 'statut', 'user_id', 'sous_categorie_id'
    ];

    public function formateur()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function sousCategorie()
    {
        return $this->belongsTo(SousCategorie::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class)->orderBy('ordre');
    }

    public function inscriptions()
    {
        return $this->hasMany(Inscription::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function certificats()
    {
        return $this->hasMany(Certificat::class);
    }

    public function gererFormation(array $data)
    {
        return $this->update($data);
    }

    public static function creerFormation(array $data)
    {
        return self::create($data);
    }
}