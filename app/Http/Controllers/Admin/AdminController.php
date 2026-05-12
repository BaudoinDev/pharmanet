<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Commande;
use App\Models\Pharmacie;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $demandesEnAttente = Pharmacie::where('statut', 'en_attente')
            ->with('user')
            ->latest()
            ->get();

        $stats = [
            'pharmacies_total'    => Pharmacie::count(),
            'pharmacies_actives'  => Pharmacie::where('statut', 'acceptee')->count(),
            'pharmacies_attente'  => $demandesEnAttente->count(),
            'pharmacies_suspendues' => Pharmacie::where('statut', 'suspendue')->count(),
            'clients_total'       => Client::count(),
            'commandes_mois'      => Commande::whereMonth('created_at', now()->month)->count(),
            'commandes_semaine'   => Commande::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
        ];

        return view('admin.dashboard', compact('demandesEnAttente', 'stats'));
    }

    public function pharmacies()
    {
        return view('admin.pharmacies');
    }

    public function demandesPharmacies()
    {
        return view('admin.demandes_pharmacies');
    }

    public function clients()
    {
        return view('admin.clients');
    }

    public function approuverPharmacie(Pharmacie $pharmacie)
    {
        $pharmacie->update(['statut' => 'acceptee']);

        return back()->with('success', "La pharmacie « {$pharmacie->nom} » a été approuvée.");
    }

    public function refuserPharmacie(Pharmacie $pharmacie)
    {
        $pharmacie->update(['statut' => 'refusee']);

        return back()->with('success', "La pharmacie « {$pharmacie->nom} » a été refusée.");
    }
}
