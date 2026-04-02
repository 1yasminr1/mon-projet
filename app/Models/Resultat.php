<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Resultat extends Model
{
    protected $fillable = ['note', 'reussi', 'user_id', 'evaluation_id'];

    public function apprenant()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }
}