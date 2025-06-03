<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens,HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password','telephone',
        'adresse', 
        'date_inscription',
        'role', 'actif'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'date_inscription' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function emprunts()
    {
        return $this->hasMany(Emprunt::class);
    }

    public function historiques()
    {
        return $this->hasMany(Historique::class);
    }

    public function userNotifications()
    {
        return $this->hasMany(UserNotification::class);
    }

    public function recommandations()
    {
        return $this->hasMany(Recommandation::class);
    }

    /**
     * Vérifie si l'utilisateur est un administrateur
     *
     * @return bool
     */
    // Méthode fondamentale
     public function isAdmin()
    {
    // Vérification double pour être absolument certain
    return $this->role === 'admin' && $this->is_admin == 1;
    }

    public function isBibliothecaire()
    {
        return $this->role === 'bibliothecaire';
    }

}
