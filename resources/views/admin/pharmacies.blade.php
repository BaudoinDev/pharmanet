<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>PharmaNet — Pharmacies</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
  <style>
    :root { --sidebar-width: 230px; }

    body { background: #f5f6fa; margin: 0; font-family: system-ui, -apple-system, sans-serif; }

    /* ── Sidebar ─────────────────────────────── */
    .sidebar {
      position: fixed; top: 0; left: 0;
      width: var(--sidebar-width); height: 100vh;
      background: #fff; border-right: 1px solid #e9ecef;
      display: flex; flex-direction: column; z-index: 100;
    }
    .sidebar-logo { padding: 1.25rem 1rem; border-bottom: 1px solid #f0f0f0; }

    .sidebar-nav { flex: 1; padding: 1rem 0.75rem; overflow-y: auto; }
    .sidebar-nav .nav-link {
      display: flex; align-items: center; gap: 0.65rem;
      padding: 0.6rem 0.85rem; border-radius: 0.5rem;
      color: #6c757d; font-size: 0.875rem; font-weight: 500;
      transition: all 0.15s; margin-bottom: 0.125rem;
    }
    .sidebar-nav .nav-link:hover  { background: #f2ffe8; color: #5ab832; }
    .sidebar-nav .nav-link.active { background: #f2ffe8; color: #5ab832; }
    .sidebar-nav .nav-link i { font-size: 1.1rem; flex-shrink: 0; }

    .sidebar-footer { padding: 0.75rem; border-top: 1px solid #f0f0f0; }
    .avatar-circle { width: 42px; height: 42px; border-radius: 50%; background: #dde4f0; flex-shrink: 0; }

    .btn-logout {
      display: flex; align-items: center; gap: 0.5rem;
      color: #dc3545; background: none; border: none;
      font-size: 0.875rem; font-weight: 500;
      padding: 0.55rem 0.85rem; border-radius: 0.5rem;
      width: 100%; cursor: pointer; text-align: left; margin-top: 0.5rem;
    }
    .btn-logout:hover { background: #fff0f0; }

    /* ── Main ────────────────────────────────── */
    .main-content { margin-left: var(--sidebar-width); padding: 2rem 2.25rem; min-height: 100vh; }

    /* ── Filter tabs ─────────────────────────── */
    .filter-tabs {
      display: flex; gap: 0.25rem;
      background: #fff; border: 1px solid #e9ecef;
      border-radius: 0.6rem; padding: 0.25rem; width: fit-content;
    }
    .filter-tab {
      padding: 0.4rem 1rem; border-radius: 0.45rem;
      font-size: 0.85rem; font-weight: 500; color: #6c757d;
      border: none; background: none; cursor: pointer; transition: all 0.15s;
    }
    .filter-tab.active {
      background: #fff; color: #111;
      box-shadow: 0 1px 3px rgba(0,0,0,.12);
      border: 1px solid #e0e0e0;
    }
    .filter-tab:not(.active):hover { color: #5ab832; }

    /* ── Search ──────────────────────────────── */
    .search-input {
      border: 1px solid #e9ecef; border-radius: 0.6rem;
      padding: 0.45rem 0.85rem 0.45rem 2.25rem;
      font-size: 0.875rem; background: #fff; color: #374151;
      outline: none; width: 260px;
    }
    .search-input:focus { border-color: #7ed957; box-shadow: 0 0 0 3px rgba(126,217,87,.15); }
    .search-wrapper { position: relative; }
    .search-wrapper i {
      position: absolute; left: 0.65rem; top: 50%;
      transform: translateY(-50%); color: #9ca3af; font-size: 1rem;
    }

    /* ── Table ───────────────────────────────── */
    .table-card {
      background: #fff; border-radius: 1rem;
      box-shadow: 0 1px 4px rgba(0,0,0,.06); overflow: hidden;
    }
    .table thead th {
      font-size: 0.8rem; font-weight: 600; color: #6c757d;
      border-bottom: 1px solid #f0f0f0; padding: 0.85rem 1rem;
      background: #fff; white-space: nowrap;
    }
    .table tbody td {
      font-size: 0.875rem; padding: 0.85rem 1rem;
      border-bottom: 1px solid #f8f8f8; vertical-align: middle; color: #374151;
    }
    .table tbody tr:last-child td { border-bottom: none; }
    .table tbody tr:hover td { background: #fafafa; }

    .badge-active    { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
    .badge-pending   { background: #fffbeb; color: #b45309; border: 1px solid #fde68a; }
    .badge-suspended { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
    .status-badge {
      display: inline-flex; align-items: center; gap: 0.35rem;
      padding: 0.25rem 0.65rem; border-radius: 9999px;
      font-size: 0.75rem; font-weight: 600;
    }

    .btn-action {
      padding: 0.3rem 0.6rem; border-radius: 0.4rem;
      font-size: 0.8rem; border: 1px solid #e9ecef;
      background: #fff; color: #374151; cursor: pointer;
      transition: all 0.15s; text-decoration: none; display: inline-flex; align-items: center; gap: 0.25rem;
    }
    .btn-action:hover { border-color: #7ed957; color: #5ab832; }
    .btn-action-danger:hover { border-color: #fca5a5; color: #dc2626; }

    .empty-state {
      padding: 4rem 1rem; text-align: center; color: #9ca3af;
    }
    .empty-state i { font-size: 2.5rem; margin-bottom: 0.75rem; display: block; color: #d1d5db; }
  </style>
</head>
<body>

  <!-- ═══ SIDEBAR ══════════════════════════════════════════════════ -->
  <aside class="sidebar">

    <div class="sidebar-logo">
      <a href="{{ url('/') }}" class="d-flex align-items-center gap-2 text-decoration-none">
        <svg width="30" height="30" viewBox="0 0 402 382" xmlns="http://www.w3.org/2000/svg">
          <path fill="#7ed957" d="M271.75 127.13L178.68 34.06C160.75 16.13 136.8 6.25 111.25 6.25c-25.55 0-49.5 9.88-67.43 27.81C6.65 71.25 6.65 131.74 43.82 168.92l93.07 93.07Z"/>
          <path fill="#000" d="M111.25 11.55c-24.13 0-46.75 9.32-63.68 26.26C12.46 72.92 12.46 130.06 47.57 165.18l89.33 89.34L264.27 127.13 174.93 37.8C158.01 20.87 135.39 11.55 111.25 11.55m0-10.59c25.8 0 51.6 9.78 71.17 29.35l96.81 96.82L136.89 269.47 40.07 172.66C.93 133.51.93 69.46 40.07 30.31 59.65 10.74 85.46.96 111.25.96Z"/>
          <path fill="#fff" d="M291.08 376.75c25.42 0 49.26-9.84 67.11-27.68 37.64-37.65 37.64-97.85.65-134.86l-91.89-91.88-134.86 134.86 91.88 91.88c17.85 17.84 41.69 27.68 67.11 27.68Z"/>
          <path fill="#000" d="M266.95 129.82L139.58 257.19l88.13 88.14c16.86 16.84 39.36 26.12 63.37 26.12s46.52-9.28 63.36-26.12l.64-.64c34.94-34.94 34.94-91.78 0-126.73l-88.13-88.14m0-14.97 95.62 95.62c38.97 38.97 38.97 102.73 0 141.7l-.63.63c-19.49 19.5-45.17 29.24-70.86 29.24s-51.37-9.74-70.85-29.23l-95.62-95.62Z"/>
        </svg>
        <span style="font-size:1.05rem;font-weight:700;color:#111;">Pharma<span style="color:#7ed957;">Net</span></span>
      </a>
    </div>

    <nav class="sidebar-nav">
      <ul class="list-unstyled mb-0">
        <li>
          <a href="{{ route('admin.dashboard') }}" class="nav-link">
            <i class="ti ti-activity" style="color:#7ed957;"></i> Vue Globale
          </a>
        </li>
        <li>
          <a href="{{ route('admin.pharmacies') }}" class="nav-link active">
            <i class="ti ti-pill" style="color:#7ed957;"></i> Pharmacies
          </a>
        </li>
        <li>
          <a href="#" class="nav-link">
            <i class="ti ti-users" style="color:#7ed957;"></i> Utilisateurs
          </a>
        </li>
      </ul>
    </nav>

    <div class="sidebar-footer">
      <div class="d-flex align-items-center gap-2 px-2 mb-1">
        <div class="avatar-circle d-flex align-items-center justify-content-center fw-bold text-white" style="background:#7ed957;font-size:.85rem;">
          {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
        <div style="min-width:0;">
          <div class="fw-semibold text-truncate" style="font-size:.8rem;">{{ Auth::user()->name }}</div>
          <div class="text-muted text-truncate" style="font-size:.72rem;">{{ Auth::user()->email }}</div>
        </div>
      </div>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn-logout">
          <i class="ti ti-logout"></i> Déconnexion
        </button>
      </form>
    </div>

  </aside>

  <!-- ═══ CONTENU PRINCIPAL ════════════════════════════════════════ -->
  <main class="main-content">

    <div class="mb-4">
      <h4 class="fw-bold mb-1">Pharmacies</h4>
      <p class="text-muted small mb-0">Gérez le réseau des pharmacies partenaires.</p>
    </div>

    <!-- Barre filtre + recherche -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
      <div class="filter-tabs">
        <button class="filter-tab active" onclick="setFilter(this, 'toutes')">Toutes</button>
        <button class="filter-tab" onclick="setFilter(this, 'en_attente')">En attente</button>
        <button class="filter-tab" onclick="setFilter(this, 'actives')">Actives</button>
        <button class="filter-tab" onclick="setFilter(this, 'suspendues')">Suspendues</button>
      </div>
      <div class="search-wrapper">
        <i class="ti ti-search"></i>
        <input type="text" class="search-input" placeholder="Rechercher une pharmacie..." id="searchInput" oninput="filterTable()">
      </div>
    </div>

    <!-- Tableau -->
    <div class="table-card">
      <table class="table mb-0" id="pharmacieTable">
        <thead>
          <tr>
            <th>Pharmacie</th>
            <th>Ville</th>
            <th>Propriétaire</th>
            <th>Date d'inscription</th>
            <th>Statut</th>
            <th class="text-end">Actions</th>
          </tr>
        </thead>
        <tbody id="tableBody">
          @forelse($pharmacies ?? [] as $pharmacie)
          <tr data-statut="{{ $pharmacie->statut }}">
            <td>
              <div class="fw-semibold">{{ $pharmacie->nom }}</div>
              <div class="text-muted" style="font-size:.78rem;">{{ $pharmacie->adresse }}</div>
            </td>
            <td>{{ $pharmacie->ville }}</td>
            <td>{{ $pharmacie->proprietaire->name ?? '—' }}</td>
            <td>{{ \Carbon\Carbon::parse($pharmacie->created_at)->format('d/m/Y') }}</td>
            <td>
              @if($pharmacie->statut === 'active')
                <span class="status-badge badge-active"><i class="ti ti-circle-filled" style="font-size:.5rem;"></i> Active</span>
              @elseif($pharmacie->statut === 'en_attente')
                <span class="status-badge badge-pending"><i class="ti ti-circle-filled" style="font-size:.5rem;"></i> En attente</span>
              @else
                <span class="status-badge badge-suspended"><i class="ti ti-circle-filled" style="font-size:.5rem;"></i> Suspendue</span>
              @endif
            </td>
            <td class="text-end">
              <a href="#" class="btn-action"><i class="ti ti-eye"></i> Voir</a>
              <button class="btn-action btn-action-danger ms-1"><i class="ti ti-trash"></i></button>
            </td>
          </tr>
          @empty
          <tr id="emptyRow">
            <td colspan="6">
              <div class="empty-state">
                <i class="ti ti-pill-off"></i>
                <p class="mb-0 fw-medium" style="color:#6c757d;">Aucune pharmacie enregistrée</p>
                <p class="small" style="color:#9ca3af;">Les pharmacies apparaîtront ici une fois inscrites.</p>
              </div>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    let currentFilter = 'toutes';

    function setFilter(btn, filter) {
      document.querySelectorAll('.filter-tab').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      currentFilter = filter;
      filterTable();
    }

    function filterTable() {
      const search = document.getElementById('searchInput').value.toLowerCase();
      const rows = document.querySelectorAll('#tableBody tr[data-statut]');
      rows.forEach(row => {
        const matchFilter = currentFilter === 'toutes' || row.dataset.statut === currentFilter;
        const matchSearch = row.textContent.toLowerCase().includes(search);
        row.style.display = matchFilter && matchSearch ? '' : 'none';
      });
    }
  </script>
</body>
</html>
