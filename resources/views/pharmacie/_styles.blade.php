<style>
  :root { --sidebar-width: 240px; --green: #7ed957; --green-dark: #5ab832; }
  body { background: #f5f6fa; margin: 0; font-family: system-ui, -apple-system, sans-serif; }

  .sidebar {
    position: fixed; top: 0; left: 0;
    width: var(--sidebar-width); height: 100vh;
    background: #fff; border-right: 1px solid #e9ecef;
    display: flex; flex-direction: column; z-index: 100;
  }
  .sidebar-logo { padding: 1.25rem 1rem; border-bottom: 1px solid #f0f0f0; }
  .sidebar-nav { flex: 1; padding: 1rem .75rem; overflow-y: auto; }
  .sidebar-nav .nav-link {
    display: flex; align-items: center; gap: .65rem;
    padding: .6rem .85rem; border-radius: .5rem;
    color: #6c757d; font-size: .875rem; font-weight: 500;
    transition: all .15s; margin-bottom: .125rem; text-decoration: none;
  }
  .sidebar-nav .nav-link i { font-size: 1.1rem; flex-shrink: 0; color: var(--green); }
  .sidebar-nav .nav-link:hover  { background: #f2ffe8; color: var(--green-dark); }
  .sidebar-nav .nav-link.active { background: #f2ffe8; color: var(--green-dark); }
  .sidebar-footer { padding: .75rem; border-top: 1px solid #f0f0f0; }
  .avatar-initials {
    width: 40px; height: 40px; border-radius: 50%;
    background: var(--green); color: #fff; font-weight: 700;
    font-size: .85rem; display: flex; align-items: center; justify-content: center; flex-shrink: 0;
  }
  .btn-logout {
    display: flex; align-items: center; gap: .5rem;
    color: #dc3545; background: none; border: none;
    font-size: .875rem; font-weight: 500;
    padding: .55rem .85rem; border-radius: .5rem;
    width: 100%; cursor: pointer; text-align: left; margin-top: .5rem;
  }
  .btn-logout:hover { background: #fff0f0; }

  .topbar {
    position: fixed; top: 0; left: var(--sidebar-width); right: 0; height: 60px;
    background: #fff; border-bottom: 1px solid #e9ecef;
    display: flex; align-items: center; justify-content: space-between;
    padding: 0 2rem; z-index: 99;
  }
  .topbar-title { font-weight: 700; font-size: 1rem; color: #111; }
  .badge-acceptee { background: #dcfce7; color: #15803d; border: 1px solid #86efac; border-radius: 2rem; padding: .2rem .75rem; font-size: .72rem; font-weight: 700; display: inline-flex; align-items: center; gap: .3rem; }

  .main-content { margin-left: var(--sidebar-width); padding: 2rem 2.25rem; padding-top: calc(60px + 2rem); min-height: 100vh; }

  .card-white { background: #fff; border-radius: 1rem; padding: 1.5rem; box-shadow: 0 1px 4px rgba(0,0,0,.06); }
  .card-green { background: linear-gradient(135deg, var(--green) 0%, var(--green-dark) 100%); border-radius: 1rem; color: #fff; padding: 1.5rem; }

  .stat-card { background: #fff; border-radius: 1rem; padding: 1.25rem; box-shadow: 0 1px 4px rgba(0,0,0,.06); display: flex; align-items: center; gap: 1rem; }
  .stat-icon { width: 48px; height: 48px; border-radius: .75rem; display: flex; align-items: center; justify-content: center; font-size: 1.35rem; flex-shrink: 0; }
  .stat-label { color: #6c757d; font-size: .78rem; margin: 0 0 .2rem; }
  .stat-value { font-size: 1.75rem; font-weight: 700; margin: 0; color: #111; }

  .table-ph { width: 100%; border-collapse: collapse; font-size: .875rem; }
  .table-ph thead th { color: #9ca3af; font-size: .72rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; padding: .65rem 1rem; border-bottom: 1px solid #f0f0f0; text-align: left; background: #f9fafb; }
  .table-ph tbody td { padding: .85rem 1rem; border-bottom: 1px solid #f8f8f8; color: #374151; vertical-align: middle; }
  .table-ph tbody tr:last-child td { border-bottom: none; }
  .table-ph tbody tr:hover td { background: #fafafa; }
  .empty-cell { text-align: center; color: #9ca3af; padding: 3rem 1rem !important; }

  .badge-statut { display: inline-flex; align-items: center; gap: .3rem; padding: .2rem .6rem; border-radius: 9999px; font-size: .75rem; font-weight: 600; }
  .badge-en_attente { background: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; }
  .badge-confirmee  { background: #eff4ff; color: #2563eb; border: 1px solid #bfdbfe; }
  .badge-livree     { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
  .badge-annulee    { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }
  .badge-disponible { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
  .badge-rupture    { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; }

  .btn-green {
    background: var(--green); color: #fff; border: none;
    border-radius: .6rem; padding: .55rem 1.1rem;
    font-size: .875rem; font-weight: 600; cursor: pointer;
    transition: background .15s; display: inline-flex; align-items: center; gap: .4rem; text-decoration: none;
  }
  .btn-green:hover { background: var(--green-dark); color: #fff; }
  .btn-outline-green {
    background: none; border: 1.5px solid var(--green); color: var(--green-dark);
    border-radius: .6rem; padding: .5rem 1rem;
    font-size: .875rem; font-weight: 600; cursor: pointer;
    transition: all .15s; display: inline-flex; align-items: center; gap: .4rem; text-decoration: none;
  }
  .btn-outline-green:hover { background: #f2ffe8; }

  .form-control, .form-select {
    border: 1.5px solid #e5e7eb; border-radius: .6rem;
    padding: .6rem .85rem; font-size: .875rem; color: #111;
    transition: border-color .2s, box-shadow .2s;
  }
  .form-control:focus, .form-select:focus {
    border-color: var(--green); box-shadow: 0 0 0 3px rgba(126,217,87,.15); outline: none;
  }
  .form-label { font-size: .82rem; font-weight: 600; color: #374151; margin-bottom: .35rem; }

  .section-label {
    font-size: .7rem; font-weight: 700; text-transform: uppercase; letter-spacing: .08em;
    color: #9ca3af; border-bottom: 1px solid #f3f4f6; padding-bottom: .5rem; margin: 1.5rem 0 1rem;
  }

  .alert-success-ph { background: #f0fdf4; border: 1px solid #86efac; border-radius: .65rem; padding: .75rem 1rem; color: #15803d; font-size: .875rem; display: flex; align-items: center; gap: .5rem; margin-bottom: 1.25rem; }
  .alert-error-ph   { background: #fef2f2; border: 1px solid #fecaca; border-radius: .65rem; padding: .75rem 1rem; color: #dc2626; font-size: .875rem; display: flex; align-items: center; gap: .5rem; margin-bottom: 1.25rem; }
  .alert-info-ph    { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: .65rem; padding: .75rem 1rem; color: #1d4ed8; font-size: .875rem; display: flex; align-items: flex-start; gap: .5rem; margin-bottom: 1.25rem; }

  .search-wrap { position: relative; }
  .search-wrap i { position: absolute; left: .65rem; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 1rem; }
  .search-input { border: 1.5px solid #e5e7eb; border-radius: .6rem; padding: .5rem .85rem .5rem 2.2rem; font-size: .875rem; color: #374151; outline: none; width: 220px; transition: border-color .2s; }
  .search-input:focus { border-color: var(--green); }

  .filter-tabs { display: flex; gap: .25rem; background: #f3f4f6; border-radius: .6rem; padding: .2rem; }
  .filter-tab { padding: .35rem .85rem; border-radius: .45rem; font-size: .83rem; font-weight: 500; color: #6c757d; border: none; background: none; cursor: pointer; transition: all .15s; }
  .filter-tab.active { background: #fff; color: #111; box-shadow: 0 1px 3px rgba(0,0,0,.1); }
  .filter-tab:not(.active):hover { color: var(--green-dark); }

  .action-link { display: flex; align-items: center; gap: .75rem; padding: .85rem 1rem; border: 1.5px solid #e9ecef; border-radius: .75rem; color: #374151; font-size: .875rem; font-weight: 500; text-decoration: none; transition: all .15s; }
  .action-link:hover { border-color: var(--green); color: var(--green-dark); background: #f2ffe8; }
  .action-link i { color: var(--green); font-size: 1.05rem; }

  /* ── Cloche notifications ──────────────────────────────────── */
  .notif-wrap { position: relative; }
  .notif-btn {
    position: relative; background: #f5f6fa; border: none;
    width: 38px; height: 38px; border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    color: #6b7280; font-size: 1.1rem; cursor: pointer;
    transition: background .15s;
  }
  .notif-btn:hover { background: #f2ffe8; color: var(--green-dark); }
  .notif-badge {
    position: absolute; top: 3px; right: 3px;
    background: #dc2626; color: #fff; border-radius: 999px;
    font-size: .58rem; font-weight: 700;
    min-width: 16px; height: 16px;
    display: flex; align-items: center; justify-content: center;
    padding: 0 3px; border: 2px solid #fff;
    animation: pulse-badge 2s infinite;
  }
  @keyframes pulse-badge {
    0%, 100% { transform: scale(1); }
    50%       { transform: scale(1.2); }
  }
  .notif-dropdown {
    display: none; position: absolute; top: calc(100% + 10px); right: 0;
    width: 320px; background: #fff; border-radius: .85rem;
    box-shadow: 0 8px 30px rgba(0,0,0,.12); border: 1px solid #f0f0f0;
    z-index: 999; overflow: hidden;
  }
  .notif-dropdown.open { display: block; }
  .notif-header {
    padding: .85rem 1rem; border-bottom: 1px solid #f0f0f0;
    display: flex; align-items: center; justify-content: space-between;
  }
  .notif-item {
    display: flex; align-items: flex-start; gap: .75rem;
    padding: .75rem 1rem; border-bottom: 1px solid #f8f8f8;
    text-decoration: none; transition: background .1s;
  }
  .notif-item:last-child { border-bottom: none; }
  .notif-item:hover { background: #f9fffe; }
  .notif-icon {
    width: 34px; height: 34px; border-radius: .5rem; flex-shrink: 0;
    display: flex; align-items: center; justify-content: center; font-size: 1rem;
  }
  .notif-footer {
    padding: .65rem 1rem; border-top: 1px solid #f0f0f0;
    text-align: center;
  }

  @media (max-width: 768px) {
    .sidebar { transform: translateX(-100%); }
    .main-content { margin-left: 0; padding: 1.25rem; padding-top: calc(60px + 1.25rem); }
    .topbar { left: 0; }
  }
</style>
