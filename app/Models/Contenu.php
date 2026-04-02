<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Contenu extends Model
{
    protected $fillable = ['titre', 'type', 'fichier', 'ordre', 'module_id'];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function telecharger()
    {
        return Storage::download($this->fichier, $this->titre);
    }
}