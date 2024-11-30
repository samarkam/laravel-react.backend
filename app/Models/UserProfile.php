<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    // Définir les attributs pouvant être assignés en masse
    protected $fillable = [
        'userId',   // Lien avec le modèle User
        'address',
        'name',
        'phone_number',
    ];

    // Définir la relation avec le modèle User (chaque profil appartient à un utilisateur)



    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
