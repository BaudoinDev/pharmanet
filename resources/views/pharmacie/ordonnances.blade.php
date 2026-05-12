<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <title>PharmaNet — Ordonnances</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
  @include('pharmacie._styles')
</head>
<body>

@include('pharmacie._sidebar', ['active' => 'ordonnances'])
@include('pharmacie._topbar', ['pageTitle' => 'Ordonnances'])

<main class="main-content">

  <div class="mb-4">
    <h4 class="fw-bold mb-1">Ordonnances reçues</h4>
    <p class="text-muted small mb-0">Consultez et validez les ordonnances médicales de vos clients.</p>
  </div>

  <div class="alert-info-ph">
    <i class="ti ti-info-circle" style="font-size:1.1rem;flex-shrink:0;margin-top:.05rem;"></i>
    <div>

      Les ordonnances soumises par les clients via l'application apparaîtront ici. Vous pourrez les valider, les rejeter ou demander des informations complémentaires.
    </div>
  </div>

  <!-- Stats placeholders -->
  <div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:#f2ffe8;"><i class="ti ti-file-description" style="color:#5ab832;"></i></div>
        <div><p class="stat-label">Total reçues</p><h3 class="stat-value">0</h3></div>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:#fff7ed;"><i class="ti ti-clock" style="color:#ea580c;"></i></div>
        <div><p class="stat-label">En attente</p><h3 class="stat-value">0</h3></div>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:#f0fdf4;"><i class="ti ti-circle-check" style="color:#16a34a;"></i></div>
        <div><p class="stat-label">Validées</p><h3 class="stat-value">0</h3></div>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:#fef2f2;"><i class="ti ti-circle-x" style="color:#dc2626;"></i></div>
        <div><p class="stat-label">Rejetées</p><h3 class="stat-value">0</h3></div>
      </div>
    </div>
  </div>

  <div class="card-white">
    <div class="d-flex align-items-center justify-content-between mb-4">
      <h6 class="fw-bold mb-0">Liste des ordonnances</h6>
      <div class="filter-tabs">
        <button class="filter-tab active">Toutes</button>
        <button class="filter-tab">En attente</button>
        <button class="filter-tab">Validées</button>
        <button class="filter-tab">Rejetées</button>
      </div>
    </div>

    <div style="padding:4rem 0;text-align:center;color:#9ca3af;">
      <i class="ti ti-file-description" style="font-size:3rem;display:block;margin-bottom:.75rem;"></i>
      <p class="fw-medium mb-1">Aucune ordonnance pour l'instant</p>
      <p class="small">Les ordonnances soumises par vos clients apparaîtront ici.</p>
    </div>
  </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
