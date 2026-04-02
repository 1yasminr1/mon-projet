<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class SousCategorie extends Model
{
    protected $fillable = ['nom', 'categorie_id'];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function formations()
    {
        return $this->hasMany(Formation::class);
    }
}