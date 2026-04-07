<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = ['titre', 'message', 'lu', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function envoyer(int $userId, string $titre, string $message)
    {
        return self::create([
            'user_id' => $userId,
            'titre'   => $titre,
            'message' => $message,
            'lu'      => false,
        ]);
    }
}