<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <title>PharmaNet — Tableau de bord</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
  @include('client._styles')
</head>
<body>

@include('client._sidebar', ['active' => 'dashboard'])

<main class="main-content">

  <div class="mb-4">
    <h4 class="fw-bold mb-1">Tableau de bord</h4>
    <p class="text-muted small mb-0">Bienvenue sur votre espace santé.</p>
  </div>

  <!-- Stats -->
  <div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:#eff4ff;">
          <i class="ti ti-shopping-bag" style="color:#2563eb;"></i>
        </div>
        <div>
          <p class="stat-label">Commandes totales</p>
          <h3 class="stat-value">{{ $stats['total'] }}</h3>
        </div>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:#fff7ed;">
          <i class="ti ti-clock" style="color:#ea580c;"></i>
        </div>
        <div>
          <p class="stat-label">Commandes en attente</p>
          <h3 class="stat-value">{{ $stats['en_attente'] }}</h3>
        </div>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:#f0fdf4;">
          <i class="ti ti-circle-check" style="color:#16a34a;"></i>
        </div>
        <div>
          <p class="stat-label">Commandes terminées</p>
          <h3 class="stat-value">{{ $stats['terminees'] }}</h3>
        </div>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:#faf5ff;">
          <i class="ti ti-file-description" style="color:#9333ea;"></i>
        </div>
        <div>
          <p class="stat-label">Ordonnances en attente</p>
          <h3 class="stat-value">{{ $stats['ordonnances'] }}</h3>
        </div>
      </div>
    </div>
  </div>

  <!-- Tables -->
  <div class="row g-3">

    <!-- Commandes récentes -->
    <div class="col-12 col-lg-7">
      <div class="card-white">
        <h6 class="fw-bold mb-3">Commandes récentes</h6>
        <table class="table-clean">
          <thead>
            <tr>
              <th>Pharmacie</th>
              <th>Date</th>
              <th>Total</th>
              <th>Statut</th>
            </tr>
          </thead>
          <tbody>
            @forelse($commandes as $cmd)
            <tr>
              <td class="fw-medium">{{ $cmd->pharmacie->nom ?? '—' }}</td>
              <td class="text-muted">{{ $cmd->created_at->format('d/m/Y') }}</td>
              <td>{{ number_format($cmd->montant_total, 2) }} DA</td>
              <td>@include('client._badge_statut', ['statut' => $cmd->statut])</td>
            </tr>
            @empty
            <tr><td colspan="4" class="empty-cell">Aucune commande récente</td></tr>
            @endforelse
          </tbody>
        </table>
        @if($commandes->count())
        <div class="mt-3">
          <a href="{{ route('client.commandes') }}" class="link-green small">Voir toutes les commandes →</a>
        </div>
        @endif
      </div>
    </div>

    <!-- Ordonnances récentes -->
    <div class="col-12 col-lg-5">
      <div class="card-white">
        <h6 class="fw-bold mb-3">Ordonnances récentes</h6>
        <table class="table-clean">
          <thead>
            <tr>
              <th>Date</th>
              <th>Médecin</th>
              <th>Statut</th>
            </tr>
          </thead>
          <tbody>
            <tr><td colspan="3" class="empty-cell">Aucune ordonnance récente</td></tr>
          </tbody>
        </table>
        <div class="mt-3">
          <a href="{{ route('client.ordonnances') }}" class="link-green small">Voir toutes les ordonnances →</a>
        </div>
      </div>
    </div>

  </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
