<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Medicament extends Model
{
    protected $fillable = [
        'nom',
        'description',
        'categorie_id',
        'image',
        'prescription_obligatoire',
    ];

    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }

    public function pharmacies()
    {
        return $this->belongsToMany(Pharmacie::class, 'medicament_pharmacie')
                    ->withPivot('stock', 'prix')
                    ->withTimestamps();
    }

    public function ligneCommandes()
    {
        return $this->hasMany(LigneCommande::class);
    }
}
