<style>
  :root { --sidebar-width: 230px; }
  body  { background: #f5f6fa; margin: 0; font-family: system-ui, -apple-system, sans-serif; }

  /* ── Sidebar ────────────────────────────── */
  .sidebar {
    position: fixed; top: 0; left: 0;
    width: var(--sidebar-width); height: 100vh;
    background: #fff; border-right: 1px solid #e9ecef;
    display: flex; flex-direction: column; z-index: 100;
  }
  .sidebar-logo { padding: 1.25rem 1rem; border-bottom: 1px solid #f0f0f0; }
  .sidebar-nav  { flex: 1; padding: 1rem 0.75rem; overflow-y: auto; }
  .sidebar-nav .nav-link {
    display: flex; align-items: center; gap: 0.65rem;
    padding: 0.6rem 0.85rem; border-radius: 0.5rem;
    color: #6c757d; font-size: 0.875rem; font-weight: 500;
    transition: all 0.15s; margin-bottom: 0.125rem; text-decoration: none;
  }
  .sidebar-nav .nav-link:hover  { background: #f2ffe8; color: #5ab832; }
  .sidebar-nav .nav-link.active { background: #f2ffe8; color: #5ab832; }
  .sidebar-nav .nav-link i { font-size: 1.1rem; flex-shrink: 0; color: #7ed957; }

  .sidebar-footer { padding: 0.75rem; border-top: 1px solid #f0f0f0; }
  .avatar-initials {
    width: 42px; height: 42px; border-radius: 50%;
    background: #7ed957; color: #fff; font-weight: 700;
    font-size: 0.85rem; display: flex; align-items: center;
    justify-content: center; flex-shrink: 0;
  }
  .btn-logout {
    display: flex; align-items: center; gap: 0.5rem;
    color: #dc3545; background: none; border: none;
    font-size: 0.875rem; font-weight: 500;
    padding: 0.55rem 0.85rem; border-radius: 0.5rem;
    width: 100%; cursor: pointer; text-align: left; margin-top: 0.5rem;
  }
  .btn-logout:hover { background: #fff0f0; }

  /* ── Main ───────────────────────────────── */
  .main-content { margin-left: var(--sidebar-width); padding: 2rem 2.25rem; min-height: 100vh; }

  /* ── Stat cards ─────────────────────────── */
  .stat-card {
    background: #fff; border-radius: 1rem; padding: 1.25rem;
    box-shadow: 0 1px 4px rgba(0,0,0,.06);
    display: flex; align-items: center; gap: 1rem;
  }
  .stat-icon {
    width: 48px; height: 48px; border-radius: 0.75rem;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.35rem; flex-shrink: 0;
  }
  .stat-label { color: #6c757d; font-size: 0.78rem; margin: 0 0 0.2rem; }
  .stat-value { font-size: 1.75rem; font-weight: 700; margin: 0; color: #111; }

  /* ── White cards ─────────────────────────── */
  .card-white {
    background: #fff; border-radius: 1rem; padding: 1.5rem;
    box-shadow: 0 1px 4px rgba(0,0,0,.06);
  }

  /* ── Table ──────────────────────────────── */
  .table-clean { width: 100%; border-collapse: collapse; font-size: 0.875rem; }
  .table-clean thead th {
    color: #6c757d; font-size: 0.78rem; font-weight: 600;
    padding: 0 0 0.65rem; border-bottom: 1px solid #f0f0f0;
    text-align: left;
  }
  .table-clean tbody td {
    padding: 0.75rem 0; border-bottom: 1px solid #f8f8f8;
    color: #374151; vertical-align: middle;
  }
  .table-clean tbody tr:last-child td { border-bottom: none; }
  .table-clean tbody tr:hover td { background: #fafafa; }
  .empty-cell { text-align: center; color: #9ca3af; padding: 2rem 0 !important; font-size: 0.875rem; }

  /* ── Badges statut ──────────────────────── */
  .badge-statut {
    display: inline-flex; align-items: center; gap: 0.3rem;
    padding: 0.2rem 0.6rem; border-radius: 9999px;
    font-size: 0.75rem; font-weight: 600;
  }
  .badge-en_attente  { background: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; }
  .badge-confirmee   { background: #eff4ff; color: #2563eb; border: 1px solid #bfdbfe; }
  .badge-livree      { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
  .badge-annulee     { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }

  /* ── Misc ───────────────────────────────── */
  .link-green { color: #5ab832; text-decoration: none; font-weight: 500; }
  .link-green:hover { text-decoration: underline; }

  /* Form controls */
  .form-control, .form-select {
    border: 1.5px solid #e5e7eb; border-radius: 0.65rem;
    padding: 0.6rem 0.85rem; font-size: 0.875rem; color: #111;
    transition: border-color .2s, box-shadow .2s;
  }
  .form-control:focus, .form-select:focus {
    border-color: #7ed957; box-shadow: 0 0 0 3px rgba(126,217,87,.18); outline: none;
  }
  .form-label { font-size: .82rem; font-weight: 600; color: #374151; margin-bottom: .35rem; }

  .btn-green {
    background: linear-gradient(135deg, #7ed957, #5ab832);
    color: #fff; border: none; border-radius: 0.65rem;
    padding: 0.65rem 1.5rem; font-size: 0.9rem; font-weight: 600;
    cursor: pointer; transition: opacity .2s;
  }
  .btn-green:hover { opacity: .9; }

  .section-label {
    font-size: .72rem; font-weight: 700; text-transform: uppercase;
    letter-spacing: .07em; color: #9ca3af;
    margin-bottom: .75rem; margin-top: 1.25rem;
    display: flex; align-items: center; gap: .5rem;
  }
  .section-label::after { content: ''; flex: 1; height: 1px; background: #f0f0f0; }

  .alert-success {
    background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 0.65rem;
    padding: 0.75rem 1rem; color: #16a34a; font-size: 0.875rem;
    display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.25rem;
  }

  /* Filter tabs */
  .filter-tabs {
    display: flex; gap: .25rem; background: #fff;
    border: 1px solid #e9ecef; border-radius: .6rem;
    padding: .25rem; width: fit-content;
  }
  .filter-tab {
    padding: .4rem 1rem; border-radius: .45rem;
    font-size: .85rem; font-weight: 500; color: #6c757d;
    border: none; background: none; cursor: pointer; transition: all .15s;
  }
  .filter-tab.active {
    background: #fff; color: #111;
    box-shadow: 0 1px 3px rgba(0,0,0,.12); border: 1px solid #e0e0e0;
  }
  .filter-tab:not(.active):hover { color: #5ab832; }

  .search-wrapper { position: relative; }
  .search-wrapper i { position: absolute; left: .65rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1rem; }
  .search-input {
    border: 1px solid #e9ecef; border-radius: .6rem;
    padding: .45rem .85rem .45rem 2.25rem;
    font-size: .875rem; background: #fff; color: #374151;
    outline: none; width: 240px;
  }
  .search-input:focus { border-color: #7ed957; box-shadow: 0 0 0 3px rgba(126,217,87,.15); }

  @media (max-width: 768px) {
    .sidebar { transform: translateX(-100%); }
    .main-content { margin-left: 0; padding: 1.25rem; }
  }
</style>
