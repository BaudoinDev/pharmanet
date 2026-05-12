<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>PharmaNet — Admin</title>
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
      display: flex; flex-direction: column; z-index: 200;
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

    /* ── Topbar ──────────────────────────────── */
    .topbar {
      position: fixed; top: 0; left: var(--sidebar-width); right: 0;
      height: 60px; background: #fff;
      border-bottom: 1px solid #e9ecef;
      display: flex; align-items: center;
      padding: 0 2.25rem; z-index: 150;
      justify-content: space-between;
    }
    .topbar-title { font-weight: 700; font-size: 1rem; color: #111827; }
    .topbar-actions { display: flex; align-items: center; gap: .75rem; }

    /* Cloche notification */
    .notif-btn {
      position: relative; background: #f5f6fa; border: none;
      width: 40px; height: 40px; border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      color: #6b7280; font-size: 1.15rem; cursor: pointer;
      transition: background .15s;
    }
    .notif-btn:hover { background: #f2ffe8; color: #5ab832; }
    .notif-badge {
      position: absolute; top: 4px; right: 4px;
      background: #dc2626; color: #fff; border-radius: 999px;
      font-size: .6rem; font-weight: 700;
      min-width: 16px; height: 16px;
      display: flex; align-items: center; justify-content: center;
      padding: 0 3px; border: 2px solid #fff;
      animation: pulse-badge 2s infinite;
    }
    @keyframes pulse-badge {
      0%, 100% { transform: scale(1); }
      50% { transform: scale(1.15); }
    }

    /* Dropdown notification */
    .notif-dropdown {
      position: absolute; top: calc(100% + 10px); right: 0;
      width: 360px; background: #fff;
      border: 1px solid #e5e7eb; border-radius: 1rem;
      box-shadow: 0 12px 40px rgba(0,0,0,.12);
      z-index: 300; overflow: hidden;
    }
    .notif-header {
      padding: .85rem 1.1rem;
      border-bottom: 1px solid #f3f4f6;
      display: flex; align-items: center; justify-content: space-between;
    }
    .notif-header h6 { margin: 0; font-weight: 700; font-size: .875rem; }
    .notif-list { max-height: 340px; overflow-y: auto; }
    .notif-item {
      display: flex; align-items: flex-start; gap: .75rem;
      padding: .85rem 1.1rem; border-bottom: 1px solid #f9fafb;
      transition: background .12s; text-decoration: none;
    }
    .notif-item:hover { background: #f9fafb; }
    .notif-icon {
      width: 38px; height: 38px; border-radius: 50%;
      background: #fef9c3; display: flex; align-items: center;
      justify-content: center; color: #ca8a04; font-size: 1rem; flex-shrink: 0;
    }
    .notif-icon.green { background: #dcfce7; color: #16a34a; }
    .notif-body { font-size: .8rem; color: #374151; line-height: 1.4; }
    .notif-body strong { display: block; color: #111827; font-size: .825rem; }
    .notif-time { font-size: .7rem; color: #9ca3af; margin-top: .15rem; }
    .notif-empty { padding: 2rem 1rem; text-align: center; color: #9ca3af; font-size: .85rem; }
    .notif-footer {
      padding: .65rem 1.1rem; text-align: center;
      border-top: 1px solid #f3f4f6;
    }
    .notif-footer a { font-size: .8rem; color: #5ab832; text-decoration: none; font-weight: 600; }

    /* ── Main ────────────────────────────────── */
    .main-content {
      margin-left: var(--sidebar-width);
      padding: 2rem 2.25rem;
      padding-top: calc(60px + 2rem);
      min-height: 100vh;
    }

    /* ── Stat cards ──────────────────────────── */
    .card-blue {
      background: linear-gradient(135deg, #7ed957 0%, #5ab832 100%);
      border-radius: 1rem; color: #fff; padding: 1.5rem; border: none;
    }
    .card-white {
      background: #fff; border-radius: 1rem; padding: 1.5rem;
      border: none; box-shadow: 0 1px 4px rgba(0,0,0,.06);
    }
    .icon-box-blue {
      width: 48px; height: 48px; background: #f2ffe8;
      border-radius: 0.75rem; display: flex; align-items: center;
      justify-content: center; color: #5ab832; font-size: 1.35rem; flex-shrink: 0;
    }
    .icon-box-green {
      width: 48px; height: 48px; background: #f2ffe8;
      border-radius: 0.75rem; display: flex; align-items: center;
      justify-content: center; color: #5ab832; font-size: 1.35rem; flex-shrink: 0;
    }
    .icon-box-sm {
      width: 36px; height: 36px; background: rgba(255,255,255,0.2);
      border-radius: 0.5rem; display: flex; align-items: center;
      justify-content: center; font-size: 1.1rem; flex-shrink: 0;
    }
    .divider-white { border-top: 1px solid rgba(255,255,255,0.2); margin: 1rem 0; }

    /* ── Action buttons ──────────────────────── */
    .action-link {
      display: flex; align-items: center; gap: 0.75rem;
      padding: 0.85rem 1rem; border: 1.5px solid #e9ecef;
      border-radius: 0.75rem; color: #374151; font-size: 0.875rem;
      font-weight: 500; text-decoration: none; transition: all 0.15s;
    }
    .action-link:hover { border-color: #7ed957; color: #5ab832; background: #f2ffe8; }
    .action-link i { color: #7ed957; font-size: 1.05rem; }

    /* ── Demandes table ──────────────────────── */
    .demande-card {
      background: #fff; border-radius: 1rem;
      border: none; box-shadow: 0 1px 4px rgba(0,0,0,.06);
      overflow: hidden;
    }
    .demande-card-header {
      padding: 1.1rem 1.5rem;
      border-bottom: 1px solid #f3f4f6;
      display: flex; align-items: center; justify-content: space-between;
    }
    .demande-card-header h6 { margin: 0; font-weight: 700; font-size: .95rem; }

    .table-demandes { margin: 0; }
    .table-demandes th {
      font-size: .72rem; font-weight: 700; text-transform: uppercase;
      letter-spacing: .06em; color: #9ca3af; background: #f9fafb;
      border-bottom: 1px solid #f3f4f6; padding: .65rem 1.25rem;
    }
    .table-demandes td {
      padding: 1rem 1.25rem; vertical-align: middle;
      border-bottom: 1px solid #f9fafb; font-size: .875rem; color: #374151;
    }
    .table-demandes tr:last-child td { border-bottom: none; }

    .pharma-avatar {
      width: 38px; height: 38px; border-radius: .5rem;
      background: linear-gradient(135deg, #f0fdf4, #dcfce7);
      display: flex; align-items: center; justify-content: center;
      font-weight: 700; font-size: .85rem; color: #16a34a; flex-shrink: 0;
    }
    .pharma-avatar img { width: 100%; height: 100%; object-fit: cover; border-radius: .5rem; }

    .badge-attente {
      background: #fef9c3; color: #854d0e; border: 1px solid #fde68a;
      border-radius: 2rem; padding: .2rem .65rem; font-size: .72rem; font-weight: 700;
    }
    .badge-garde {
      background: #dcfce7; color: #15803d; border: 1px solid #86efac;
      border-radius: 2rem; padding: .2rem .55rem; font-size: .7rem; font-weight: 600;
    }

    .btn-approuver {
      background: #7ed957; color: #fff; border: none;
      border-radius: .45rem; padding: .35rem .8rem;
      font-size: .78rem; font-weight: 600; cursor: pointer;
      transition: background .15s; display: inline-flex; align-items: center; gap: .25rem;
    }
    .btn-approuver:hover { background: #5ab832; }
    .btn-refuser {
      background: none; border: 1.5px solid #fca5a5; color: #dc2626;
      border-radius: .45rem; padding: .35rem .8rem;
      font-size: .78rem; font-weight: 600; cursor: pointer;
      transition: all .15s; display: inline-flex; align-items: center; gap: .25rem;
    }
    .btn-refuser:hover { background: #fef2f2; }

    /* Alert success */
    .alert-success-custom {
      background: #f0fdf4; border: 1px solid #86efac; border-radius: .65rem;
      padding: .75rem 1.1rem; color: #15803d; font-size: .875rem;
      display: flex; align-items: center; gap: .5rem; margin-bottom: 1.25rem;
    }
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
          <a href="{{ route('admin.dashboard') }}" class="nav-link active">
            <i class="ti ti-layout-dashboard" style="color:#7ed957;"></i> Vue Globale
          </a>
        </li>
        <li>
          <a href="{{ route('admin.pharmacies') }}" class="nav-link">
            <i class="ti ti-pill" style="color:#7ed957;"></i> Pharmacies
          </a>
        </li>
        <li>
          <a href="{{ route('admin.demandes.pharmacies') }}" class="nav-link d-flex justify-content-between align-items-center">
            <span class="d-flex align-items-center gap-2">
              <i class="ti ti-clock-hour-4" style="color:#7ed957;"></i> Demandes
            </span>
            @if($stats['pharmacies_attente'] > 0)
              <span style="background:#dc2626;color:#fff;border-radius:999px;font-size:.65rem;font-weight:700;padding:.1rem .45rem;min-width:18px;text-align:center;">
                {{ $stats['pharmacies_attente'] }}
              </span>
            @endif
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

  <!-- ═══ TOPBAR ═══════════════════════════════════════════════════ -->
  <header class="topbar">
    <div class="topbar-title">
      Vue Globale Plateforme
    </div>
    <div class="topbar-actions">

      <!-- Cloche de notification -->
      <div class="position-relative" id="notifWrapper">
        <button class="notif-btn" id="notifToggle" onclick="toggleNotif()" title="Notifications">
          <i class="ti ti-bell"></i>
          @if($stats['pharmacies_attente'] > 0)
            <span class="notif-badge">{{ $stats['pharmacies_attente'] }}</span>
          @endif
        </button>

        <!-- Dropdown -->
        <div class="notif-dropdown" id="notifDropdown" style="display:none;">
          <div class="notif-header">
            <h6>Notifications</h6>
            @if($stats['pharmacies_attente'] > 0)
              <span style="background:#fef9c3;color:#854d0e;border-radius:999px;font-size:.7rem;font-weight:700;padding:.15rem .55rem;">
                {{ $stats['pharmacies_attente'] }} en attente
              </span>
            @endif
          </div>
          <div class="notif-list">
            @forelse($demandesEnAttente as $demande)
              <div class="notif-item">
                <div class="notif-icon">
                  <i class="ti ti-building-store"></i>
                </div>
                <div class="notif-body">
                  <strong>Nouvelle demande de pharmacie</strong>
                  <span style="color:#7ed957;">{{ $demande->nom }}</span> souhaite rejoindre le réseau PharmaNet.
                  <div class="notif-time">
                    <i class="ti ti-clock me-1"></i>{{ $demande->created_at->diffForHumans() }}
                    @if($demande->numero_agrement)
                      · Agrément : {{ $demande->numero_agrement }}
                    @endif
                  </div>
                </div>
              </div>
            @empty
              <div class="notif-empty">
                <i class="ti ti-bell-off" style="font-size:1.5rem;display:block;margin-bottom:.4rem;"></i>
                Aucune nouvelle notification
              </div>
            @endforelse
          </div>
          @if($demandesEnAttente->count() > 0)
            <div class="notif-footer">
              <a href="{{ route('admin.demandes.pharmacies') }}">Voir toutes les demandes →</a>
            </div>
          @endif
        </div>
      </div>

      <!-- Avatar admin -->
      <div class="d-flex align-items-center gap-2">
        <div style="width:36px;height:36px;border-radius:50%;background:#7ed957;color:#fff;font-weight:700;font-size:.8rem;display:flex;align-items:center;justify-content:center;">
          {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>
        <div class="d-none d-md-block" style="font-size:.825rem;">
          <div class="fw-semibold" style="line-height:1.2;">{{ Auth::user()->name }}</div>
          <div style="color:#9ca3af;font-size:.72rem;">Administrateur</div>
        </div>
      </div>

    </div>
  </header>

  <!-- ═══ CONTENU PRINCIPAL ════════════════════════════════════════ -->
  <main class="main-content">

    @if(session('success'))
      <div class="alert-success-custom">
        <i class="ti ti-circle-check"></i> {{ session('success') }}
      </div>
    @endif

    <!-- Statistiques -->
    <div class="row g-3 mb-4">

      <!-- Total Pharmacies -->
      <div class="col-12 col-md-4">
        <div class="card-blue">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <p class="mb-0 small" style="opacity:.8;">Total Pharmacies</p>
            <div class="icon-box-sm"><i class="ti ti-pill text-white"></i></div>
          </div>
          <h2 class="fw-bold text-white mb-0" style="font-size:2.25rem;">{{ $stats['pharmacies_total'] }}</h2>
          <div class="divider-white"></div>
          <div class="d-flex justify-content-between text-center">
            <div>
              <div class="fw-bold small text-white">{{ $stats['pharmacies_actives'] }}</div>
              <div style="opacity:.7;font-size:.75rem;">Actives</div>
            </div>
            <div>
              <div class="fw-bold small text-white">{{ $stats['pharmacies_attente'] }}</div>
              <div style="opacity:.7;font-size:.75rem;">En attente</div>
            </div>
            <div>
              <div class="fw-bold small text-white">{{ $stats['pharmacies_suspendues'] }}</div>
              <div style="opacity:.7;font-size:.75rem;">Suspendues</div>
            </div>
          </div>
        </div>
      </div>

      <!-- Total Clients -->
      <div class="col-12 col-md-4">
        <div class="card-white h-100 d-flex align-items-center">
          <div class="d-flex align-items-center gap-3">
            <div class="icon-box-blue"><i class="ti ti-users"></i></div>
            <div>
              <p class="text-muted small mb-1">Total Clients</p>
              <h2 class="fw-bold mb-0" style="font-size:2.25rem;">{{ $stats['clients_total'] }}</h2>
            </div>
          </div>
        </div>
      </div>

      <!-- Commandes -->
      <div class="col-12 col-md-4">
        <div class="card-white h-100 d-flex align-items-center">
          <div class="d-flex align-items-center gap-3">
            <div class="icon-box-green"><i class="ti ti-shopping-bag"></i></div>
            <div>
              <p class="text-muted small mb-1">Commandes (Ce mois)</p>
              <h2 class="fw-bold mb-0" style="font-size:2.25rem;">{{ $stats['commandes_mois'] }}</h2>
              <small class="text-muted">{{ $stats['commandes_semaine'] }} cette semaine</small>
            </div>
          </div>
        </div>
      </div>

    </div>

    <!-- ═══ Demandes en attente ═══════════════════════════════════ -->
    @if($demandesEnAttente->count() > 0)
    <div class="demande-card mb-4">
      <div class="demande-card-header">
        <div class="d-flex align-items-center gap-2">
          <i class="ti ti-clock-hour-4" style="color:#ca8a04;font-size:1.1rem;"></i>
          <h6>Demandes d'inscription en attente</h6>
          <span class="badge-attente">{{ $demandesEnAttente->count() }} nouvelle{{ $demandesEnAttente->count() > 1 ? 's' : '' }}</span>
        </div>
        <a href="{{ route('admin.demandes.pharmacies') }}" style="font-size:.8rem;color:#5ab832;text-decoration:none;font-weight:600;">
          Voir tout →
        </a>
      </div>

      <div class="table-responsive">
        <table class="table table-demandes">
          <thead>
            <tr>
              <th>Pharmacie</th>
              <th>Responsable</th>
              <th>Contact</th>
              <th>Agrément</th>
              <th>Garde</th>
              <th>Reçue le</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @foreach($demandesEnAttente as $demande)
            <tr>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div class="pharma-avatar">
                    @if($demande->logo)
                      <img src="{{ Storage::url($demande->logo) }}" alt="{{ $demande->nom }}">
                    @else
                      {{ strtoupper(substr($demande->nom, 0, 2)) }}
                    @endif
                  </div>
                  <div>
                    <div class="fw-semibold" style="font-size:.85rem;">{{ $demande->nom }}</div>
                    <div class="text-muted" style="font-size:.75rem;">{{ Str::limit($demande->adresse, 30) }}</div>
                  </div>
                </div>
              </td>
              <td>{{ $demande->user->name ?? '—' }}</td>
              <td>
                <div style="font-size:.8rem;">{{ $demande->user->email ?? '—' }}</div>
                @if($demande->telephone)
                  <div class="text-muted" style="font-size:.75rem;">{{ $demande->telephone }}</div>
                @endif
              </td>
              <td>
                @if($demande->numero_agrement)
                  <span style="font-family:monospace;font-size:.8rem;background:#f3f4f6;padding:.15rem .45rem;border-radius:.3rem;">
                    {{ $demande->numero_agrement }}
                  </span>
                @else
                  <span class="text-muted" style="font-size:.8rem;">Non fourni</span>
                @endif
              </td>
              <td>
                @if($demande->garde)
                  <span class="badge-garde"><i class="ti ti-moon me-1"></i>Oui</span>
                @else
                  <span class="text-muted" style="font-size:.78rem;">Non</span>
                @endif
              </td>
              <td>
                <span style="font-size:.8rem;">{{ $demande->created_at->format('d/m/Y') }}</span>
                <div class="text-muted" style="font-size:.72rem;">{{ $demande->created_at->diffForHumans() }}</div>
              </td>
              <td>
                <div class="d-flex gap-2">
                  <form method="POST" action="{{ route('admin.pharmacies.approuver', $demande) }}">
                    @csrf
                    <button type="submit" class="btn-approuver" title="Approuver">
                      <i class="ti ti-check"></i> Approuver
                    </button>
                  </form>
                  <form method="POST" action="{{ route('admin.pharmacies.refuser', $demande) }}">
                    @csrf
                    <button type="submit" class="btn-refuser" title="Refuser"
                      onclick="return confirm('Refuser la demande de {{ addslashes($demande->nom) }} ?')">
                      <i class="ti ti-x"></i> Refuser
                    </button>
                  </form>
                </div>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    @endif

    <!-- Actions Rapides -->
    <div class="row">
      <div class="col-12 col-md-6 col-lg-5">
        <div class="card-white">
          <h6 class="fw-bold mb-3">Actions Rapides</h6>
          <div class="d-flex flex-column gap-2">
            <a href="{{ route('admin.pharmacies') }}" class="action-link">
              <i class="ti ti-pill"></i> Gérer les pharmacies
            </a>
            <a href="{{ route('admin.demandes.pharmacies') }}" class="action-link">
              <i class="ti ti-clock-hour-4"></i> Demandes en attente
              @if($stats['pharmacies_attente'] > 0)
                <span class="ms-auto" style="background:#fef9c3;color:#854d0e;border-radius:999px;font-size:.68rem;font-weight:700;padding:.1rem .45rem;">
                  {{ $stats['pharmacies_attente'] }}
                </span>
              @endif
            </a>
            <a href="#" class="action-link"><i class="ti ti-users"></i> Gérer les utilisateurs</a>
            <a href="#" class="action-link"><i class="ti ti-chart-bar"></i> Rapports de la plateforme</a>
          </div>
        </div>
      </div>
    </div>

  </main>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    function toggleNotif() {
      const dd = document.getElementById('notifDropdown');
      dd.style.display = dd.style.display === 'none' ? 'block' : 'none';
    }

    // Ferme le dropdown en cliquant ailleurs
    document.addEventListener('click', function(e) {
      const wrapper = document.getElementById('notifWrapper');
      if (wrapper && !wrapper.contains(e.target)) {
        document.getElementById('notifDropdown').style.display = 'none';
      }
    });
  </script>
</body>
</html>
