<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <title>PharmaNet — Mes Commandes</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
  @include('client._styles')
</head>
<body>

@include('client._sidebar', ['active' => 'commandes'])

<main class="main-content">

  <div class="mb-4">
    <h4 class="fw-bold mb-1">Mes Commandes</h4>
    <p class="text-muted small mb-0">Suivez l'état de toutes vos commandes.</p>
  </div>

  <!-- Filtres + Recherche -->
  <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
    <div class="filter-tabs">
      <button class="filter-tab active" onclick="setFilter(this,'toutes')">Toutes</button>
      <button class="filter-tab" onclick="setFilter(this,'en_attente')">En attente</button>
      <button class="filter-tab" onclick="setFilter(this,'confirmee')">Confirmées</button>
      <button class="filter-tab" onclick="setFilter(this,'livree')">Livrées</button>
      <button class="filter-tab" onclick="setFilter(this,'annulee')">Annulées</button>
    </div>
    <div class="search-wrapper">
      <i class="ti ti-search"></i>
      <input type="text" class="search-input" placeholder="Rechercher..." id="searchInput" oninput="filterRows()">
    </div>
  </div>

  <div class="card-white">
    <table class="table-clean" id="commandesTable">
      <thead>
        <tr>
          <th>#</th>
          <th>Pharmacie</th>
          <th>Date</th>
          <th>Montant</th>
          <th>Statut</th>
          <th>Détail</th>
        </tr>
      </thead>
      <tbody id="tableBody">
        @forelse($commandes as $cmd)
        <tr data-statut="{{ $cmd->statut }}">
          <td class="text-muted">#{{ $cmd->id }}</td>
          <td class="fw-medium">{{ $cmd->pharmacie->nom ?? '—' }}</td>
          <td class="text-muted">{{ $cmd->created_at->format('d/m/Y') }}</td>
          <td class="fw-semibold">{{ number_format($cmd->montant_total, 2) }} DA</td>
          <td>@include('client._badge_statut', ['statut' => $cmd->statut])</td>
          <td>
            <a href="#" class="btn-action">
              <i class="ti ti-eye"></i>
            </a>
          </td>
        </tr>
        @empty
        <tr><td colspan="6" class="empty-cell">Aucune commande pour le moment</td></tr>
        @endforelse
      </tbody>
    </table>

    @if(method_exists($commandes, 'links') && $commandes->hasPages())
    <div class="mt-3 d-flex justify-content-end">
      {{ $commandes->links() }}
    </div>
    @endif
  </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  let currentFilter = 'toutes';

  function setFilter(btn, filter) {
    document.querySelectorAll('.filter-tab').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    currentFilter = filter;
    filterRows();
  }

  function filterRows() {
    const search = document.getElementById('searchInput').value.toLowerCase();
    document.querySelectorAll('#tableBody tr[data-statut]').forEach(row => {
      const matchFilter = currentFilter === 'toutes' || row.dataset.statut === currentFilter;
      const matchSearch = row.textContent.toLowerCase().includes(search);
      row.style.display = matchFilter && matchSearch ? '' : 'none';
    });
  }
</script>

<style>
  .btn-action {
    padding: .35rem .6rem; border-radius: .4rem; border: 1px solid #e9ecef;
    background: #fff; color: #374151; text-decoration: none; font-size: .85rem;
    display: inline-flex; align-items: center; transition: all .15s;
  }
  .btn-action:hover { border-color: #7ed957; color: #5ab832; }
</style>
</body>
</html>
