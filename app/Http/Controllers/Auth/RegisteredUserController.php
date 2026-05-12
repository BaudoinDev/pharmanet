<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'prenom'          => ['required', 'string', 'max:100'],
            'nom'             => ['required', 'string', 'max:100'],
            'email'           => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'telephone'       => ['required', 'string', 'max:20'],
            'adresse'         => ['nullable', 'string', 'max:255'],
            'date_naissance'  => ['required', 'date', 'before:today'],
            'sexe'            => ['required', 'in:homme,femme'],
            'password'        => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'     => $request->prenom . ' ' . $request->nom,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'client',
        ]);

        Client::create([
            'user_id'        => $user->id,
            'prenom'         => $request->prenom,
            'nom'            => $request->nom,
            'email'          => $request->email,
            'telephone'      => $request->telephone,
            'adresse'        => $request->adresse,
            'date_naissance' => $request->date_naissance,
            'sexe'           => $request->sexe,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('client.dashboard');
    }
}
