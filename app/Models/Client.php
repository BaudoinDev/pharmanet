<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        
        'nom',
        'prenom',
        'email',
        'telephone',
        'adresse',
        'date_naissance',
        'sexe',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }
}
