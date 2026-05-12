<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Pharmacie\PharmacieController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $stats = [
        'pharmacies' => \App\Models\Pharmacie::where('statut', 'approuvee')->count(),
        'medicaments' => \App\Models\Medicament::count(),
        'garde' => \App\Models\Pharmacie::where('statut', 'approuvee')->where('garde', true)->count(),
    ];
    $categories = \App\Models\Categorie::orderBy('nom')->take(8)->get();
    return view('welcome', compact('stats', 'categories'));
});

Route::get('/recherche', function (\Illuminate\Http\Request $request) {
    $q = trim($request->get('q', ''));

    if (strlen($q) < 2) {
        return response()->json(['results' => [], 'count' => 0]);
    }

    $medicaments = \App\Models\Medicament::where('nom', 'LIKE', "%{$q}%")
        ->with(['pharmacies' => function ($qb) {
            $qb->where('statut', 'approuvee');
        }, 'categorie'])
        ->take(5)
        ->get();

    $results = [];
    foreach ($medicaments as $med) {
        foreach ($med->pharmacies as $pharm) {
            $results[] = [
                'medicament_id'  => $med->id,
                'medicament_nom' => $med->nom,
                'categorie'      => $med->categorie?->nom,
                'prescription'   => (bool) $med->prescription_obligatoire,
                'pharmacie_id'   => $pharm->id,
                'pharmacie_nom'  => $pharm->nom,
                'adresse'        => $pharm->adresse,
                'telephone'      => $pharm->telephone,
                'garde'          => (bool) $pharm->garde,
                'logo'           => $pharm->logo ? asset('storage/' . $pharm->logo) : null,
                'stock'          => (int) $pharm->pivot->stock,
                'prix'           => (float) $pharm->pivot->prix,
                'disponible'     => $pharm->pivot->stock > 0,
            ];
        }
    }

    usort($results, fn($a, $b) =>
        ($b['disponible'] ? 1 : 0) - ($a['disponible'] ? 1 : 0) ?: $a['prix'] - $b['prix']
    );

    return response()->json(['results' => $results, 'count' => count($results)]);
})->name('recherche');

Route::get('/dashboard', function () {
    $role = Auth::user()->role;
    if ($role === 'admin')     return redirect()->route('admin.dashboard');
    if ($role === 'pharmacie') return redirect()->route('pharmacie.dashboard');
    return redirect()->route('client.dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'pharmacie'])->prefix('pharmacie')->name('pharmacie.')->group(function () {
    Route::get('/en-attente',              [PharmacieController::class, 'enAttente'])->name('en-attente');
    Route::get('/dashboard',               [PharmacieController::class, 'dashboard'])->name('dashboard');
    Route::get('/commandes',               [PharmacieController::class, 'commandes'])->name('commandes');
    Route::get('/ordonnances',             [PharmacieController::class, 'ordonnances'])->name('ordonnances');
    Route::get('/medicaments',             [PharmacieController::class, 'medicaments'])->name('medicaments');
    Route::get('/medicaments/modele',           [PharmacieController::class, 'telechargerModele'])->name('medicaments.modele');
    Route::post('/medicaments/importer',        [PharmacieController::class, 'importerCatalogue'])->name('medicaments.importer');
    Route::post('/medicaments',                 [PharmacieController::class, 'storeMedicament'])->name('medicaments.store');
    Route::put('/medicaments/{medicament}',     [PharmacieController::class, 'updateMedicament'])->name('medicaments.update');
    Route::delete('/medicaments/{medicament}',  [PharmacieController::class, 'destroyMedicament'])->name('medicaments.destroy');
    Route::get('/categories',                        [PharmacieController::class, 'categories'])->name('categories');
    Route::post('/categories',                       [PharmacieController::class, 'storeCategorie'])->name('categories.store');
    Route::put('/categories/{categorie}',            [PharmacieController::class, 'updateCategorie'])->name('categories.update');
    Route::delete('/categories/{categorie}',         [PharmacieController::class, 'destroyCategorie'])->name('categories.destroy');
    Route::get('/parametres',                        [PharmacieController::class, 'parametres'])->name('parametres');
    Route::put('/parametres',                   [PharmacieController::class, 'updateParametres'])->name('parametres.update');
    Route::delete('/compte',                    [PharmacieController::class, 'supprimerCompte'])->name('compte.supprimer');
});

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/pharmacies', [AdminController::class, 'pharmacies'])->name('pharmacies');
    Route::get('/demandes-pharmacies', [AdminController::class, 'demandesPharmacies'])->name('demandes.pharmacies');
    Route::get('/clients', [AdminController::class, 'clients'])->name('clients');
    Route::post('/pharmacies/{pharmacie}/approuver', [AdminController::class, 'approuverPharmacie'])->name('pharmacies.approuver');
    Route::post('/pharmacies/{pharmacie}/refuser', [AdminController::class, 'refuserPharmacie'])->name('pharmacies.refuser');
});

Route::middleware(['auth'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard',    [ClientController::class, 'dashboard'])->name('dashboard');
    Route::get('/commandes',    [ClientController::class, 'commandes'])->name('commandes');
    Route::get('/ordonnances',  [ClientController::class, 'ordonnances'])->name('ordonnances');
    Route::get('/profil',       [ClientController::class, 'profil'])->name('profil');
    Route::put('/profil',       [ClientController::class, 'updateProfil'])->name('profil.update');
});

require __DIR__.'/auth.php';
