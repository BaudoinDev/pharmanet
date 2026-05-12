<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    private function client()
    {
        return \App\Models\Client::where('email', Auth::user()->email)->first();
    }

    public function dashboard()
    {
        $client   = $this->client();
        $commandes = $client ? $client->commandes()->with('pharmacie')->latest()->take(5)->get() : collect();

        $stats = [
            'total'       => $client ? $client->commandes()->count() : 0,
            'en_attente'  => $client ? $client->commandes()->where('statut', 'en_attente')->count() : 0,
            'terminees'   => $client ? $client->commandes()->where('statut', 'livree')->count() : 0,
            'ordonnances' => 0,
        ];

        return view('client.dashbordClient', compact('stats', 'commandes'));
    }

    public function commandes()
    {
        $client   = $this->client();
        $commandes = $client ? $client->commandes()->with('pharmacie')->latest()->paginate(10) : collect();

        return view('client.commandes', compact('commandes'));
    }

    public function ordonnances()
    {
        return view('client.ordonnances');
    }

    public function profil()
    {
        $client = $this->client();
        return view('client.profil', compact('client'));
    }

    public function updateProfil(Request $request)
    {
        $client = $this->client();
        $user   = Auth::user();

        $request->validate([
            'prenom'         => ['required', 'string', 'max:100'],
            'nom'            => ['required', 'string', 'max:100'],
            'telephone'      => ['required', 'string', 'max:20'],
            'adresse'        => ['nullable', 'string', 'max:255'],
            'date_naissance' => ['required', 'date'],
            'sexe'           => ['required', 'in:homme,femme'],
            'password'       => ['nullable', 'confirmed', 'min:8'],
        ]);

        $client->update($request->only('prenom', 'nom', 'telephone', 'adresse', 'date_naissance', 'sexe'));
        $user->update(['name' => $request->prenom . ' ' . $request->nom]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return back()->with('success', 'Profil mis à jour avec succès.');
    }
}
