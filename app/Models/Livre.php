<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livre extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre', 'auteur_id', 'categorie_id', 'isbn', 'description',
        'annee_publication', 'editeur', 'nombre_pages', 'stock_total',
        'stock_disponible', 'image_couverture', 'note_moyenne'
    ];

    public function auteur()
    {
        return $this->belongsTo(Auteur::class);
    }

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function emprunts()
    {
        return $this->hasMany(Emprunt::class);
    }

    public function historiques()
    {
        return $this->hasMany(Historique::class);
    }

    public function recommandations()
    {
        return $this->hasMany(Recommandation::class);
    }

    public function estDisponible()
    {
        return $this->stock_disponible > 0;
    }

    public function scopeRecherche($query, $terme)
    {
        return $query->where('titre', 'like', "%{$terme}%")
            ->orWhereHas('auteur', function ($query) use ($terme) {
                $query->where('nom', 'like', "%{$terme}%")
                    ->orWhere('prenom', 'like', "%{$terme}%");
            });
    }
    
    public function loans()
    {
    return $this->hasMany(Loan::class, 'livre_id');
    }
}
