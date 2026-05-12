<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>PharmaNet — Connexion</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; }
    html, body {
      height: 100%; margin: 0;
      font-family: system-ui, -apple-system, sans-serif;
      background: #eef2f7;
      display: flex; align-items: center; justify-content: center;
      min-height: 100vh;
    }

    /* ── Conteneur carte ── */
    .login-wrap {
      display: flex;
      width: 92%; max-width: 960px;
      min-height: 560px;
      border-radius: 1.5rem;
      overflow: hidden;
      box-shadow: 0 24px 64px rgba(0,0,0,.14);
    }

    /* ── Panneau gauche ── */
    .panel-left {
      width: 46%;
      background: linear-gradient(150deg, #14532d 0%, #166534 45%, #15803d 100%);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 2.5rem 2rem;
      position: relative;
      overflow: hidden;
    }

    /* Cercles décoratifs */
    .panel-left::before {
      content: '';
      position: absolute; width: 320px; height: 320px; border-radius: 50%;
      background: rgba(134,239,172,.08);
      top: -80px; left: -80px;
    }
    .panel-left::after {
      content: '';
      position: absolute; width: 220px; height: 220px; border-radius: 50%;
      background: rgba(134,239,172,.07);
      bottom: -50px; right: -50px;
    }

    .panel-left .illus-wrap {
      position: relative; z-index: 2;
      width: 100%; display: flex; flex-direction: column; align-items: center; gap: 1.75rem;
    }

    .panel-left .brand {
      display: flex; align-items: center; gap: .6rem;
    }
    .panel-left .brand-name {
      font-size: 1.25rem; font-weight: 800; color: #fff;
    }
    .panel-left .brand-name span { color: #86efac; }

    .panel-left img.illus {
      width: 88%;
      border-radius: 1rem;
      box-shadow: 0 10px 36px rgba(0,0,0,.32);
      display: block;
    }

    .panel-left .tagline {
      text-align: center;
    }
    .panel-left .tagline h2 {
      color: #fff; font-size: 1.2rem; font-weight: 700; line-height: 1.35; margin-bottom: .35rem;
    }
    .panel-left .tagline p {
      color: rgba(255,255,255,.6); font-size: .83rem; margin: 0;
    }

    /* ── Panneau droit ── */
    .panel-right {
      width: 54%;
      background: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 3rem 2.5rem;
    }

    .form-inner {
      width: 100%; max-width: 380px;
    }

    /* Logo top */
    .form-logo {
      display: flex; align-items: center; gap: .5rem;
      justify-content: center; margin-bottom: 2rem;
    }
    .form-logo-text { font-size: 1rem; font-weight: 800; color: #111; }
    .form-logo-text span { color: #16a34a; }

    .form-inner h3 {
      font-size: 1.75rem; font-weight: 800; color: #111;
      margin-bottom: .3rem;
    }
    .form-inner .subtitle {
      font-size: .875rem; color: #9ca3af; margin-bottom: 1.75rem;
    }

    /* Champs */
    .form-label {
      font-size: .82rem; font-weight: 600; color: #374151; margin-bottom: .35rem;
    }
    .form-control {
      border: 1.5px solid #e5e7eb; border-radius: .65rem;
      padding: .65rem .9rem; font-size: .9rem;
      transition: border-color .2s, box-shadow .2s; color: #111;
      background: #fafafa;
    }
    .form-control:focus {
      border-color: #16a34a; box-shadow: 0 0 0 3px rgba(22,163,74,.15);
      outline: none; background: #fff;
    }
    .form-control.is-invalid { border-color: #ef4444; }

    .input-icon-wrap { position: relative; }
    .input-icon-wrap i {
      position: absolute; right: .85rem; top: 50%;
      transform: translateY(-50%); color: #9ca3af; font-size: 1.05rem; cursor: pointer;
    }

    /* Checkbox + lien */
    .check-label {
      font-size: .83rem; color: #6c757d; cursor: pointer; user-select: none;
    }
    .form-check-input:checked { background-color: #16a34a; border-color: #16a34a; }
    .form-check-input:focus   { box-shadow: 0 0 0 3px rgba(22,163,74,.18); }

    .forgot-link {
      font-size: .83rem; color: #16a34a; text-decoration: none; font-weight: 600;
    }
    .forgot-link:hover { text-decoration: underline; }

    /* Bouton */
    .btn-login {
      background: #16a34a;
      color: #fff; border: none; border-radius: .65rem;
      padding: .8rem; font-size: .95rem; font-weight: 700;
      width: 100%; cursor: pointer;
      transition: background .15s, transform .1s;
      letter-spacing: .01em;
    }
    .btn-login:hover  { background: #15803d; }
    .btn-login:active { transform: scale(.99); }

    /* Alertes */
    .alert-success {
      background: #f0fdf4; border: 1px solid #86efac; border-radius: .65rem;
      padding: .7rem 1rem; font-size: .85rem; color: #15803d;
      margin-bottom: 1.1rem; display: flex; align-items: flex-start; gap: .5rem;
    }
    .alert-error {
      background: #fef2f2; border: 1px solid #fecaca; border-radius: .65rem;
      padding: .7rem 1rem; font-size: .85rem; color: #dc2626;
      margin-bottom: 1.1rem; display: flex; align-items: center; gap: .5rem;
    }
    .error-text { font-size: .78rem; color: #ef4444; margin-top: .2rem; }

    .divider { height: 1px; background: #f3f4f6; margin: 1.5rem 0; }

    /* Responsive */
    @media (max-width: 768px) {
      body { align-items: flex-start; }
      .login-wrap { flex-direction: column; width: 100%; min-height: 100vh; border-radius: 0; }
      .panel-left  { width: 100%; padding: 2rem; }
      .panel-left img.illus { width: 70%; }
      .panel-right { width: 100%; }
    }
  </style>
</head>
<body>

<div class="login-wrap">

  <!-- ══ PANNEAU GAUCHE ══ -->
  <div class="panel-left">
    <div class="illus-wrap">

      <!-- Logo -->
      <div class="brand">
        <svg width="42" height="42" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <clipPath id="pill-left-A">
              <rect x="0" y="0" width="50" height="100"/>
            </clipPath>
          </defs>
          <g transform="translate(50,50) rotate(-35) translate(-50,-50)">
            <rect x="7" y="29" width="86" height="42" rx="21" fill="white" stroke="#111" stroke-width="6"/>
            <rect x="7" y="29" width="86" height="42" rx="21" fill="#4ade80" clip-path="url(#pill-left-A)"/>
            <line x1="50" y1="28" x2="50" y2="72" stroke="#111" stroke-width="5"/>
            <rect x="7" y="29" width="86" height="42" rx="21" fill="none" stroke="#111" stroke-width="6"/>
          </g>
        </svg>
        <span class="brand-name">Pharma<span>Net</span></span>
      </div>

      <!-- Image pharmacie -->
      <img src="{{ asset('8274966_3850595.jpg') }}" alt="Comptoir de pharmacie" class="illus">

      <!-- Tagline -->
      <div class="tagline">
        <h2>Votre réseau pharmaceutique connecté</h2>
        <p>Les pharmacies de votre région, réunies sur une seule plateforme.</p>
      </div>

    </div>
  </div>

  <!-- ══ PANNEAU DROIT ══ -->
  <div class="panel-right">
    <div class="form-inner">

      <!-- Logo top -->
      <div class="form-logo">
        <svg width="38" height="38" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <clipPath id="pill-left-B">
              <rect x="0" y="0" width="50" height="100"/>
            </clipPath>
          </defs>
          <g transform="translate(50,50) rotate(-35) translate(-50,-50)">
            <rect x="7" y="29" width="86" height="42" rx="21" fill="white" stroke="#111" stroke-width="6"/>
            <rect x="7" y="29" width="86" height="42" rx="21" fill="#4ade80" clip-path="url(#pill-left-B)"/>
            <line x1="50" y1="28" x2="50" y2="72" stroke="#111" stroke-width="5"/>
            <rect x="7" y="29" width="86" height="42" rx="21" fill="none" stroke="#111" stroke-width="6"/>
          </g>
        </svg>
        <span class="form-logo-text">Pharma<span>Net</span></span>
      </div>

      <h3>Connexion</h3>
      <p class="subtitle">Bienvenue. Identifiez-vous pour accéder à votre espace.</p>

      @if (session('pharmacie_registered'))
        <div class="alert-success">
          <i class="ti ti-circle-check" style="flex-shrink:0;font-size:1.1rem;margin-top:.05rem;"></i>
          <span>{{ session('pharmacie_registered') }}</span>
        </div>
      @endif

      @if (session('status'))
        <div class="alert-error">
          <i class="ti ti-info-circle"></i> {{ session('status') }}
        </div>
      @endif

      @if ($errors->any())
        <div class="alert-error">
          <i class="ti ti-alert-circle"></i> {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
          <label for="email" class="form-label">Email <span style="color:#ef4444;">*</span></label>
          <div class="input-icon-wrap">
            <input id="email" type="email" name="email" value="{{ old('email') }}"
              class="form-control @error('email') is-invalid @enderror"
              placeholder="exemple@email.com" required autofocus autocomplete="username">
            <i class="ti ti-mail"></i>
          </div>
          @error('email')<div class="error-text">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Mot de passe <span style="color:#ef4444;">*</span></label>
          <div class="input-icon-wrap">
            <input id="password" type="password" name="password"
              class="form-control @error('password') is-invalid @enderror"
              placeholder="••••••••" required autocomplete="current-password">
            <i class="ti ti-eye" id="togglePwd" onclick="togglePassword()"></i>
          </div>
          @error('password')<div class="error-text">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
            <label class="check-label" for="remember_me">Se souvenir de moi</label>
          </div>
          @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="forgot-link">Mot de passe oublié ?</a>
          @endif
        </div>

        <button type="submit" class="btn-login">
          <i class="ti ti-login me-1"></i> Se connecter
        </button>

      </form>

      <div class="divider"></div>

      <p class="text-center mb-2" style="font-size:.875rem;color:#9ca3af;">
        Pas encore de compte ?
        <a href="{{ route('register') }}" class="forgot-link">Créer un compte</a>
      </p>

      <p class="text-center mb-0" style="font-size:.875rem;color:#9ca3af;">
        Vous êtes pharmacien ?
        <a href="{{ route('pharmacie.register') }}" class="forgot-link">Inscrire votre pharmacie</a>
      </p>

    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function togglePassword() {
    const pwd = document.getElementById('password');
    const ico = document.getElementById('togglePwd');
    pwd.type = pwd.type === 'password' ? 'text' : 'password';
    ico.classList.toggle('ti-eye');
    ico.classList.toggle('ti-eye-off');
  }
</script>
</body>
</html>
