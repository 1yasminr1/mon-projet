<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    protected $fillable = ['user_id', 'formation_id', 'statut', 'progression'];

    public function apprenant()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function valider()
    {
        return $this->update(['statut' => 'validee']);
    }

    public function annuler()
    {
        return $this->update(['statut' => 'annulee']);
    }
}