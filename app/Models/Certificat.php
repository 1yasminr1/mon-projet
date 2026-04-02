<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Certificat extends Model
{
    protected $fillable = ['code', 'date_obtention', 'user_id', 'formation_id'];

    public function apprenant()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public static function attribuer(int $userId, int $formationId)
    {
        return self::create([
            'code'            => strtoupper(Str::random(10)),
            'date_obtention'  => now(),
            'user_id'         => $userId,
            'formation_id'    => $formationId,
        ]);
    }

    public function telecharger()
    {
        return $this->code;
    }
}