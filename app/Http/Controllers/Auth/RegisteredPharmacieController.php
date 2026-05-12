<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pharmacie;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredPharmacieController extends Controller
{
    public function create(): View
    {
        return view('auth.register-pharmacie');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'            => ['required', 'string', 'max:150'],
            'email'           => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password'        => ['required', 'confirmed', Rules\Password::defaults()],
            'nom'             => ['required', 'string', 'max:150'],
            'adresse'         => ['required', 'string', 'max:255'],
            'telephone'       => ['nullable', 'string', 'max:20'],
            'numero_agrement' => ['nullable', 'string', 'max:100'],
            'logo'            => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'garde'           => ['nullable', 'boolean'],
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'pharmacie',
        ]);

        Pharmacie::create([
            'user_id'         => $user->id,
            'nom'             => $request->nom,
            'adresse'         => $request->adresse,
            'telephone'       => $request->telephone,
            'numero_agrement' => $request->numero_agrement,
            'logo'            => $logoPath,
            'garde'           => $request->boolean('garde'),
            'statut'          => 'en_attente',
        ]);

        event(new Registered($user));

        return redirect()->route('login')
            ->with('pharmacie_registered', 'Votre demande d\'inscription a bien été soumise. Notre équipe va vérifier votre dossier et vous contacter sous 48h.');
    }
}
