<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <title>PharmaNet — Espace Pharmacie</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
  @include('pharmacie._styles')
  <style>
    .table-clean { width:100%;border-collapse:collapse;font-size:.875rem; }
    .table-clean thead th { color:#9ca3af;font-size:.72rem;font-weight:700;text-transform:uppercase;letter-spacing:.05em;padding:0 0 .65rem;border-bottom:1px solid #f0f0f0;text-align:left; }
    .table-clean tbody td { padding:.75rem 0;border-bottom:1px solid #f8f8f8;color:#374151;vertical-align:middle; }
    .table-clean tbody tr:last-child td { border-bottom:none; }
    .empty-cell { text-align:center;color:#9ca3af;padding:2rem 0 !important; }
    .action-link { display:flex;align-items:center;gap:.75rem;padding:.85rem 1rem;border:1.5px solid #e9ecef;border-radius:.75rem;color:#374151;font-size:.875rem;font-weight:500;text-decoration:none;transition:all .15s; }
    .action-link:hover { border-color:var(--green);color:var(--green-dark);background:#f2ffe8; }
    .action-link i { color:var(--green);font-size:1.05rem; }
    .badge-statut { display:inline-flex;align-items:center;gap:.3rem;padding:.2rem .6rem;border-radius:9999px;font-size:.75rem;font-weight:600; }
    .badge-en_attente { background:#fff7ed;color:#ea580c;border:1px solid #fed7aa; }
    .badge-confirmee  { background:#eff4ff;color:#2563eb;border:1px solid #bfdbfe; }
    .badge-livree     { background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0; }
    .badge-annulee    { background:#fef2f2;color:#dc2626;border:1px solid #fecaca; }
  </style>
</head>
<body>

@include('pharmacie._sidebar', ['active' => 'dashboard'])
@include('pharmacie._topbar', ['pageTitle' => 'Tableau de bord'])

<main class="main-content">

  <!-- Titre + Bouton import -->
  <div class="d-flex align-items-start justify-content-between mb-4 flex-wrap gap-3">
    <div>
      <h4 class="fw-bold mb-1">Bonjour, {{ Auth::user()->name }}</h4>
      <p class="text-muted small mb-0">Voici un aperçu de l'activité de <strong>{{ $pharmacie->nom }}</strong> aujourd'hui.</p>
    </div>
    <button class="btn-green" data-bs-toggle="modal" data-bs-target="#importDashModal" style="align-self:flex-start;">
      <i class="ti ti-file-upload"></i> Importer votre catalogue
    </button>
  </div>

  <!-- Stats -->
  <div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:#f2ffe8;"><i class="ti ti-shopping-bag" style="color:#5ab832;"></i></div>
        <div><p class="stat-label">Commandes totales</p><h3 class="stat-value">{{ $stats['commandes_total'] }}</h3></div>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:#fff7ed;"><i class="ti ti-clock-hour-4" style="color:#ea580c;"></i></div>
        <div><p class="stat-label">En attente</p><h3 class="stat-value">{{ $stats['commandes_attente'] }}</h3></div>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:#eff6ff;"><i class="ti ti-calendar" style="color:#2563eb;"></i></div>
        <div><p class="stat-label">Ce mois-ci</p><h3 class="stat-value">{{ $stats['commandes_mois'] }}</h3></div>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:#fdf4ff;"><i class="ti ti-pill" style="color:#9333ea;"></i></div>
        <div><p class="stat-label">Médicaments</p><h3 class="stat-value">{{ $stats['medicaments'] }}</h3></div>
      </div>
    </div>
  </div>

  <div class="row g-3">

    <!-- Commandes récentes -->
    <div class="col-12 col-lg-8">
      <div class="card-white">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h6 class="fw-bold mb-0">Commandes récentes</h6>
          <a href="{{ route('pharmacie.commandes') }}" style="font-size:.8rem;color:#5ab832;text-decoration:none;font-weight:600;">Voir tout →</a>
        </div>
        <table class="table-clean">
          <thead>
            <tr>
              <th>N°</th>
              <th>Client</th>
              <th>Montant</th>
              <th>Date</th>
              <th>Statut</th>
            </tr>
          </thead>
          <tbody>
            @forelse($commandes as $cmd)
            <tr>
              <td><span style="font-family:monospace;font-size:.8rem;">#{{ str_pad($cmd->id, 4, '0', STR_PAD_LEFT) }}</span></td>
              <td>{{ $cmd->client->prenom ?? '—' }} {{ $cmd->client->nom ?? '' }}</td>
              <td class="fw-semibold">{{ number_format($cmd->montant_total ?? 0, 0, ',', ' ') }} FCFA</td>
              <td style="font-size:.8rem;color:#6b7280;">{{ $cmd->created_at->format('d/m/Y') }}</td>
              <td><span class="badge-statut badge-{{ $cmd->statut }}">{{ ucfirst(str_replace('_', ' ', $cmd->statut)) }}</span></td>
            </tr>
            @empty
            <tr><td colspan="5" class="empty-cell">
              <i class="ti ti-inbox" style="font-size:1.5rem;display:block;margin-bottom:.35rem;"></i>Aucune commande pour l'instant
            </td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <!-- Infos + Actions rapides -->
    <div class="col-12 col-lg-4">
      <div class="card-green mb-3">
        <div style="font-size:.72rem;opacity:.75;text-transform:uppercase;letter-spacing:.06em;margin-bottom:.5rem;">Votre pharmacie</div>
        <div class="fw-bold mb-1" style="font-size:1rem;">{{ $pharmacie->nom }}</div>
        <div style="font-size:.82rem;opacity:.85;margin-bottom:.35rem;"><i class="ti ti-map-pin me-1"></i>{{ $pharmacie->adresse }}</div>
        @if($pharmacie->telephone)
          <div style="font-size:.82rem;opacity:.85;margin-bottom:.35rem;"><i class="ti ti-phone me-1"></i>{{ $pharmacie->telephone }}</div>
        @endif
        @if($pharmacie->garde)
          <span style="background:rgba(255,255,255,.2);border-radius:2rem;padding:.2rem .65rem;font-size:.72rem;font-weight:700;margin-top:.5rem;display:inline-block;">
            <i class="ti ti-moon me-1"></i>Pharmacie de garde
          </span>
        @endif
      </div>
    </div>

  </div>
</main>

<!-- ═══ Modal Import Catalogue ══════════════════════════════ -->
<div class="modal fade" id="importDashModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" style="max-width:480px;">
    <div class="modal-content" style="border-radius:1rem;border:none;">
      <div class="modal-body p-4">
        <h5 class="fw-bold mb-1">Importer votre catalogue</h5>
        <p class="text-muted small mb-3">Importez vos médicaments depuis un fichier CSV ou Excel (.xlsx).</p>

        <div style="background:#eff6ff;border:1px solid #bfdbfe;border-radius:.65rem;padding:.75rem 1rem;font-size:.8rem;color:#1d4ed8;margin-bottom:1rem;">
          <strong>Colonnes attendues :</strong><br>
          <code style="font-size:.75rem;">nom, description, prix, stock, categorie, prescription_obligatoire</code><br>
          <a href="{{ route('pharmacie.medicaments.modele') }}" style="color:#2563eb;font-weight:600;">
            <i class="ti ti-download me-1"></i>Télécharger le modèle CSV
          </a>
        </div>

        <form method="POST" action="{{ route('pharmacie.medicaments.importer') }}" enctype="multipart/form-data">
          @csrf
          <div style="border:2px dashed #d1d5db;border-radius:.75rem;padding:1.75rem;text-align:center;cursor:pointer;position:relative;transition:all .2s;" id="dashDropZone">
            <input type="file" name="fichier" accept=".csv,.xlsx,.xls,.txt" required
              style="position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%;" onchange="dashUpdateFile(this)">
            <i class="ti ti-cloud-upload" style="font-size:2.25rem;color:#9ca3af;display:block;margin-bottom:.5rem;" id="dashUploadIcon"></i>
            <p class="mb-0 text-muted small" id="dashUploadText">
              Glissez votre fichier ici ou cliquez<br>
              <span style="font-size:.72rem;">CSV, XLSX — max 5 Mo</span>
            </p>
          </div>
          <div class="d-flex gap-2 justify-content-end mt-3">
            <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn-green px-4"><i class="ti ti-upload"></i> Importer</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function dashUpdateFile(input) {
  if (!input.files || !input.files[0]) return;
  document.getElementById('dashUploadIcon').className = 'ti ti-file-check';
  document.getElementById('dashUploadIcon').style.color = '#7ed957';
  document.getElementById('dashUploadText').innerHTML = '<strong>' + input.files[0].name + '</strong><br><span style="font-size:.72rem;color:#9ca3af;">' + (input.files[0].size/1024).toFixed(1) + ' Ko</span>';
}
const ddz = document.getElementById('dashDropZone');
ddz.addEventListener('dragover', e => { e.preventDefault(); ddz.style.borderColor='#7ed957'; ddz.style.background='#f0fdf4'; });
ddz.addEventListener('dragleave', () => { ddz.style.borderColor=''; ddz.style.background=''; });
ddz.addEventListener('drop', () => { ddz.style.borderColor=''; ddz.style.background=''; });
</script>
</body>
</html>
