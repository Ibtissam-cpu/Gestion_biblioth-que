<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recommandation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'livre_id',
        'commentaire',
        'type',
        'categorie_id',
        'age_min',
        'age_max',
        'priorite'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function livre()
    {
        return $this->belongsTo(Livre::class);
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }
}
