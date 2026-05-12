<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>PharmaNet — Inscription Pharmacie</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; }
    html, body { height: 100%; margin: 0; font-family: system-ui, -apple-system, sans-serif; }

    .wrap { display: flex; min-height: 100vh; }

    /* ── Panneau gauche ── */
    .panel-left {
      width: 44%;
      background: linear-gradient(160deg, #1a2e1a 0%, #2d5a1b 55%, #4a8c2a 100%);
      display: flex; flex-direction: column; justify-content: space-between;
      padding: 3rem; position: relative; overflow: hidden;
    }
    .panel-left::before {
      content: '';
      position: absolute; width: 380px; height: 380px;
      border-radius: 50%; border: 60px solid rgba(126,217,87,.08);
      top: -80px; right: -80px;
    }
    .panel-left::after {
      content: '';
      position: absolute; width: 260px; height: 260px;
      border-radius: 50%; border: 40px solid rgba(126,217,87,.06);
      bottom: -60px; left: -60px;
    }

    .panel-brand {
      display: flex; align-items: center; gap: .75rem;
      font-size: 1.4rem; font-weight: 800; color: #fff; position: relative; z-index: 1;
    }
    .panel-brand em { font-style: normal; color: #7ed957; }

    .panel-tagline { position: relative; z-index: 1; }
    .panel-tagline h2 { font-size: 1.6rem; font-weight: 800; color: #fff; margin-bottom: .75rem; line-height: 1.25; }
    .panel-tagline p  { color: rgba(255,255,255,.75); font-size: .9rem; line-height: 1.7; }

    .panel-steps { position: relative; z-index: 1; }
    .step-item {
      display: flex; align-items: flex-start; gap: .75rem;
      margin-bottom: 1rem; color: rgba(255,255,255,.85); font-size: .85rem;
    }
    .step-dot {
      width: 28px; height: 28px; border-radius: 50%;
      background: rgba(126,217,87,.25); border: 1.5px solid rgba(126,217,87,.5);
      color: #7ed957; font-weight: 700; font-size: .78rem;
      display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .step-item strong { color: #fff; display: block; margin-bottom: .1rem; }

    .panel-footer { color: rgba(255,255,255,.45); font-size: .75rem; position: relative; z-index: 1; }

    /* ── Panneau droit ── */
    .panel-right {
      flex: 1; background: #f8fafc;
      display: flex; align-items: flex-start; justify-content: center;
      padding: 2.5rem 2rem; overflow-y: auto;
    }
    .form-card {
      background: #fff; border-radius: 1rem;
      padding: 2rem 2.25rem; width: 100%; max-width: 560px;
      box-shadow: 0 2px 12px rgba(0,0,0,.07);
    }

    .form-title { font-size: 1.3rem; font-weight: 800; color: #111827; margin-bottom: .25rem; }
    .form-subtitle { font-size: .875rem; color: #6b7280; margin-bottom: 1.75rem; }

    .section-label {
      font-size: .7rem; font-weight: 700; letter-spacing: .08em;
      text-transform: uppercase; color: #9ca3af;
      border-bottom: 1px solid #f3f4f6;
      padding-bottom: .5rem; margin: 1.5rem 0 1rem;
    }
    .section-label:first-of-type { margin-top: 0; }

    .form-label { font-size: .8rem; font-weight: 600; color: #374151; margin-bottom: .35rem; }
    .form-control, .form-select {
      border: 1.5px solid #e5e7eb; border-radius: .6rem;
      font-size: .875rem; padding: .6rem .85rem; color: #111;
      transition: border-color .2s, box-shadow .2s;
    }
    .form-control:focus, .form-select:focus {
      border-color: #7ed957; box-shadow: 0 0 0 3px rgba(126,217,87,.15); outline: none;
    }
    .form-control.is-invalid { border-color: #f87171; }
    .invalid-feedback { font-size: .775rem; }

    .input-wrap { position: relative; }
    .input-wrap i.toggle-pwd {
      position: absolute; right: .75rem; top: 50%;
      transform: translateY(-50%); color: #9ca3af;
      cursor: pointer; font-size: 1rem;
    }

    /* Logo upload */
    .logo-upload-zone {
      border: 2px dashed #d1d5db; border-radius: .75rem;
      padding: 1.5rem; text-align: center; cursor: pointer;
      transition: border-color .2s, background .2s; position: relative;
    }
    .logo-upload-zone:hover { border-color: #7ed957; background: #f0fdf4; }
    .logo-upload-zone input[type="file"] {
      position: absolute; inset: 0; opacity: 0; cursor: pointer;
    }
    .logo-upload-zone i { font-size: 1.75rem; color: #9ca3af; margin-bottom: .35rem; display: block; }
    .logo-upload-zone p { font-size: .8rem; color: #6b7280; margin: 0; }
    .logo-preview {
      display: none; width: 80px; height: 80px; border-radius: .5rem;
      object-fit: cover; margin: 0 auto .5rem; border: 2px solid #e5e7eb;
    }

    /* Garde toggle */
    .garde-toggle {
      display: flex; align-items: center; justify-content: space-between;
      background: #f9fafb; border: 1.5px solid #e5e7eb;
      border-radius: .75rem; padding: .85rem 1rem;
    }
    .garde-toggle .form-check-input {
      width: 2.4rem; height: 1.3rem; cursor: pointer;
      background-color: #d1d5db; border: none; border-radius: 2rem;
    }
    .garde-toggle .form-check-input:checked { background-color: #7ed957; }

    /* Submit */
    .btn-submit {
      background: #7ed957; color: #fff; border: none;
      border-radius: .65rem; padding: .8rem; font-weight: 700;
      font-size: .95rem; width: 100%; cursor: pointer;
      transition: background .15s; display: flex; align-items: center; justify-content: center; gap: .4rem;
    }
    .btn-submit:hover { background: #5ab832; }

    /* Alert */
    .alert-error {
      background: #fef2f2; border: 1px solid #fecaca; border-radius: .65rem;
      padding: .75rem 1rem; color: #dc2626; font-size: .875rem;
      display: flex; align-items: center; gap: .5rem; margin-bottom: 1.25rem;
    }

    .divider { height: 1px; background: #f0f0f0; margin: 1.5rem 0; }

    @media (max-width: 768px) {
      .panel-left { display: none; }
      .panel-right { padding: 1.5rem 1rem; }
    }
  </style>
</head>
<body>
<div class="wrap">

  <!-- ═══ PANNEAU GAUCHE ══════════════════════════════════════════ -->
  <div class="panel-left">

    <a href="{{ url('/') }}" class="panel-brand text-decoration-none">
      <svg width="36" height="36" viewBox="0 0 402 382" xmlns="http://www.w3.org/2000/svg">
        <path fill="#7ed957" d="M271.75 127.13L178.68 34.06C160.75 16.13 136.8 6.25 111.25 6.25c-25.55 0-49.5 9.88-67.43 27.81C6.65 71.25 6.65 131.74 43.82 168.92l93.07 93.07Z"/>
        <path fill="rgba(255,255,255,0.9)" d="M111.25 11.55c-24.13 0-46.75 9.32-63.68 26.26C12.46 72.92 12.46 130.06 47.57 165.18l89.33 89.34L264.27 127.13 174.93 37.8C158.01 20.87 135.39 11.55 111.25 11.55m0-10.59c25.8 0 51.6 9.78 71.17 29.35l96.81 96.82L136.89 269.47 40.07 172.66C.93 133.51.93 69.46 40.07 30.31 59.65 10.74 85.46.96 111.25.96Z"/>
        <path fill="rgba(255,255,255,0.15)" d="M291.08 376.75c25.42 0 49.26-9.84 67.11-27.68 37.64-37.65 37.64-97.85.65-134.86l-91.89-91.88-134.86 134.86 91.88 91.88c17.85 17.84 41.69 27.68 67.11 27.68Z"/>
        <path fill="rgba(255,255,255,0.6)" d="M266.95 129.82L139.58 257.19l88.13 88.14c16.86 16.84 39.36 26.12 63.37 26.12s46.52-9.28 63.36-26.12l.64-.64c34.94-34.94 34.94-91.78 0-126.73l-88.13-88.14m0-14.97 95.62 95.62c38.97 38.97 38.97 102.73 0 141.7l-.63.63c-19.49 19.5-45.17 29.24-70.86 29.24s-51.37-9.74-70.85-29.23l-95.62-95.62Z"/>
      </svg>
      Pharma<em>Net</em>
    </a>

    <div class="panel-tagline">
      <h2>Rejoignez le réseau PharmaNet</h2>
      <p>Inscrivez votre pharmacie et donnez à vos clients la possibilité de commander leurs médicaments en ligne, 24h/24.</p>
    </div>

    <div class="panel-steps">
      <div class="step-item">
        <div class="step-dot">1</div>
        <div>
          <strong>Soumettez votre dossier</strong>
          Remplissez le formulaire avec les informations de votre pharmacie.
        </div>
      </div>
      <div class="step-item">
        <div class="step-dot">2</div>
        <div>
          <strong>Vérification par l'équipe</strong>
          Nos équipes examinent votre numéro d'agrément sous 48h.
        </div>
      </div>
      <div class="step-item">
        <div class="step-dot">3</div>
        <div>
          <strong>Accès à votre espace</strong>
          Une fois validé, gérez vos stocks, commandes et ordonnances.
        </div>
      </div>
    </div>

    <div class="panel-footer">
      PharmaNet &copy; {{ date('Y') }} — Réseau pharmaceutique numérique
    </div>

  </div>

  <!-- ═══ PANNEAU DROIT ══════════════════════════════════════════ -->
  <div class="panel-right">
    <div class="form-card">

      <h1 class="form-title">Inscrire votre pharmacie</h1>
      <p class="form-subtitle">Tous les champs marqués <span style="color:#dc2626;">*</span> sont obligatoires.</p>

      @if($errors->any())
      <div class="alert-error">
        <i class="ti ti-alert-circle"></i> {{ $errors->first() }}
      </div>
      @endif

      <form method="POST" action="{{ route('pharmacie.register.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- ── 1. Responsable ── --}}
        <div class="section-label">Responsable / Compte</div>

        <div class="mb-3">
          <label class="form-label">Nom du responsable <span style="color:#dc2626;">*</span></label>
          <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name') }}" placeholder="Dr. Kouamé Jean" required>
          @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="row g-2 mb-3">
          <div class="col-12 col-sm-6">
            <label class="form-label">Adresse e-mail <span style="color:#dc2626;">*</span></label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
              value="{{ old('email') }}" placeholder="contact@maPharmacie.com" required>
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-12 col-sm-6">
            <label class="form-label">Téléphone</label>
            <input type="tel" name="telephone" class="form-control @error('telephone') is-invalid @enderror"
              value="{{ old('telephone') }}" placeholder="+225 01 23 45 67">
            @error('telephone')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="row g-2 mb-1">
          <div class="col-12 col-sm-6">
            <label class="form-label">Mot de passe <span style="color:#dc2626;">*</span></label>
            <div class="input-wrap">
              <input type="password" name="password" id="pwd" class="form-control @error('password') is-invalid @enderror"
                placeholder="••••••••" required>
              <i class="ti ti-eye toggle-pwd" onclick="togglePwd('pwd', this)"></i>
            </div>
            @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
          </div>
          <div class="col-12 col-sm-6">
            <label class="form-label">Confirmer <span style="color:#dc2626;">*</span></label>
            <div class="input-wrap">
              <input type="password" name="password_confirmation" id="pwd2" class="form-control"
                placeholder="••••••••" required>
              <i class="ti ti-eye toggle-pwd" onclick="togglePwd('pwd2', this)"></i>
            </div>
          </div>
        </div>

        {{-- ── 2. Pharmacie ── --}}
        <div class="section-label">Informations de la pharmacie</div>

        <div class="mb-3">
          <label class="form-label">Nom de la pharmacie <span style="color:#dc2626;">*</span></label>
          <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror"
            value="{{ old('nom') }}" placeholder="Pharmacie Centrale du Plateau" required>
          @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Adresse complète <span style="color:#dc2626;">*</span></label>
          <input type="text" name="adresse" class="form-control @error('adresse') is-invalid @enderror"
            value="{{ old('adresse') }}" placeholder="12 Avenue de la République, Abidjan" required>
          @error('adresse')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Numéro d'agrément</label>
          <input type="text" name="numero_agrement" class="form-control @error('numero_agrement') is-invalid @enderror"
            value="{{ old('numero_agrement') }}" placeholder="AGR-2024-XXXXX">
          <div class="form-text text-muted" style="font-size:.75rem;">
            <i class="ti ti-info-circle me-1"></i>Requis pour la validation de votre dossier.
          </div>
          @error('numero_agrement')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        {{-- ── 3. Logo & Garde ── --}}
        <div class="section-label">Configuration</div>

        <div class="mb-3">
          <label class="form-label">Logo de la pharmacie</label>
          <div class="logo-upload-zone" id="logoZone">
            <input type="file" name="logo" id="logoInput" accept="image/jpeg,image/png,image/webp"
              onchange="previewLogo(this)">
            <img id="logoPreview" class="logo-preview" src="#" alt="Aperçu">
            <i class="ti ti-photo-up" id="logoIcon"></i>
            <p id="logoText">Cliquez ou glissez une image ici<br><span style="font-size:.72rem;color:#9ca3af;">JPG, PNG, WEBP — max 2 Mo</span></p>
          </div>
          @error('logo')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
        </div>

        <div class="mb-4">
          <label class="form-label">Pharmacie de garde</label>
          <div class="garde-toggle">
            <div>
              <div class="fw-semibold" style="font-size:.875rem;">Assurer les gardes de nuit</div>
              <div class="text-muted" style="font-size:.78rem;">Activez si votre pharmacie participe aux gardes nocturnes et jours fériés.</div>
            </div>
            <div class="form-check form-switch ms-3">
              <input class="form-check-input" type="checkbox" name="garde" id="gardeSwitch" value="1"
                {{ old('garde') ? 'checked' : '' }}>
            </div>
          </div>
        </div>

        <button type="submit" class="btn-submit">
          <i class="ti ti-send"></i> Soumettre ma demande d'inscription
        </button>

      </form>

      <div class="divider"></div>

      <p class="text-center mb-1" style="font-size:.875rem;color:#6b7280;">
        Déjà un compte ?
        <a href="{{ route('login') }}" style="color:#5ab832;font-weight:600;text-decoration:none;">Se connecter</a>
      </p>
      <p class="text-center mb-0" style="font-size:.875rem;color:#6b7280;">
        Vous êtes un patient ?
        <a href="{{ route('register') }}" style="color:#5ab832;font-weight:600;text-decoration:none;">Créer un compte client</a>
      </p>

    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePwd(id, icon) {
  const inp = document.getElementById(id);
  inp.type = inp.type === 'password' ? 'text' : 'password';
  icon.classList.toggle('ti-eye');
  icon.classList.toggle('ti-eye-off');
}

function previewLogo(input) {
  if (!input.files || !input.files[0]) return;
  const reader = new FileReader();
  reader.onload = e => {
    document.getElementById('logoPreview').src = e.target.result;
    document.getElementById('logoPreview').style.display = 'block';
    document.getElementById('logoIcon').style.display = 'none';
    document.getElementById('logoText').textContent = input.files[0].name;
  };
  reader.readAsDataURL(input.files[0]);
}

// Drag & drop highlight
const zone = document.getElementById('logoZone');
zone.addEventListener('dragover', e => { e.preventDefault(); zone.style.borderColor = '#7ed957'; zone.style.background = '#f0fdf4'; });
zone.addEventListener('dragleave', () => { zone.style.borderColor = ''; zone.style.background = ''; });
zone.addEventListener('drop', e => { zone.style.borderColor = ''; zone.style.background = ''; });
</script>
</body>
</html>
