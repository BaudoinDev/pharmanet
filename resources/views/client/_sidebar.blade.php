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
        <a href="{{ route('client.dashboard') }}" class="nav-link {{ ($active ?? '') === 'dashboard' ? 'active' : '' }}">
          <i class="ti ti-layout-dashboard"></i> Tableau de bord
        </a>
      </li>
      <li>
        <a href="{{ route('client.commandes') }}" class="nav-link {{ ($active ?? '') === 'commandes' ? 'active' : '' }}">
          <i class="ti ti-shopping-bag"></i> Mes Commandes
        </a>
      </li>
      <li>
        <a href="{{ route('client.ordonnances') }}" class="nav-link {{ ($active ?? '') === 'ordonnances' ? 'active' : '' }}">
          <i class="ti ti-file-description"></i> Mes Ordonnances
        </a>
      </li>
      <li>
        <a href="{{ route('client.profil') }}" class="nav-link {{ ($active ?? '') === 'profil' ? 'active' : '' }}">
          <i class="ti ti-settings"></i> Mon Profil
        </a>
      </li>
    </ul>
  </nav>

  <div class="sidebar-footer">
    <div class="d-flex align-items-center gap-2 px-2 mb-1">
      <div class="avatar-initials">
        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
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
