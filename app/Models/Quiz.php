<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $table = 'quiz'; // forcer le nom de la table

    protected $fillable = [
        'question',
        'reponse_a',
        'reponse_b',
        'reponse_c',
        'reponse_d',
        'bonne_reponse',
        'evaluation_id',
    ];

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }
}