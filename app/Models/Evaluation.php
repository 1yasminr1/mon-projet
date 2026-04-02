<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = ['type', 'titre', 'note_min', 'formation_id'];

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function questions()
    {
        return $this->hasMany(Quiz::class);
    }

    public function resultats()
    {
        return $this->hasMany(Resultat::class);
    }

    public function calculerNote(array $reponses): int
    {
        $questions  = $this->questions;
        $score      = 0;

        foreach ($questions as $question) {
            if (isset($reponses[$question->id]) &&
                $reponses[$question->id] === $question->bonne_reponse) {
                $score++;
            }
        }

        return $questions->count() > 0
            ? (int) round(($score / $questions->count()) * 20)
            : 0;
    }
}