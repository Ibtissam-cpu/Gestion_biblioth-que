<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Livre; // J'ai remarqué que vous utilisez "Livre" plutôt que "Book"

class Loan extends Model
{
   use HasFactory;

    protected $table = 'emprunts';

    protected $fillable = [
        'livre_id',
        'user_id',
        'date_emprunt',
        'date_retour_prevue',
        'date_retour',
        'commentaire',
        'etat_avant',
        'etat_apres',
        'prolonge'
    ];

    protected $dates = [
        'date_emprunt',
        'date_retour_prevue',
        'date_retour',
        'created_at',
        'updated_at'
    ];

    public function livre()
    {
        return $this->belongsTo(Livre::class, 'livre_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Vérifie si l'emprunt est en cours
    public function estEnCours()
    {
        return is_null($this->date_retour);
    }

    // Méthode pour vérifier si l'emprunt est en retard
    public function estEnRetard()
    {
        return $this->statut === 'emprunté' && 
               now()->greaterThan($this->date_retour_prevue) && 
               empty($this->date_retour_effectif);
    }

    // Méthode pour marquer comme retourné
    public function marquerRetourne()
    {
        $this->update([
            'date_retour_effectif' => now(),
            'statut' => 'retourné'
        ]);
    }
}