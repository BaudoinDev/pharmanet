<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <title>PharmaNet — Dossier en cours de vérification</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
  <style>
    body { background: #f5f6fa; font-family: system-ui, sans-serif; min-height: 100vh; display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 2rem; }
    .card-status { background: #fff; border-radius: 1.25rem; padding: 3rem 2.5rem; max-width: 520px; width: 100%; box-shadow: 0 4px 24px rgba(0,0,0,.08); text-align: center; }
    .status-icon { width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-size: 2rem; }
    .status-icon.attente  { background: #fef9c3; color: #ca8a04; }
    .status-icon.refusee  { background: #fee2e2; color: #dc2626; }
    .step-list { text-align: left; margin: 1.75rem 0; }
    .step-row { display: flex; align-items: center; gap: .85rem; padding: .65rem 0; border-bottom: 1px solid #f3f4f6; font-size: .875rem; }
    .step-row:last-child { border-bottom: none; }
    .step-dot { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: .75rem; font-weight: 700; flex-shrink: 0; }
    .step-dot.done    { background: #dcfce7; color: #16a34a; }
    .step-dot.current { background: #fef9c3; color: #ca8a04; }
    .step-dot.pending { background: #f3f4f6; color: #9ca3af; }
    .btn-logout-link { background: none; border: 1.5px solid #e5e7eb; border-radius: .6rem; padding: .6rem 1.5rem; font-size: .875rem; font-weight: 600; color: #6b7280; cursor: pointer; transition: all .15s; }
    .btn-logout-link:hover { border-color: #dc2626; color: #dc2626; background: #fef2f2; }
    .pharma-info { background: #f9fafb; border-radius: .75rem; padding: 1rem 1.25rem; margin: 1.25rem 0; text-align: left; font-size: .85rem; }
    .pharma-info-row { display: flex; justify-content: space-between; padding: .3rem 0; }
    .pharma-info-row .lbl { color: #9ca3af; }
    .pharma-info-row .val { font-weight: 600; color: #111; }
    .badge-statut-attente { background: #fef9c3; color: #854d0e; border: 1px solid #fde68a; border-radius: 2rem; padding: .2rem .7rem; font-size: .75rem; font-weight: 700; }
    .badge-statut-refusee  { background: #fee2e2; color: #dc2626; border: 1px solid #fecaca; border-radius: 2rem; padding: .2rem .7rem; font-size: .75rem; font-weight: 700; }
  </style>
</head>
<body>

<div class="card-status">

  <!-- Logo -->
  <a href="{{ url('/') }}" class="d-inline-flex align-items-center gap-2 text-decoration-none mb-4">
    <svg width="32" height="32" viewBox="0 0 40 40" fill="none">
      <rect width="40" height="40" rx="10" fill="#7ed957"/>
      <rect x="10" y="18" width="20" height="4" rx="2" fill="white"/>
      <rect x="18" y="10" width="4" height="20" rx="2" fill="white"/>
    </svg>
    <span style="font-size:1.1rem;font-weight:800;color:#111;">Pharma<span style="color:#7ed957;">Net</span></span>
  </a>

  @if($pharmacie && $pharmacie->statut === 'refusee')
    <div class="status-icon refusee"><i class="ti ti-x"></i></div>
    <h4 class="fw-bold mb-1">Demande refusée</h4>
    <p class="text-muted" style="font-size:.9rem;">Votre demande d'inscription n'a pas été retenue. Veuillez contacter notre équipe pour plus d'informations.</p>
  @else
    <div class="status-icon attente"><i class="ti ti-clock-hour-4"></i></div>
    <h4 class="fw-bold mb-1">Dossier en cours de vérification</h4>
    <p class="text-muted" style="font-size:.9rem;">Votre demande a bien été reçue. Notre équipe examine votre dossier et vous contactera sous <strong>48h ouvrables</strong>.</p>
  @endif

  @if($pharmacie)
  <div class="pharma-info">
    <div class="pharma-info-row">
      <span class="lbl">Pharmacie</span>
      <span class="val">{{ $pharmacie->nom }}</span>
    </div>
    <div class="pharma-info-row">
      <span class="lbl">Adresse</span>
      <span class="val">{{ $pharmacie->adresse }}</span>
    </div>
    @if($pharmacie->numero_agrement)
    <div class="pharma-info-row">
      <span class="lbl">Agrément</span>
      <span class="val" style="font-family:monospace;">{{ $pharmacie->numero_agrement }}</span>
    </div>
    @endif
    <div class="pharma-info-row">
      <span class="lbl">Statut</span>
      <span>
        @if($pharmacie->statut === 'refusee')
          <span class="badge-statut-refusee">Refusée</span>
        @else
          <span class="badge-statut-attente">En attente</span>
        @endif
      </span>
    </div>
    <div class="pharma-info-row">
      <span class="lbl">Soumise le</span>
      <span class="val">{{ $pharmacie->created_at->format('d/m/Y à H:i') }}</span>
    </div>
  </div>
  @endif

  @if(!$pharmacie || $pharmacie->statut === 'en_attente')
  <div class="step-list">
    <div class="step-row">
      <div class="step-dot done"><i class="ti ti-check"></i></div>
      <div><strong>Dossier soumis</strong> — Inscription complétée avec succès</div>
    </div>
    <div class="step-row">
      <div class="step-dot current"><i class="ti ti-search"></i></div>
      <div><strong>Vérification en cours</strong> — Examen de vos informations et de votre agrément</div>
    </div>
    <div class="step-row">
      <div class="step-dot pending">3</div>
      <div style="color:#9ca3af;">Accès à votre espace pharmacien</div>
    </div>
  </div>
  @endif

  <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="btn-logout-link">
      <i class="ti ti-logout me-1"></i> Se déconnecter
    </button>
  </form>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
