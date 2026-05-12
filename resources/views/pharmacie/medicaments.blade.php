<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <title>PharmaNet — Médicaments</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
  @include('pharmacie._styles')
  <style>
    /* ── Tableau ───────────────────────────────────────────── */
    .table-med { width:100%; border-collapse:collapse; font-size:.875rem; }
    .table-med thead th {
      color:#6b7280; font-size:.72rem; font-weight:700;
      text-transform:uppercase; letter-spacing:.06em;
      padding:.75rem 1rem; background:#fafafa;
      border-bottom:1px solid #f0f0f0; white-space:nowrap;
    }
    .table-med thead th:first-child { padding-left:1.25rem; border-radius:.5rem 0 0 0; }
    .table-med thead th:last-child  { padding-right:1.25rem; border-radius:0 .5rem 0 0; }
    .table-med tbody td { padding:.85rem 1rem; border-bottom:1px solid #f5f5f5; color:#374151; vertical-align:middle; }
    .table-med tbody td:first-child { padding-left:1.25rem; }
    .table-med tbody td:last-child  { padding-right:1.25rem; }
    .table-med tbody tr:last-child td { border-bottom:none; }
    .table-med tbody tr { transition:background .1s; }
    .table-med tbody tr:hover td { background:#f9fffe; }

    /* ── Badges stock ──────────────────────────────────────── */
    .stock-pill { display:inline-flex; align-items:center; gap:.3rem; padding:.22rem .7rem; border-radius:9999px; font-size:.75rem; font-weight:600; white-space:nowrap; }
    .stock-ok   { background:#f0fdf4; color:#16a34a; border:1px solid #bbf7d0; }
    .stock-low  { background:#fff7ed; color:#ea580c; border:1px solid #fed7aa; }
    .stock-zero { background:#fef2f2; color:#dc2626; border:1px solid #fecaca; }

    /* ── Rx badge ──────────────────────────────────────────── */
    .rx-badge { display:inline-flex; align-items:center; gap:.2rem; background:#eff4ff; color:#2563eb; border:1px solid #bfdbfe; border-radius:.35rem; padding:.15rem .5rem; font-size:.68rem; font-weight:700; }

    /* ── Catégorie tag ─────────────────────────────────────── */
    .cat-tag { display:inline-block; background:#f3f4f6; color:#6b7280; border-radius:.35rem; padding:.15rem .5rem; font-size:.75rem; font-weight:500; }

    /* ── Avatar médicament ─────────────────────────────────── */
    .med-avatar { width:38px; height:38px; border-radius:.55rem; background:linear-gradient(135deg,#f0fdf4,#dcfce7); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .med-avatar img { width:100%; height:100%; object-fit:cover; border-radius:.55rem; }

    /* ── Boutons action ────────────────────────────────────── */
    .action-btn { width:30px; height:30px; border-radius:.45rem; border:1px solid #e9ecef; background:#fff; display:inline-flex; align-items:center; justify-content:center; cursor:pointer; font-size:.85rem; color:#6b7280; transition:all .15s; }
    .action-btn.edit:hover { background:#eff4ff; border-color:#bfdbfe; color:#2563eb; }
    .action-btn.del:hover  { background:#fef2f2; border-color:#fecaca; color:#dc2626; }

    /* ── Pagination ────────────────────────────────────────── */
    .page-btn {
      display:inline-flex; align-items:center; justify-content:center;
      width:34px; height:34px; border-radius:.5rem;
      border:1.5px solid #e9ecef; background:#fff;
      color:#374151; font-size:.82rem; font-weight:600;
      text-decoration:none; transition:all .15s; cursor:pointer;
    }
    .page-btn:hover:not(.disabled):not(.active) { border-color:#7ed957; color:#5ab832; background:#f2ffe8; }
    .page-btn.active { background:#5ab832; border-color:#5ab832; color:#fff; }
    .page-btn.disabled { opacity:.4; cursor:default; pointer-events:none; }

    /* ── Barre de recherche ────────────────────────────────── */
    .filter-bar { background:#fff; border:1.5px solid #e9ecef; border-radius:.75rem; padding:.6rem 1rem; display:flex; align-items:center; flex-wrap:wrap; gap:.75rem; }
    .filter-input-wrap { position:relative; flex:1; min-width:180px; }
    .filter-input-wrap i { position:absolute; left:.7rem; top:50%; transform:translateY(-50%); color:#9ca3af; font-size:1rem; pointer-events:none; }
    .filter-input-wrap input { width:100%; border:1.5px solid #e9ecef; border-radius:.55rem; padding:.45rem .75rem .45rem 2.1rem; font-size:.875rem; outline:none; transition:border-color .15s; background:#fafafa; }
    .filter-input-wrap input:focus { border-color:#7ed957; background:#fff; }
    .filter-select { border:1.5px solid #e9ecef; border-radius:.55rem; padding:.45rem .75rem; font-size:.875rem; outline:none; background:#fafafa; color:#374151; transition:border-color .15s; cursor:pointer; }
    .filter-select:focus { border-color:#7ed957; background:#fff; }
  </style>
</head>
<body>

@include('pharmacie._sidebar', ['active' => 'medicaments'])
@include('pharmacie._topbar', ['pageTitle' => 'Médicaments'])

<main class="main-content">

  {{-- Alertes --}}
  @if(session('med_success'))
    <div class="alert-success-ph"><i class="ti ti-circle-check"></i> {{ session('med_success') }}</div>
  @endif
  @if(session('import_success'))
    <div class="alert-success-ph">
      <i class="ti ti-circle-check"></i> {{ session('import_success') }}
      @if(session('import_skipped'))<br><span style="font-size:.8rem;">{{ session('import_skipped') }}</span>@endif
    </div>
  @endif
  @if(session('import_error'))
    <div class="alert-error-ph"><i class="ti ti-alert-circle"></i> {{ session('import_error') }}</div>
  @endif
  @if(session('import_errors'))
    <div class="alert-error-ph d-block">
      <div class="d-flex align-items-center gap-2 mb-1"><i class="ti ti-alert-circle"></i><strong>Lignes ignorées :</strong></div>
      <ul class="mb-0 ps-4" style="font-size:.8rem;">
        @foreach(array_slice(session('import_errors'), 0, 5) as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
  @endif

  {{-- En-tête --}}
  <div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-3">
    <div>
      <h4 class="fw-bold mb-1">Catalogue de médicaments</h4>
      <p class="text-muted small mb-0">Gérez les médicaments disponibles dans votre pharmacie.</p>
    </div>
    <div class="d-flex gap-2 flex-wrap">
      <a href="{{ route('pharmacie.medicaments.modele') }}" class="btn-outline-green">
        <i class="ti ti-download"></i> Modèle CSV
      </a>
      <button class="btn-outline-green" data-bs-toggle="modal" data-bs-target="#importModal">
        <i class="ti ti-file-upload"></i> Importer
      </button>
      <button class="btn-green" data-bs-toggle="modal" data-bs-target="#addMedModal">
        <i class="ti ti-plus"></i> Ajouter
      </button>
    </div>
  </div>

  {{-- Stats rapides --}}
  <div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:#f2ffe8;"><i class="ti ti-pill" style="color:#5ab832;"></i></div>
        <div><p class="stat-label">Total</p><h3 class="stat-value">{{ $medicaments->total() }}</h3></div>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:#f0fdf4;"><i class="ti ti-circle-check" style="color:#16a34a;"></i></div>
        <div><p class="stat-label">Disponibles</p><h3 class="stat-value">{{ $stats['disponibles'] }}</h3></div>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:#fff7ed;"><i class="ti ti-alert-triangle" style="color:#ea580c;"></i></div>
        <div><p class="stat-label">Stock faible</p><h3 class="stat-value">{{ $stats['stock_faible'] }}</h3></div>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:#fef2f2;"><i class="ti ti-alert-circle" style="color:#dc2626;"></i></div>
        <div><p class="stat-label">En rupture</p><h3 class="stat-value">{{ $stats['rupture'] }}</h3></div>
      </div>
    </div>
  </div>

  {{-- Filtres --}}
  <div class="filter-bar mb-3">
    <form method="GET" class="d-flex align-items-center flex-wrap gap-2 w-100">
      <div class="filter-input-wrap">
        <i class="ti ti-search"></i>
        <input type="text" name="search" placeholder="Rechercher un médicament…" value="{{ request('search') }}"
          onchange="this.form.submit()">
      </div>
      <select name="categorie" class="filter-select" onchange="this.form.submit()">
        <option value="">Toutes les catégories</option>
        @foreach($categories as $cat)
          <option value="{{ $cat->id }}" {{ request('categorie') == $cat->id ? 'selected' : '' }}>{{ $cat->nom }}</option>
        @endforeach
      </select>
      <select name="stock_filter" class="filter-select" onchange="this.form.submit()">
        <option value="">Tous les stocks</option>
        <option value="disponible" {{ request('stock_filter') === 'disponible' ? 'selected' : '' }}>Disponible</option>
        <option value="faible"     {{ request('stock_filter') === 'faible'     ? 'selected' : '' }}>Stock faible</option>
        <option value="rupture"    {{ request('stock_filter') === 'rupture'    ? 'selected' : '' }}>Rupture</option>
      </select>
      @if(request('search') || request('categorie') || request('stock_filter'))
        <a href="{{ route('pharmacie.medicaments') }}" class="btn-outline-green" style="font-size:.82rem;padding:.4rem .85rem;">
          <i class="ti ti-x"></i> Effacer
        </a>
      @endif
    </form>
  </div>

  {{-- Tableau --}}
  <div class="card-white" style="padding:0;overflow:hidden;">
    @if($medicaments->count())

    <div style="overflow-x:auto;">
      <table class="table-med">
        <thead>
          <tr>
            <th>Médicament</th>
            <th>Catégorie</th>
            <th>Prix</th>
            <th>Stock</th>
            <th>Ordonnance</th>
            <th style="text-align:right;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($medicaments as $med)
          <tr>
            <td>
              <div class="d-flex align-items-center gap-2">
                <div class="med-avatar">
                  @if($med->image)
                    <img src="{{ Storage::url($med->image) }}" alt="{{ $med->nom }}">
                  @else
                    <i class="ti ti-pill" style="color:#7ed957;font-size:1rem;"></i>
                  @endif
                </div>
                <div style="min-width:0;">
                  <div class="fw-semibold" style="font-size:.875rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:200px;">
                    {{ $med->nom }}
                  </div>
                  @if($med->description)
                    <div class="text-muted" style="font-size:.75rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:200px;">
                      {{ $med->description }}
                    </div>
                  @endif
                </div>
              </div>
            </td>
            <td>
              @if($med->categorie)
                <span class="cat-tag">{{ $med->categorie->nom }}</span>
              @else
                <span style="color:#d1d5db;">—</span>
              @endif
            </td>
            <td class="fw-semibold" style="color:#5ab832;white-space:nowrap;">
              {{ number_format($med->pivot->prix, 0, ',', ' ') }} <span style="font-size:.75rem;font-weight:400;color:#9ca3af;">FCFA</span>
            </td>
            <td>
              @if($med->pivot->stock === 0)
                <span class="stock-pill stock-zero"><i class="ti ti-ban" style="font-size:.8rem;"></i> Rupture</span>
              @elseif($med->pivot->stock <= 10)
                <span class="stock-pill stock-low"><i class="ti ti-alert-triangle" style="font-size:.8rem;"></i> {{ $med->pivot->stock }} unités</span>
              @else
                <span class="stock-pill stock-ok"><i class="ti ti-check" style="font-size:.8rem;"></i> {{ $med->pivot->stock }} unités</span>
              @endif
            </td>
            <td>
              @if($med->prescription_obligatoire)
                <span class="rx-badge"><i class="ti ti-prescription" style="font-size:.8rem;"></i> Requise</span>
              @else
                <span style="color:#9ca3af;font-size:.8rem;">Libre</span>
              @endif
            </td>
            <td style="text-align:right;">
              <div class="d-flex gap-1 justify-content-end">
                <button class="action-btn edit"
                  onclick="openEdit({{ $med->id }}, {{ json_encode($med->nom) }}, {{ json_encode($med->description ?? '') }}, {{ $med->pivot->prix }}, {{ $med->pivot->stock }}, {{ $med->categorie_id ?? 'null' }}, {{ $med->prescription_obligatoire ? 'true' : 'false' }})"
                  title="Modifier">
                  <i class="ti ti-edit"></i>
                </button>
                <button class="action-btn del"
                  onclick="confirmDelete({{ $med->id }}, {{ json_encode($med->nom) }})"
                  title="Supprimer">
                  <i class="ti ti-trash"></i>
                </button>
              </div>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    {{ $medicaments->withQueryString()->links('pharmacie._pagination') }}

    @else
    <div style="padding:4.5rem 0;text-align:center;color:#9ca3af;">
      <div style="width:64px;height:64px;background:#f3f4f6;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto .85rem;">
        <i class="ti ti-pill" style="font-size:1.8rem;color:#d1d5db;"></i>
      </div>
      <p class="fw-semibold mb-1" style="color:#374151;">Aucun médicament trouvé</p>
      <p class="small mb-3">
        @if(request('search') || request('categorie') || request('stock_filter'))
          Aucun résultat pour ces filtres.
          <a href="{{ route('pharmacie.medicaments') }}" style="color:#5ab832;">Réinitialiser</a>
        @else
          Ajoutez des médicaments manuellement ou importez votre catalogue.
        @endif
      </p>
      @if(!request('search') && !request('categorie') && !request('stock_filter'))
      <div class="d-flex gap-2 justify-content-center">
        <button class="btn-outline-green" data-bs-toggle="modal" data-bs-target="#importModal">
          <i class="ti ti-file-upload"></i> Importer catalogue
        </button>
        <button class="btn-green" data-bs-toggle="modal" data-bs-target="#addMedModal">
          <i class="ti ti-plus"></i> Ajouter
        </button>
      </div>
      @endif
    </div>
    @endif
  </div>

</main>

<!-- ═══ Modal Import ════════════════════════════════════════════ -->
<div class="modal fade" id="importModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" style="max-width:500px;">
    <div class="modal-content" style="border-radius:1rem;border:none;">
      <div class="modal-body p-4">
        <h5 class="fw-bold mb-1">Importer votre catalogue</h5>
        <p class="text-muted small mb-3">Importez vos médicaments depuis un fichier CSV ou Excel (.xlsx).</p>
        <div class="alert-info-ph mb-3" style="font-size:.8rem;">
          <i class="ti ti-info-circle" style="flex-shrink:0;"></i>
          <div>
            <strong>Colonnes attendues :</strong><br>
            <code style="font-size:.75rem;">nom, description, prix, stock, categorie, prescription_obligatoire</code><br>
            <a href="{{ route('pharmacie.medicaments.modele') }}" style="color:#2563eb;">Télécharger le modèle CSV →</a>
          </div>
        </div>
        <form method="POST" action="{{ route('pharmacie.medicaments.importer') }}" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <div style="border:2px dashed #d1d5db;border-radius:.75rem;padding:1.5rem;text-align:center;cursor:pointer;position:relative;transition:border-color .2s;" id="dropZone">
              <input type="file" name="fichier" accept=".csv,.xlsx,.xls,.txt" required
                style="position:absolute;inset:0;opacity:0;cursor:pointer;" onchange="updateFileName(this)">
              <i class="ti ti-file-upload" style="font-size:2rem;color:#9ca3af;display:block;margin-bottom:.5rem;" id="uploadIcon"></i>
              <p class="mb-0 text-muted small" id="uploadText">Glissez votre fichier ici ou cliquez<br>
                <span style="font-size:.72rem;">CSV, XLSX — max 5 Mo</span></p>
            </div>
          </div>
          <div class="d-flex gap-2 justify-content-end">
            <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn-green px-4"><i class="ti ti-upload"></i> Importer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ═══ Modal Ajouter ══════════════════════════════════════════ -->
<div class="modal fade" id="addMedModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" style="max-width:520px;">
    <div class="modal-content" style="border-radius:1rem;border:none;">
      <div class="modal-body p-4">
        <h5 class="fw-bold mb-3">Ajouter un médicament</h5>
        <form method="POST" action="{{ route('pharmacie.medicaments.store') }}">
          @csrf
          <div class="row g-2">
            <div class="col-12">
              <label class="form-label">Nom <span style="color:#dc2626;">*</span></label>
              <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror"
                placeholder="Paracétamol 500mg" value="{{ old('nom') }}" required>
              @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
              <label class="form-label">Description</label>
              <textarea name="description" class="form-control" rows="2" placeholder="Description courte…">{{ old('description') }}</textarea>
            </div>
            <div class="col-6">
              <label class="form-label">Prix (FCFA) <span style="color:#dc2626;">*</span></label>
              <input type="number" name="prix" class="form-control @error('prix') is-invalid @enderror"
                placeholder="500" min="0" step="0.01" value="{{ old('prix') }}" required>
              @error('prix')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-6">
              <label class="form-label">Stock <span style="color:#dc2626;">*</span></label>
              <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                placeholder="100" min="0" value="{{ old('stock') }}" required>
              @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
              <label class="form-label">Catégorie</label>
              <select name="categorie_id" class="form-select">
                <option value="">— Choisir —</option>
                @foreach($categories as $cat)
                  <option value="{{ $cat->id }}" {{ old('categorie_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nom }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-12">
              <div class="d-flex align-items-center justify-content-between" style="background:#f9fafb;border:1.5px solid #e5e7eb;border-radius:.65rem;padding:.75rem 1rem;">
                <div>
                  <div class="fw-semibold" style="font-size:.875rem;">Prescription obligatoire</div>
                  <div class="text-muted" style="font-size:.78rem;">Ce médicament nécessite une ordonnance</div>
                </div>
                <div class="form-check form-switch ms-3">
                  <input class="form-check-input" type="checkbox" name="prescription_obligatoire" value="1"
                    style="width:2.2rem;height:1.2rem;cursor:pointer;" {{ old('prescription_obligatoire') ? 'checked' : '' }}>
                </div>
              </div>
            </div>
          </div>
          <div class="d-flex gap-2 justify-content-end mt-3">
            <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn-green px-4"><i class="ti ti-plus"></i> Ajouter</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ═══ Modal Modifier ═════════════════════════════════════════ -->
<div class="modal fade" id="editMedModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" style="max-width:520px;">
    <div class="modal-content" style="border-radius:1rem;border:none;">
      <div class="modal-body p-4">
        <h5 class="fw-bold mb-3">Modifier le médicament</h5>
        <form method="POST" id="editMedForm">
          @csrf @method('PUT')
          <div class="row g-2">
            <div class="col-12">
              <label class="form-label">Nom <span style="color:#dc2626;">*</span></label>
              <input type="text" name="nom" id="editNom" class="form-control" required>
            </div>
            <div class="col-12">
              <label class="form-label">Description</label>
              <textarea name="description" id="editDesc" class="form-control" rows="2"></textarea>
            </div>
            <div class="col-6">
              <label class="form-label">Prix (FCFA) <span style="color:#dc2626;">*</span></label>
              <input type="number" name="prix" id="editPrix" class="form-control" min="0" step="0.01" required>
            </div>
            <div class="col-6">
              <label class="form-label">Stock <span style="color:#dc2626;">*</span></label>
              <input type="number" name="stock" id="editStock" class="form-control" min="0" required>
            </div>
            <div class="col-12">
              <label class="form-label">Catégorie</label>
              <select name="categorie_id" id="editCategorie" class="form-select">
                <option value="">— Choisir —</option>
                @foreach($categories as $cat)
                  <option value="{{ $cat->id }}">{{ $cat->nom }}</option>
                @endforeach
              </select>
            </div>
            <div class="col-12">
              <div class="d-flex align-items-center justify-content-between" style="background:#f9fafb;border:1.5px solid #e5e7eb;border-radius:.65rem;padding:.75rem 1rem;">
                <div>
                  <div class="fw-semibold" style="font-size:.875rem;">Prescription obligatoire</div>
                  <div class="text-muted" style="font-size:.78rem;">Ce médicament nécessite une ordonnance</div>
                </div>
                <div class="form-check form-switch ms-3">
                  <input class="form-check-input" type="checkbox" name="prescription_obligatoire" id="editRx" value="1"
                    style="width:2.2rem;height:1.2rem;cursor:pointer;">
                </div>
              </div>
            </div>
          </div>
          <div class="d-flex gap-2 justify-content-end mt-3">
            <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn-green px-4"><i class="ti ti-device-floppy"></i> Enregistrer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ═══ Modal Supprimer ════════════════════════════════════════ -->
<div class="modal fade" id="deleteMedModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" style="max-width:400px;">
    <div class="modal-content" style="border-radius:1rem;border:none;">
      <div class="modal-body p-4 text-center">
        <div style="width:52px;height:52px;background:#fef2f2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto .75rem;">
          <i class="ti ti-trash" style="font-size:1.4rem;color:#dc2626;"></i>
        </div>
        <h5 class="fw-bold mb-1">Supprimer ce médicament ?</h5>
        <p class="text-muted small mb-1" id="deleteModalName" style="font-weight:600;"></p>
        <p class="text-muted" style="font-size:.8rem;">Cette action est irréversible.</p>
        <form method="POST" id="deleteMedForm">
          @csrf @method('DELETE')
          <div class="d-flex gap-2 justify-content-center">
            <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-danger px-4 fw-semibold">Supprimer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function updateFileName(input) {
  if (input.files && input.files[0]) {
    document.getElementById('uploadIcon').className = 'ti ti-file-check';
    document.getElementById('uploadIcon').style.color = '#7ed957';
    document.getElementById('uploadText').innerHTML =
      '<strong>' + input.files[0].name + '</strong><br>' +
      '<span style="font-size:.72rem;color:#9ca3af;">' + (input.files[0].size / 1024).toFixed(1) + ' Ko</span>';
  }
}
const dz = document.getElementById('dropZone');
dz.addEventListener('dragover',  e => { e.preventDefault(); dz.style.borderColor='#7ed957'; dz.style.background='#f0fdf4'; });
dz.addEventListener('dragleave', () => { dz.style.borderColor=''; dz.style.background=''; });
dz.addEventListener('drop',      () => { dz.style.borderColor=''; dz.style.background=''; });

function openEdit(id, nom, desc, prix, stock, categorieId, rx) {
  document.getElementById('editMedForm').action = '/pharmacie/medicaments/' + id;
  document.getElementById('editNom').value   = nom;
  document.getElementById('editDesc').value  = desc;
  document.getElementById('editPrix').value  = prix;
  document.getElementById('editStock').value = stock;
  document.getElementById('editRx').checked  = rx;
  const sel = document.getElementById('editCategorie');
  for (let opt of sel.options) opt.selected = (opt.value == categorieId);
  new bootstrap.Modal(document.getElementById('editMedModal')).show();
}

function confirmDelete(id, nom) {
  document.getElementById('deleteMedForm').action = '/pharmacie/medicaments/' + id;
  document.getElementById('deleteModalName').textContent = nom;
  new bootstrap.Modal(document.getElementById('deleteMedModal')).show();
}

@if(session('import_error') || session('import_errors'))
  document.addEventListener('DOMContentLoaded', () => new bootstrap.Modal(document.getElementById('importModal')).show());
@endif
@if($errors->any() && old('nom') !== null)
  document.addEventListener('DOMContentLoaded', () => new bootstrap.Modal(document.getElementById('addMedModal')).show());
@endif
</script>
</body>
</html>
