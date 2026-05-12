<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pharmacie extends Model
{
    protected $fillable = [
        'user_id',
        'nom',
        'adresse',
        'telephone',
        'numero_agrement',
        'statut',
        'logo',
        'garde',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function medicaments()
    {
        return $this->belongsToMany(Medicament::class, 'medicament_pharmacie')
                    ->withPivot('stock', 'prix')
                    ->withTimestamps();
    }

    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }
}
