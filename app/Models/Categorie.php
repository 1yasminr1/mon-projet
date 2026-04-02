<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $fillable = ['nom', 'description'];

    public function sousCategories()
    {
        return $this->hasMany(SousCategorie::class);
    }

    public function listerFormations()
    {
        return Formation::whereHas('sousCategorie', function($q) {
            $q->where('categorie_id', $this->id);
        })->where('statut', 'validee')->get();
    }
}