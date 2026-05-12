<?php

namespace App\Http\Controllers\Pharmacie;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use App\Models\Medicament;
use App\Models\Pharmacie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PharmacieController extends Controller
{
    private function pharmacie(): ?Pharmacie
    {
        //Fonction retournant la pharmacie dont l'identifiant est celui de l'utilisatueur connecté
        return Pharmacie::where('user_id', Auth::id())->first();
    }

    public function enAttente()
    {
        $pharmacie = $this->pharmacie();
        if ($pharmacie && $pharmacie->statut === 'acceptee') {
            return redirect()->route('pharmacie.dashboard');
        }
        return view('pharmacie.en-attente', compact('pharmacie'));
    }

    public function dashboard()
    {
        $pharmacie = $this->pharmacie();
        if (!$pharmacie || $pharmacie->statut !== 'acceptee') {
            return redirect()->route('pharmacie.en-attente');
        }

        $stats = [
            'commandes_total'   => $pharmacie->commandes()->count(),
            'commandes_attente' => $pharmacie->commandes()->where('statut', 'en_attente')->count(),
            'commandes_mois'    => $pharmacie->commandes()->whereMonth('created_at', now()->month)->count(),
            'medicaments'       => $pharmacie->medicaments()->count(),
        ];

        $commandes = $pharmacie->commandes()->with('client')->latest()->take(5)->get();

        return view('pharmacie.dashboard', compact('pharmacie', 'stats', 'commandes'));
    }

    public function commandes(Request $request)
    {
        $pharmacie = $this->pharmacie();
        if (!$pharmacie || $pharmacie->statut !== 'acceptee') {
            return redirect()->route('pharmacie.en-attente');
        }

        $query = $pharmacie->commandes()->with('client');

        if ($request->filled('statut') && $request->statut !== 'tous') {
            $query->where('statut', $request->statut);
        }
        if ($request->filled('search')) {
            $query->whereHas('client', function ($q) use ($request) {
                $q->where('prenom', 'like', '%' . $request->search . '%')
                  ->orWhere('nom', 'like', '%' . $request->search . '%');
            });
        }

        $commandes = $query->latest()->paginate(15);

        $stats = [
            'total'     => $pharmacie->commandes()->count(),
            'attente'   => $pharmacie->commandes()->where('statut', 'en_attente')->count(),
            'confirmee' => $pharmacie->commandes()->where('statut', 'confirmee')->count(),
            'livree'    => $pharmacie->commandes()->where('statut', 'livree')->count(),
        ];

        return view('pharmacie.commandes', compact('pharmacie', 'commandes', 'stats'));
    }

    public function categories()
    {
        $pharmacie = $this->pharmacie();
        if (!$pharmacie || $pharmacie->statut !== 'acceptee') {
            return redirect()->route('pharmacie.en-attente');
        }

        $categories = Categorie::withCount('medicaments as total_medicaments')
            ->get()
            ->each(function ($cat) use ($pharmacie) {
                $cat->mes_medicaments = $pharmacie->medicaments()
                    ->where('categorie_id', $cat->id)->count();
            })
            ->sortBy('nom')
            ->values();

        return view('pharmacie.categories', compact('pharmacie', 'categories'));
    }

    public function storeCategorie(Request $request)
    {
        $pharmacie = $this->pharmacie();
        if (!$pharmacie || $pharmacie->statut !== 'acceptee') {
            return redirect()->route('pharmacie.en-attente');
        }

        $request->validate([
            'nom'         => ['required', 'string', 'max:100', 'unique:categories,nom'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        Categorie::create($request->only('nom', 'description'));

        return back()->with('cat_success', 'Catégorie "' . $request->nom . '" créée avec succès.');
    }

    public function updateCategorie(Request $request, Categorie $categorie)
    {
        $this->pharmacie(); // auth check handled by middleware

        $request->validate([
            'nom'         => ['required', 'string', 'max:100', 'unique:categories,nom,' . $categorie->id],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $categorie->update($request->only('nom', 'description'));

        return back()->with('cat_success', 'Catégorie mise à jour.');
    }

    public function destroyCategorie(Categorie $categorie)
    {
        if ($categorie->medicaments()->count() > 0) {
            return back()->with('cat_error', 'Impossible de supprimer : des médicaments sont liés à cette catégorie.');
        }

        $categorie->delete();

        return back()->with('cat_success', 'Catégorie supprimée.');
    }

    public function ordonnances()
    {
        $pharmacie = $this->pharmacie();
        if (!$pharmacie || $pharmacie->statut !== 'acceptee') {
            return redirect()->route('pharmacie.en-attente');
        }
        return view('pharmacie.ordonnances', compact('pharmacie'));
    }

    public function medicaments(Request $request)
    {
        $pharmacie = $this->pharmacie();
        if (!$pharmacie || $pharmacie->statut !== 'acceptee') {
            return redirect()->route('pharmacie.en-attente');
        }

        $query = $pharmacie->medicaments()->with('categorie');

        if ($request->filled('search')) {
            $query->where('nom', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('categorie')) {
            $query->where('categorie_id', $request->categorie);
        }
        if ($request->filled('stock_filter')) {
            match ($request->stock_filter) {
                'disponible' => $query->wherePivot('stock', '>', 10),
                'faible'     => $query->wherePivot('stock', '>', 0)->wherePivot('stock', '<=', 10),
                'rupture'    => $query->wherePivot('stock', 0),
                default      => null,
            };
        }

        $medicaments = $query->latest('medicament_pharmacie.created_at')->paginate(20);
        $categories  = Categorie::orderBy('nom')->get();

        $stats = [
            'disponibles'  => $pharmacie->medicaments()->wherePivot('stock', '>', 10)->count(),
            'stock_faible' => $pharmacie->medicaments()->wherePivot('stock', '>', 0)->wherePivot('stock', '<=', 10)->count(),
            'rupture'      => $pharmacie->medicaments()->wherePivot('stock', 0)->count(),
        ];

        return view('pharmacie.medicaments', compact('pharmacie', 'medicaments', 'categories', 'stats'));
    }

    public function storeMedicament(Request $request)
    {
        $pharmacie = $this->pharmacie();
        if (!$pharmacie || $pharmacie->statut !== 'acceptee') {
            return redirect()->route('pharmacie.en-attente');
        }

        $request->validate([
            'nom'                      => ['required', 'string', 'max:200'],
            'description'              => ['nullable', 'string'],
            'prix'                     => ['required', 'numeric', 'min:0'],
            'stock'                    => ['required', 'integer', 'min:0'],
            'categorie_id'             => ['nullable', 'integer', 'exists:categories,id'],
            'prescription_obligatoire' => ['nullable', 'boolean'],
        ]);

        // Trouver ou créer le médicament (catalogue partagé unique par nom)
        $medicament = Medicament::firstOrCreate(
            ['nom' => $request->nom],
            [
                'description'              => $request->description,
                'categorie_id'             => $request->categorie_id ?: null,
                'prescription_obligatoire' => $request->boolean('prescription_obligatoire'),
            ]
        );

        // Attacher ou mettre à jour le stock/prix pour cette pharmacie
        $pharmacie->medicaments()->syncWithoutDetaching([
            $medicament->id => [
                'stock' => $request->stock,
                'prix'  => $request->prix,
            ],
        ]);

        return back()->with('med_success', 'Médicament ajouté avec succès.');
    }

    public function updateMedicament(Request $request, Medicament $medicament)
    {
        $pharmacie = $this->pharmacie();
        abort_if(
            !$pharmacie->medicaments()->where('medicaments.id', $medicament->id)->exists(),
            403
        );

        $request->validate([
            'nom'                      => ['required', 'string', 'max:200', Rule::unique('medicaments', 'nom')->ignore($medicament->id)],
            'description'              => ['nullable', 'string'],
            'prix'                     => ['required', 'numeric', 'min:0'],
            'stock'                    => ['required', 'integer', 'min:0'],
            'categorie_id'             => ['nullable', 'integer', 'exists:categories,id'],
            'prescription_obligatoire' => ['nullable', 'boolean'],
        ]);

        // Mettre à jour les données du médicament (catalogue partagé)
        $medicament->update([
            'nom'                      => $request->nom,
            'description'              => $request->description,
            'categorie_id'             => $request->categorie_id ?: null,
            'prescription_obligatoire' => $request->boolean('prescription_obligatoire'),
        ]);

        // Mettre à jour stock et prix pour cette pharmacie uniquement
        $pharmacie->medicaments()->updateExistingPivot($medicament->id, [
            'stock' => $request->stock,
            'prix'  => $request->prix,
        ]);

        return back()->with('med_success', 'Médicament mis à jour avec succès.');
    }

    public function destroyMedicament(Medicament $medicament)
    {
        $pharmacie = $this->pharmacie();
        abort_if(
            !$pharmacie->medicaments()->where('medicaments.id', $medicament->id)->exists(),
            403
        );

        // Retirer le stock de cette pharmacie
        $pharmacie->medicaments()->detach($medicament->id);

        // Supprimer le médicament du catalogue seulement si aucune pharmacie ne le stocke
        if ($medicament->pharmacies()->count() === 0) {
            if ($medicament->image) Storage::disk('public')->delete($medicament->image);
            $medicament->delete();
        }

        return back()->with('med_success', 'Médicament retiré de votre catalogue.');
    }

    public function importerCatalogue(Request $request)
    {
        $pharmacie = $this->pharmacie();

        $request->validate([
            'fichier' => ['required', 'file', 'mimes:csv,txt,xlsx,xls', 'max:5120'],
        ]);

        $file      = $request->file('fichier');
        $extension = strtolower($file->getClientOriginalExtension());
        $path      = $file->store('imports', 'local');
        $fullPath  = Storage::disk('local')->path($path);

        if (in_array($extension, ['xlsx', 'xls']) && !class_exists('ZipArchive')) {
            Storage::disk('local')->delete($path);
            return back()->with('import_error', 'L\'import Excel nécessite l\'extension PHP "zip" (non activée sur ce serveur). Utilisez un fichier CSV à la place.');
        }

        $rows = $extension === 'csv' || $extension === 'txt'
            ? $this->readCsv($fullPath)
            : $this->readXlsx($fullPath);

        Storage::disk('local')->delete($path);

        if (empty($rows)) {
            return back()->with('import_error', 'Le fichier est vide ou illisible.');
        }

        $headers  = array_map('strtolower', array_map('trim', $rows[0]));
        $imported = 0;
        $skipped  = 0;
        $errors   = [];

        foreach (array_slice($rows, 1) as $lineNum => $row) {
            $data = array_combine($headers, array_pad($row, count($headers), ''));

            $nom  = trim($data['nom'] ?? '');
            $prix = trim($data['prix'] ?? '');

            if ($nom === '' || !is_numeric($prix)) {
                $skipped++;
                $errors[] = 'Ligne ' . ($lineNum + 2) . ' ignorée (nom ou prix manquant/invalide).';
                continue;
            }

            // Résolution catégorie par nom
            $categorieId = null;
            $catNom      = trim($data['categorie'] ?? $data['categorie_id'] ?? '');
            if ($catNom !== '') {
                if (is_numeric($catNom)) {
                    $categorieId = (int) $catNom;
                } else {
                    $cat         = Categorie::firstOrCreate(['nom' => $catNom]);
                    $categorieId = $cat->id;
                }
            }

            $prescription = in_array(
                strtolower(trim($data['prescription_obligatoire'] ?? '0')),
                ['1', 'oui', 'yes', 'true']
            );

            // Trouver ou créer le médicament (catalogue unique partagé)
            $medicament = Medicament::firstOrCreate(
                ['nom' => $nom],
                [
                    'description'              => trim($data['description'] ?? ''),
                    'categorie_id'             => $categorieId,
                    'prescription_obligatoire' => $prescription,
                ]
            );

            // Mettre à jour le stock et le prix pour cette pharmacie
            $pharmacie->medicaments()->syncWithoutDetaching([
                $medicament->id => [
                    'stock' => (int) ($data['stock'] ?? 0),
                    'prix'  => (float) $prix,
                ],
            ]);

            $imported++;
        }

        return back()
            ->with('import_success', "$imported médicament(s) importé(s) avec succès.")
            ->with('import_skipped', $skipped > 0 ? "$skipped ligne(s) ignorée(s)." : null)
            ->with('import_errors', $errors);
    }

    public function telechargerModele()
    {
        $csv = "nom,description,prix,stock,categorie,prescription_obligatoire\n";
        $csv .= "Paracétamol 500mg,Analgésique et antipyrétique,500,100,Analgésique,0\n";
        $csv .= "Amoxicilline 500mg,Antibiotique à large spectre,1200,50,Antibiotique,1\n";

        return response($csv, 200, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="modele_catalogue.csv"',
        ]);
    }

    public function parametres()
    {
        $pharmacie = $this->pharmacie();
        if (!$pharmacie || $pharmacie->statut !== 'acceptee') {
            return redirect()->route('pharmacie.en-attente');
        }
        return view('pharmacie.parametres', compact('pharmacie'));
    }

    public function updateParametres(Request $request)
    {
        $pharmacie = $this->pharmacie();
        $user      = Auth::user();

        $request->validate([
            'nom'             => ['required', 'string', 'max:150'],
            'adresse'         => ['required', 'string', 'max:255'],
            'telephone'       => ['nullable', 'string', 'max:20'],
            'numero_agrement' => ['nullable', 'string', 'max:100'],
            'logo'            => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'garde'           => ['nullable', 'boolean'],
            'name'            => ['required', 'string', 'max:150'],
            'password'        => ['nullable', 'confirmed', 'min:8'],
        ]);

        if ($request->hasFile('logo')) {
            if ($pharmacie->logo) Storage::disk('public')->delete($pharmacie->logo);
            $pharmacie->logo = $request->file('logo')->store('logos', 'public');
        }

        $pharmacie->update($request->only('nom', 'adresse', 'telephone', 'numero_agrement') + [
            'garde' => $request->boolean('garde'),
            'logo'  => $pharmacie->logo,
        ]);

        $user->update(['name' => $request->name]);
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return back()->with('success', 'Paramètres mis à jour avec succès.');
    }

    public function supprimerCompte(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        $user = Auth::user();

        if (!Hash::check($request->password, $user->password)) {
            return back()->withErrors(['delete_password' => 'Mot de passe incorrect.'])->withInput();
        }

        $pharmacie = $this->pharmacie();

        if ($pharmacie) {
            if ($pharmacie->logo) Storage::disk('public')->delete($pharmacie->logo);
            $pharmacie->delete();
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $user->delete();

        return redirect()->route('login')->with('status', 'Votre compte a été supprimé.');
    }

    // ── Readers ────────────────────────────────────────────────────

    private function readCsv(string $path): array
    {
        $rows   = [];
        $handle = fopen($path, 'r');
        if (!$handle) return [];

        // BOM UTF-8
        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") rewind($handle);

        while (($row = fgetcsv($handle, 0, ',')) !== false) {
            if ($row !== [null]) $rows[] = $row;
        }
        fclose($handle);

        // Fallback : essayer le point-virgule comme délimiteur
        if (count($rows) <= 1) {
            $rows   = [];
            $handle = fopen($path, 'r');
            $bom    = fread($handle, 3);
            if ($bom !== "\xEF\xBB\xBF") rewind($handle);
            while (($row = fgetcsv($handle, 0, ';')) !== false) {
                if ($row !== [null]) $rows[] = $row;
            }
            fclose($handle);
        }

        return $rows;
    }

    private function readXlsx(string $path): array
    {
        $zip = new \ZipArchive();
        if ($zip->open($path) !== true) return [];

        // Shared strings
        $sharedStrings = [];
        $ssRaw         = $zip->getFromName('xl/sharedStrings.xml');
        if ($ssRaw) {
            $ss = simplexml_load_string($ssRaw);
            foreach ($ss->si as $si) {
                if (isset($si->t)) {
                    $sharedStrings[] = (string) $si->t;
                } else {
                    $parts = [];
                    foreach ($si->r as $r) $parts[] = (string) $r->t;
                    $sharedStrings[] = implode('', $parts);
                }
            }
        }

        // Sheet data
        $sheetRaw = $zip->getFromName('xl/worksheets/sheet1.xml');
        $zip->close();
        if (!$sheetRaw) return [];

        $sheet = simplexml_load_string($sheetRaw);
        $rows  = [];

        foreach ($sheet->sheetData->row as $xmlRow) {
            $rowArr = [];
            $maxCol = 0;

            foreach ($xmlRow->c as $cell) {
                $colIndex = $this->colLetterToIndex((string) $cell['r']);
                $type     = (string) ($cell['t'] ?? '');
                $value    = isset($cell->v) ? (string) $cell->v : '';

                if ($type === 's') $value = $sharedStrings[(int) $value] ?? '';
                if ($type === 'inlineStr') $value = (string) ($cell->is->t ?? '');

                $rowArr[$colIndex] = $value;
                $maxCol            = max($maxCol, $colIndex);
            }

            // Fill gaps
            $filled = [];
            for ($i = 0; $i <= $maxCol; $i++) {
                $filled[] = $rowArr[$i] ?? '';
            }
            $rows[] = $filled;
        }

        return $rows;
    }

    private function colLetterToIndex(string $cellRef): int
    {
        preg_match('/^([A-Z]+)/', $cellRef, $m);
        $letters = $m[1] ?? 'A';
        $index   = 0;
        foreach (str_split($letters) as $char) {
            $index = $index * 26 + (ord($char) - ord('A') + 1);
        }
        return $index - 1;
    }
}
