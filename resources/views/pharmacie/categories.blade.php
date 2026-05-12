<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <title>PharmaNet — Catégories</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
  @include('pharmacie._styles')
  <style>
    .cat-row { display:flex; align-items:center; gap:1rem; padding:.85rem 1rem; border:1.5px solid #f0f0f0; border-radius:.75rem; background:#fff; transition:box-shadow .15s; }
    .cat-row:hover { box-shadow:0 3px 12px rgba(0,0,0,.07); border-color:#e5e7eb; }
    .cat-icon { width:40px; height:40px; border-radius:.55rem; background:linear-gradient(135deg,#f0fdf4,#dcfce7); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
    .cat-actions { margin-left:auto; display:flex; gap:.4rem; flex-shrink:0; }
    .cat-btn { width:32px; height:32px; border-radius:.45rem; border:1px solid #e5e7eb; background:#fff; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:.9rem; transition:all .15s; }
    .cat-btn.edit:hover { background:#eff4ff; border-color:#bfdbfe; color:#2563eb; }
    .cat-btn.del:hover  { background:#fef2f2; border-color:#fecaca; color:#dc2626; }
    .count-badge { display:inline-flex; align-items:center; gap:.3rem; background:#f2ffe8; color:#5ab832; border:1px solid #bbf7d0; border-radius:2rem; padding:.15rem .65rem; font-size:.75rem; font-weight:700; white-space:nowrap; }
    .count-badge.zero { background:#f9fafb; color:#9ca3af; border-color:#e5e7eb; }
  </style>
</head>
<body>

@include('pharmacie._sidebar', ['active' => 'categories'])
@include('pharmacie._topbar', ['pageTitle' => 'Catégories'])

<main class="main-content">

  @if(session('cat_success'))
    <div class="alert-success-ph"><i class="ti ti-circle-check"></i> {{ session('cat_success') }}</div>
  @endif
  @if(session('cat_error'))
    <div class="alert-error-ph"><i class="ti ti-alert-circle"></i> {{ session('cat_error') }}</div>
  @endif

  <div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-3">
    <div>
      <h4 class="fw-bold mb-1">Catégories de médicaments</h4>
      <p class="text-muted small mb-0">{{ $categories->count() }} catégorie(s) au total.</p>
    </div>
    <button class="btn-green" data-bs-toggle="modal" data-bs-target="#addCatModal">
      <i class="ti ti-plus"></i> Nouvelle catégorie
    </button>
  </div>

  <!-- Stats rapides -->
  <div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:#f2ffe8;"><i class="ti ti-tag" style="color:#5ab832;"></i></div>
        <div><p class="stat-label">Total catégories</p><h3 class="stat-value">{{ $categories->count() }}</h3></div>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:#eff6ff;"><i class="ti ti-pill" style="color:#2563eb;"></i></div>
        <div><p class="stat-label">Mes médicaments</p><h3 class="stat-value">{{ $categories->sum('mes_medicaments') }}</h3></div>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:#f0fdf4;"><i class="ti ti-check" style="color:#16a34a;"></i></div>
        <div><p class="stat-label">Catégories utilisées</p><h3 class="stat-value">{{ $categories->where('mes_medicaments', '>', 0)->count() }}</h3></div>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:#fdf4ff;"><i class="ti ti-tag-off" style="color:#9333ea;"></i></div>
        <div><p class="stat-label">Non utilisées</p><h3 class="stat-value">{{ $categories->where('mes_medicaments', 0)->count() }}</h3></div>
      </div>
    </div>
  </div>

  <div class="card-white">
    <div class="d-flex align-items-center justify-content-between mb-3">
      <h6 class="fw-bold mb-0">Liste des catégories</h6>
      <span class="text-muted" style="font-size:.8rem;">{{ $categories->count() }} entrée(s)</span>
    </div>

    @if($categories->count())
    <div class="d-flex flex-column gap-2">
      @foreach($categories as $cat)
      <div class="cat-row">
        <div class="cat-icon">
          <i class="ti ti-tag" style="color:#5ab832;font-size:1.1rem;"></i>
        </div>
        <div style="min-width:0;flex:1;">
          <div class="fw-semibold" style="font-size:.9rem;">{{ $cat->nom }}</div>
          @if($cat->description)
            <div class="text-muted" style="font-size:.78rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:340px;">{{ $cat->description }}</div>
          @endif
        </div>
        <span class="count-badge {{ $cat->mes_medicaments == 0 ? 'zero' : '' }}">
          <i class="ti ti-pill"></i>
          {{ $cat->mes_medicaments }} médicament{{ $cat->mes_medicaments > 1 ? 's' : '' }}
        </span>
        <div class="cat-actions">
          <button class="cat-btn edit"
            onclick="openEditCat({{ $cat->id }}, {{ json_encode($cat->nom) }}, {{ json_encode($cat->description ?? '') }})"
            title="Modifier"><i class="ti ti-edit"></i></button>
          <button class="cat-btn del"
            onclick="confirmDeleteCat({{ $cat->id }}, {{ json_encode($cat->nom) }}, {{ $cat->total_medicaments }})"
            title="Supprimer"><i class="ti ti-trash"></i></button>
        </div>
      </div>
      @endforeach
    </div>
    @else
    <div style="padding:3.5rem 0;text-align:center;color:#9ca3af;">
      <i class="ti ti-tag" style="font-size:3rem;display:block;margin-bottom:.75rem;"></i>
      <p class="fw-medium mb-1">Aucune catégorie pour l'instant</p>
      <p class="small mb-3">Créez des catégories pour organiser votre catalogue de médicaments.</p>
      <button class="btn-green" data-bs-toggle="modal" data-bs-target="#addCatModal">
        <i class="ti ti-plus"></i> Créer une catégorie
      </button>
    </div>
    @endif
  </div>

</main>

<!-- ═══ Modal Ajouter catégorie ══════════════════════════════ -->
<div class="modal fade" id="addCatModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" style="max-width:460px;">
    <div class="modal-content" style="border-radius:1rem;border:none;">
      <div class="modal-body p-4">
        <h5 class="fw-bold mb-3">Nouvelle catégorie</h5>
        <form method="POST" action="{{ route('pharmacie.categories.store') }}">
          @csrf
          <div class="mb-3">
            <label class="form-label">Nom <span style="color:#dc2626;">*</span></label>
            <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror"
              placeholder="Ex : Analgésique, Antibiotique…" value="{{ old('nom') }}" required>
            @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="2"
              placeholder="Description courte (optionnel)">{{ old('description') }}</textarea>
          </div>
          <div class="d-flex gap-2 justify-content-end">
            <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn-green px-4"><i class="ti ti-plus"></i> Créer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ═══ Modal Modifier catégorie ══════════════════════════════ -->
<div class="modal fade" id="editCatModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" style="max-width:460px;">
    <div class="modal-content" style="border-radius:1rem;border:none;">
      <div class="modal-body p-4">
        <h5 class="fw-bold mb-3">Modifier la catégorie</h5>
        <form method="POST" id="editCatForm">
          @csrf
          @method('PUT')
          <div class="mb-3">
            <label class="form-label">Nom <span style="color:#dc2626;">*</span></label>
            <input type="text" name="nom" id="editCatNom" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" id="editCatDesc" class="form-control" rows="2"></textarea>
          </div>
          <div class="d-flex gap-2 justify-content-end">
            <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn-green px-4"><i class="ti ti-device-floppy"></i> Enregistrer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- ═══ Modal Supprimer catégorie ════════════════════════════ -->
<div class="modal fade" id="deleteCatModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
    <div class="modal-content" style="border-radius:1rem;border:none;">
      <div class="modal-body p-4 text-center">
        <div style="width:52px;height:52px;background:#fef2f2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto .85rem;">
          <i class="ti ti-trash" style="font-size:1.4rem;color:#dc2626;"></i>
        </div>
        <h5 class="fw-bold mb-1">Supprimer cette catégorie ?</h5>
        <p class="text-muted small mb-1" id="deleteCatName" style="font-weight:600;"></p>
        <p class="text-muted small mb-3" id="deleteCatWarning"></p>
        <form method="POST" id="deleteCatForm">
          @csrf
          @method('DELETE')
          <div class="d-flex gap-2 justify-content-center">
            <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" id="deleteCatBtn" class="btn btn-danger px-4">Supprimer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function openEditCat(id, nom, desc) {
  document.getElementById('editCatForm').action = '/pharmacie/categories/' + id;
  document.getElementById('editCatNom').value  = nom;
  document.getElementById('editCatDesc').value = desc;
  new bootstrap.Modal(document.getElementById('editCatModal')).show();
}

function confirmDeleteCat(id, nom, total) {
  document.getElementById('deleteCatForm').action = '/pharmacie/categories/' + id;
  document.getElementById('deleteCatName').textContent = nom;
  const btn = document.getElementById('deleteCatBtn');
  if (total > 0) {
    document.getElementById('deleteCatWarning').textContent =
      total + ' médicament(s) sont liés à cette catégorie — suppression impossible.';
    btn.disabled = true;
  } else {
    document.getElementById('deleteCatWarning').textContent = 'Cette action est irréversible.';
    btn.disabled = false;
  }
  new bootstrap.Modal(document.getElementById('deleteCatModal')).show();
}

@if($errors->any() && old('nom') !== null)
document.addEventListener('DOMContentLoaded', () => {
  new bootstrap.Modal(document.getElementById('addCatModal')).show();
});
@endif
</script>
</body>
</html>
