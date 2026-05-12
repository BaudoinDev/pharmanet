<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LigneCommande extends Model
{
    protected $fillable = [
        'commande_id',
        'medicament_id',
        'quantite',
        'prix_unitaire',
    ];

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function medicament()
    {
        return $this->belongsTo(Medicament::class);
    }
}
