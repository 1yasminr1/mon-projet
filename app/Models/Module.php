<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['titre', 'description', 'ordre', 'formation_id'];

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function contenus()
    {
        return $this->hasMany(Contenu::class)->orderBy('ordre');
    }

    public function gererModule(array $data)
    {
        return $this->update($data);
    }
}