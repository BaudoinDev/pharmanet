<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <title>PharmaNet — Commandes</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
  @include('pharmacie._styles')
</head>
<body>

@include('pharmacie._sidebar', ['active' => 'commandes'])
@include('pharmacie._topbar', ['pageTitle' => 'Commandes'])

<main class="main-content">

  <div class="mb-4">
    <h4 class="fw-bold mb-1">Commandes reçues</h4>
    <p class="text-muted small mb-0">Gérez les commandes passées par vos clients.</p>
  </div>

  <!-- Stats -->
  <div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:#f2ffe8;"><i class="ti ti-shopping-bag" style="color:#5ab832;"></i></div>
        <div><p class="stat-label">Total</p><h3 class="stat-value">{{ $stats['total'] }}</h3></div>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:#fff7ed;"><i class="ti ti-clock" style="color:#ea580c;"></i></div>
        <div><p class="stat-label">En attente</p><h3 class="stat-value">{{ $stats['attente'] }}</h3></div>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:#eff4ff;"><i class="ti ti-circle-check" style="color:#2563eb;"></i></div>
        <div><p class="stat-label">Confirmées</p><h3 class="stat-value">{{ $stats['confirmee'] }}</h3></div>
      </div>
    </div>
    <div class="col-6 col-lg-3">
      <div class="stat-card">
        <div class="stat-icon" style="background:#f0fdf4;"><i class="ti ti-truck" style="color:#16a34a;"></i></div>
        <div><p class="stat-label">Livrées</p><h3 class="stat-value">{{ $stats['livree'] }}</h3></div>
      </div>
    </div>
  </div>

  <!-- Filtres + Table -->
  <div class="card-white">
    <form method="GET" class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
      <div class="filter-tabs">
        @foreach(['tous' => 'Toutes', 'en_attente' => 'En attente', 'confirmee' => 'Confirmées', 'livree' => 'Livrées', 'annulee' => 'Annulées'] as $val => $lbl)
          <button type="submit" name="statut" value="{{ $val }}"
            class="filter-tab {{ (request('statut', 'tous') === $val) ? 'active' : '' }}">
            {{ $lbl }}
          </button>
        @endforeach
      </div>
      <div class="search-wrap">
        <i class="ti ti-search"></i>
        <input type="text" name="search" class="search-input" placeholder="Chercher un client…" value="{{ request('search') }}">
      </div>
    </form>

    <div class="table-responsive">
      <table class="table-ph">
        <thead>
          <tr>
            <th>N° Commande</th>
            <th>Client</th>
            <th>Montant</th>
            <th>Date</th>
            <th>Statut</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($commandes as $cmd)
          <tr>
            <td><span style="font-family:monospace;font-size:.82rem;background:#f3f4f6;padding:.2rem .5rem;border-radius:.35rem;">#{{ str_pad($cmd->id, 5, '0', STR_PAD_LEFT) }}</span></td>
            <td>
              <div class="fw-medium">{{ $cmd->client->prenom ?? '—' }} {{ $cmd->client->nom ?? '' }}</div>
              <div class="text-muted" style="font-size:.75rem;">{{ $cmd->client->telephone ?? '' }}</div>
            </td>
            <td class="fw-semibold">{{ number_format($cmd->montant_total, 0, ',', ' ') }} FCFA</td>
            <td style="font-size:.8rem;color:#6b7280;">
              {{ $cmd->created_at->format('d/m/Y') }}<br>
              <span style="font-size:.72rem;">{{ $cmd->created_at->format('H:i') }}</span>
            </td>
            <td><span class="badge-statut badge-{{ $cmd->statut }}">{{ ucfirst(str_replace('_', ' ', $cmd->statut)) }}</span></td>
            <td>
              <button class="btn-outline-green" style="padding:.3rem .75rem;font-size:.78rem;">
                <i class="ti ti-eye"></i> Voir
              </button>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" class="empty-cell">
            <i class="ti ti-shopping-bag" style="font-size:2rem;display:block;margin-bottom:.5rem;"></i>
            Aucune commande trouvée
          </td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($commandes->hasPages())
      <div class="mt-3">{{ $commandes->withQueryString()->links() }}</div>
    @endif
  </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
