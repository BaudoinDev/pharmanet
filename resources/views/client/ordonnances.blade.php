<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <title>PharmaNet — Mes Ordonnances</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
  @include('client._styles')
  <style>
    .upload-zone {
      border: 2px dashed #d1fae5; border-radius: 1rem;
      padding: 2.5rem; text-align: center; cursor: pointer;
      background: #f0fdf4; transition: all .2s;
    }
    .upload-zone:hover { border-color: #7ed957; background: #e8ffe0; }
    .upload-zone i { font-size: 2.5rem; color: #7ed957; margin-bottom: .75rem; display: block; }
    .upload-zone p { color: #6c757d; margin: 0; font-size: .875rem; }
    .upload-zone strong { color: #5ab832; }

    .ordo-card {
      border: 1.5px solid #e9ecef; border-radius: .85rem; padding: 1rem 1.25rem;
      display: flex; align-items: center; gap: 1rem; transition: all .15s;
    }
    .ordo-card:hover { border-color: #7ed957; box-shadow: 0 2px 8px rgba(126,217,87,.15); }
    .ordo-icon {
      width: 44px; height: 44px; border-radius: .65rem;
      background: #faf5ff; display: flex; align-items: center;
      justify-content: center; color: #9333ea; font-size: 1.3rem; flex-shrink: 0;
    }
  </style>
</head>
<body>

@include('client._sidebar', ['active' => 'ordonnances'])

<main class="main-content">

  <div class="d-flex justify-content-between align-items-start mb-4 flex-wrap gap-2">
    <div>
      <h4 class="fw-bold mb-1">Mes Ordonnances</h4>
      <p class="text-muted small mb-0">Gérez et soumettez vos ordonnances médicales.</p>
    </div>
    <button class="btn-green" data-bs-toggle="modal" data-bs-target="#uploadModal">
      <i class="ti ti-upload me-1"></i> Soumettre une ordonnance
    </button>
  </div>

  <!-- Stats ordonnances -->
  <div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:#faf5ff;"><i class="ti ti-file-description" style="color:#9333ea;"></i></div>
        <div><p class="stat-label">Total</p><h3 class="stat-value">0</h3></div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:#fff7ed;"><i class="ti ti-clock" style="color:#ea580c;"></i></div>
        <div><p class="stat-label">En attente</p><h3 class="stat-value">0</h3></div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:#f0fdf4;"><i class="ti ti-circle-check" style="color:#16a34a;"></i></div>
        <div><p class="stat-label">Validées</p><h3 class="stat-value">0</h3></div>
      </div>
    </div>
    <div class="col-6 col-md-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:#fef2f2;"><i class="ti ti-x" style="color:#dc2626;"></i></div>
        <div><p class="stat-label">Refusées</p><h3 class="stat-value">0</h3></div>
      </div>
    </div>
  </div>

  <div class="card-white">
    <h6 class="fw-bold mb-4">Historique des ordonnances</h6>

    <!-- État vide -->
    <div class="text-center py-5" style="color:#9ca3af;">
      <i class="ti ti-file-off" style="font-size:3rem;color:#d1d5db;display:block;margin-bottom:.75rem;"></i>
      <p class="fw-medium mb-1" style="color:#6c757d;">Aucune ordonnance soumise</p>
      <p class="small mb-3">Soumettez votre première ordonnance pour commencer.</p>
      <button class="btn-green" data-bs-toggle="modal" data-bs-target="#uploadModal">
        <i class="ti ti-upload me-1"></i> Soumettre une ordonnance
      </button>
    </div>
  </div>

</main>

<!-- Modal upload -->
<div class="modal fade" id="uploadModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius:1rem;border:none;">
      <div class="modal-header border-0 pb-0">
        <h5 class="modal-title fw-bold">Soumettre une ordonnance</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body pt-2">
        <form method="POST" action="#" enctype="multipart/form-data">
          @csrf
          <div class="mb-3">
            <label class="form-label">Médecin prescripteur</label>
            <input type="text" name="medecin" class="form-control" placeholder="Dr. Nom Prénom">
          </div>
          <div class="mb-3">
            <label class="form-label">Date de l'ordonnance</label>
            <input type="date" name="date_ordonnance" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Pharmacie cible</label>
            <select name="pharmacie_id" class="form-select">
              <option value="">Sélectionner une pharmacie...</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Fichier (image ou PDF)</label>
            <div class="upload-zone" onclick="document.getElementById('fileInput').click()">
              <i class="ti ti-cloud-upload"></i>
              <p><strong>Cliquer pour choisir</strong> ou glisser-déposer</p>
              <p class="mt-1" style="font-size:.78rem;">PNG, JPG, PDF — max 5 Mo</p>
            </div>
            <input type="file" id="fileInput" name="fichier" accept=".png,.jpg,.jpeg,.pdf" class="d-none">
            <div id="fileName" class="small text-muted mt-1"></div>
          </div>
          <div class="mb-3">
            <label class="form-label">Note (optionnel)</label>
            <textarea name="note" class="form-control" rows="2" placeholder="Informations complémentaires..."></textarea>
          </div>
          <button type="submit" class="btn-green w-100">
            <i class="ti ti-send me-1"></i> Envoyer l'ordonnance
          </button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  document.getElementById('fileInput')?.addEventListener('change', function() {
    const name = this.files[0]?.name ?? '';
    document.getElementById('fileName').textContent = name ? '📎 ' + name : '';
  });
</script>
</body>
</html>
