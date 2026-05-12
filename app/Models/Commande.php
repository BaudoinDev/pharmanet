<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $fillable = [
        'client_id',
        'pharmacie_id',
        'montant_total',
        'statut',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function pharmacie()
    {
        return $this->belongsTo(Pharmacie::class);
    }

    public function ligneCommandes()
    {
        return $this->hasMany(LigneCommande::class);
    }
}
