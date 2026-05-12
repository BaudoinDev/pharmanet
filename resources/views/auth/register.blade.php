<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>PharmaNet — Inscription</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; }
    html, body { height: 100%; margin: 0; font-family: system-ui, -apple-system, sans-serif; }

    .register-wrap { display: flex; min-height: 100vh; }

    /* ── Panneau gauche ── */
    .panel-left {
      width: 44%;
      background: linear-gradient(160deg, #14532d 0%, #166534 40%, #15803d 100%);
      display: flex; flex-direction: column; align-items: center;
      justify-content: space-between;
      padding: 2.5rem 2rem;
      position: sticky; top: 0; height: 100vh;
      overflow: hidden;
    }

    .panel-brand {
      display: flex; align-items: center; gap: .65rem;
      align-self: flex-start; position: relative; z-index: 2;
    }
    .panel-brand .brand-name { font-size: 1.3rem; font-weight: 800; color: #fff; }
    .panel-brand .brand-name span { color: #86efac; }

    .panel-illustration {
      flex: 1; display: flex; align-items: center; justify-content: center;
      width: 100%; position: relative; z-index: 2;
    }

    .panel-tagline { text-align: center; position: relative; z-index: 2; padding: 0 .5rem; }
    .panel-tagline h2 { color: #fff; font-size: 1.35rem; font-weight: 700; line-height: 1.3; margin-bottom: .4rem; }
    .panel-tagline p  { color: rgba(255,255,255,.6); font-size: .85rem; margin: 0; }

    /* Orb decorations */
    .panel-left::before {
      content: ''; position: absolute;
      width: 350px; height: 350px; border-radius: 50%;
      background: rgba(134,239,172,.06);
      top: -100px; left: -100px;
    }
    .panel-left::after {
      content: ''; position: absolute;
      width: 250px; height: 250px; border-radius: 50%;
      background: rgba(134,239,172,.05);
      bottom: -60px; right: -60px;
    }

    /* ── Panneau droit ── */
    .panel-right {
      width: 56%; background: #f5f6fa;
      display: flex; align-items: flex-start; justify-content: center;
      padding: 2.5rem 2rem; overflow-y: auto;
    }

    .form-card {
      background: #fff; border-radius: 1.25rem;
      padding: 2.25rem 2rem; width: 100%; max-width: 500px;
      box-shadow: 0 4px 24px rgba(0,0,0,.07);
      margin: auto 0;
    }
    .form-card h3 { font-size: 1.4rem; font-weight: 700; color: #111; margin-bottom: .25rem; }
    .form-card .subtitle { font-size: .85rem; color: #6c757d; margin-bottom: 1.6rem; }

    .form-label { font-size: .82rem; font-weight: 600; color: #374151; margin-bottom: .3rem; }
    .form-control, .form-select {
      border: 1.5px solid #e5e7eb; border-radius: .65rem;
      padding: .58rem .85rem; font-size: .875rem;
      transition: border-color .2s, box-shadow .2s; color: #111;
    }
    .form-control:focus, .form-select:focus {
      border-color: #16a34a; box-shadow: 0 0 0 3px rgba(22,163,74,.15); outline: none;
    }
    .form-control.is-invalid, .form-select.is-invalid { border-color: #ef4444; }

    .input-icon-wrap { position: relative; }
    .input-icon-wrap i {
      position: absolute; right: .85rem; top: 50%;
      transform: translateY(-50%); color: #9ca3af; font-size: 1rem; pointer-events: none;
    }
    .input-icon-wrap .toggle-pwd { pointer-events: all; cursor: pointer; }

    .section-label {
      font-size: .7rem; font-weight: 700; text-transform: uppercase;
      letter-spacing: .07em; color: #9ca3af;
      margin-bottom: .65rem; margin-top: 1.1rem;
      display: flex; align-items: center; gap: .5rem;
    }
    .section-label::after { content: ''; flex: 1; height: 1px; background: #f0f0f0; }

    .btn-register {
      background: linear-gradient(135deg, #22c55e, #16a34a);
      color: #fff; border: none; border-radius: .65rem;
      padding: .75rem; font-size: .95rem; font-weight: 600;
      width: 100%; cursor: pointer; transition: opacity .2s, transform .1s;
    }
    .btn-register:hover  { opacity: .9; }
    .btn-register:active { transform: scale(.99); }

    .login-link { font-size: .82rem; color: #16a34a; text-decoration: none; font-weight: 600; }
    .login-link:hover { text-decoration: underline; }

    .error-text { font-size: .78rem; color: #ef4444; margin-top: .2rem; }
    .alert-error {
      background: #fef2f2; border: 1px solid #fecaca;
      border-radius: .65rem; padding: .65rem 1rem;
      font-size: .85rem; color: #dc2626; margin-bottom: 1.1rem;
      display: flex; align-items: center; gap: .5rem;
    }
    .divider { height: 1px; background: #f0f0f0; margin: 1.25rem 0; }

    @media (max-width: 768px) {
      .panel-left  { display: none; }
      .panel-right { width: 100%; }
    }
  </style>
</head>
<body>

<div class="register-wrap">

  <!-- ══ PANNEAU GAUCHE ══════════════════════════════════════════════ -->
  <div class="panel-left">

    <!-- Logo -->
    <div class="panel-brand">
      <svg width="42" height="42" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
        <defs>
          <clipPath id="pill-left-R">
            <rect x="0" y="0" width="50" height="100"/>
          </clipPath>
        </defs>
        <g transform="translate(50,50) rotate(-35) translate(-50,-50)">
          <rect x="7" y="29" width="86" height="42" rx="21" fill="white" stroke="#111" stroke-width="6"/>
          <rect x="7" y="29" width="86" height="42" rx="21" fill="#4ade80" clip-path="url(#pill-left-R)"/>
          <line x1="50" y1="28" x2="50" y2="72" stroke="#111" stroke-width="5"/>
          <rect x="7" y="29" width="86" height="42" rx="21" fill="none" stroke="#111" stroke-width="6"/>
        </g>
      </svg>
      <span class="brand-name">Pharma<span>Net</span></span>
    </div>

    <!-- Illustration -->
    <div class="panel-illustration">
      <img src="{{ asset('8274966_3850595.jpg') }}" alt="Comptoir de pharmacie"
           style="width:92%;border-radius:1.25rem;box-shadow:0 12px 40px rgba(0,0,0,0.35);display:block;">
      <svg viewBox="-5 -18 410 376" xmlns="http://www.w3.org/2000/svg" style="display:none;">

        <!-- ── Fond plancher ── -->
        <rect x="0" y="275" width="400" height="65" rx="0" fill="rgba(187,247,208,0.08)"/>
        <ellipse cx="200" cy="278" rx="200" ry="12" fill="rgba(0,0,0,0.12)"/>

        <!-- ══ ÉTAGÈRES ══ -->
        <!-- Meuble étagère -->
        <rect x="100" y="10" width="285" height="195" rx="10" fill="rgba(255,255,255,0.1)" stroke="rgba(255,255,255,0.18)" stroke-width="1.5"/>
        <!-- Dos de l'étagère -->
        <rect x="103" y="13" width="279" height="189" rx="8" fill="rgba(220,252,231,0.07)"/>

        <!-- Tablettes -->
        <rect x="100" y="78"  width="285" height="4" rx="2" fill="rgba(255,255,255,0.25)"/>
        <rect x="100" y="140" width="285" height="4" rx="2" fill="rgba(255,255,255,0.25)"/>

        <!-- ── TABLETTE HAUTE ── -->
        <!-- Flacon bleu -->
        <rect x="114" y="22" width="16" height="52" rx="4" fill="#64B5F6"/>
        <rect x="114" y="17" width="16" height="7"  rx="3" fill="#90CAF9"/>
        <rect x="117" y="35" width="10" height="8" rx="1" fill="white" opacity=".7"/>
        <!-- Boîte rouge -->
        <rect x="136" y="28" width="28" height="46" rx="3" fill="#EF5350"/>
        <rect x="139" y="33" width="22" height="12" rx="1" fill="white" opacity=".85"/>
        <line x1="136" y1="55" x2="164" y2="55" stroke="white" stroke-width="1" opacity=".4"/>
        <!-- Flacon vert -->
        <rect x="170" y="22" width="18" height="52" rx="5" fill="#4DB6AC"/>
        <rect x="170" y="16" width="18" height="8"  rx="3" fill="#80CBC4"/>
        <!-- Boîte jaune -->
        <rect x="194" y="26" width="30" height="48" rx="3" fill="#FFB74D"/>
        <rect x="197" y="31" width="24" height="13" rx="1" fill="white" opacity=".85"/>
        <rect x="205" y="48" width="4" height="14" rx="2" fill="#E65100" opacity=".6"/>
        <rect x="199" y="53" width="16" height="4" rx="2" fill="#E65100" opacity=".6"/>
        <!-- Boîte violette -->
        <rect x="230" y="24" width="28" height="50" rx="3" fill="#AB47BC"/>
        <rect x="233" y="29" width="22" height="12" rx="1" fill="white" opacity=".8"/>
        <!-- Flacon bleu clair -->
        <rect x="264" y="20" width="16" height="54" rx="4" fill="#42A5F5"/>
        <rect x="264" y="14" width="16" height="8"  rx="3" fill="#90CAF9"/>
        <!-- Boîte orange -->
        <rect x="286" y="28" width="26" height="46" rx="3" fill="#FF7043"/>
        <rect x="289" y="33" width="20" height="12" rx="1" fill="white" opacity=".8"/>
        <!-- Boîte verte -->
        <rect x="318" y="22" width="28" height="52" rx="3" fill="#66BB6A"/>
        <rect x="321" y="27" width="22" height="13" rx="1" fill="white" opacity=".8"/>
        <rect x="329" y="44" width="4" height="14" rx="2" fill="#2E7D32" opacity=".6"/>
        <rect x="323" y="49" width="16" height="4" rx="2" fill="#2E7D32" opacity=".6"/>
        <!-- Boîte bleu fin -->
        <rect x="352" y="30" width="22" height="44" rx="3" fill="#5C9EE0"/>

        <!-- ── TABLETTE MILIEU ── -->
        <rect x="108" y="86"  width="32" height="50" rx="3" fill="#E53935"/>
        <rect x="111" y="91"  width="26" height="13" rx="1" fill="white" opacity=".8"/>
        <rect x="146" y="89"  width="18" height="47" rx="4" fill="#26C6DA"/>
        <rect x="146" y="84"  width="18" height="7"  rx="3" fill="#80DEEA"/>
        <rect x="170" y="88"  width="30" height="48" rx="3" fill="#FFF176" stroke="#F9A825" stroke-width="1"/>
        <rect x="173" y="93"  width="24" height="12" rx="1" fill="#F9A825" opacity=".6"/>
        <rect x="206" y="86"  width="24" height="50" rx="3" fill="#81D4FA"/>
        <rect x="209" y="91"  width="18" height="12" rx="1" fill="white" opacity=".8"/>
        <rect x="236" y="88"  width="32" height="48" rx="3" fill="#A5D6A7"/>
        <rect x="239" y="93"  width="26" height="13" rx="1" fill="white" opacity=".8"/>
        <rect x="248" y="108" width="4"  height="14" rx="2" fill="#2E7D32" opacity=".6"/>
        <rect x="242" y="113" width="16" height="4"  rx="2" fill="#2E7D32" opacity=".6"/>
        <rect x="274" y="88"  width="22" height="48" rx="3" fill="#FFCC80"/>
        <rect x="277" y="93"  width="16" height="12" rx="1" fill="white" opacity=".7"/>
        <rect x="302" y="86"  width="28" height="50" rx="3" fill="#CE93D8"/>
        <rect x="305" y="91"  width="22" height="13" rx="1" fill="white" opacity=".8"/>
        <rect x="336" y="88"  width="20" height="48" rx="3" fill="#80DEEA"/>
        <rect x="358" y="86"  width="20" height="50" rx="3" fill="#EF9A9A"/>

        <!-- ── TABLETTE BAS ── -->
        <rect x="108" y="148" width="34" height="46" rx="3" fill="#4FC3F7"/>
        <rect x="111" y="153" width="28" height="13" rx="1" fill="white" opacity=".8"/>
        <rect x="148" y="150" width="20" height="44" rx="4" fill="#A5D6A7"/>
        <rect x="148" y="145" width="20" height="7"  rx="3" fill="#C8E6C9"/>
        <rect x="174" y="148" width="30" height="46" rx="3" fill="#FFB74D"/>
        <rect x="177" y="153" width="24" height="13" rx="1" fill="white" opacity=".8"/>
        <rect x="210" y="146" width="26" height="48" rx="3" fill="#FF7043"/>
        <rect x="213" y="151" width="20" height="13" rx="1" fill="white" opacity=".8"/>
        <rect x="242" y="148" width="32" height="46" rx="3" fill="#80CBC4"/>
        <rect x="245" y="153" width="26" height="13" rx="1" fill="white" opacity=".8"/>
        <rect x="280" y="150" width="24" height="44" rx="3" fill="#B39DDB"/>
        <rect x="283" y="155" width="18" height="12" rx="1" fill="white" opacity=".8"/>
        <rect x="310" y="148" width="28" height="46" rx="3" fill="#F48FB1"/>
        <rect x="350" y="148" width="24" height="46" rx="3" fill="#64B5F6"/>

        <!-- ══ COMPTOIR ══ -->
        <!-- Vitre/panneau de protection -->
        <rect x="86"  y="208" width="248" height="10" rx="3" fill="rgba(178,235,242,0.3)" stroke="rgba(255,255,255,0.3)" stroke-width="1"/>
        <!-- Surface dessus -->
        <rect x="78"  y="215" width="265" height="18" rx="4" fill="#00897B"/>
        <!-- Corps du comptoir -->
        <rect x="90"  y="230" width="248" height="72" rx="6" fill="#00796B"/>
        <!-- Bord inférieur -->
        <rect x="90"  y="295" width="248" height="8"  rx="3" fill="#004D40"/>
        <!-- Symbole croix -->
        <rect x="196" y="249" width="10" height="34" rx="3" fill="rgba(255,255,255,0.25)"/>
        <rect x="180" y="260" width="42" height="10" rx="3" fill="rgba(255,255,255,0.25)"/>

        <!-- ══ PHARMACIENNE ══ -->
        <!-- Cheveux -->
        <ellipse cx="252" cy="155" rx="20" ry="22" fill="#6D4C41"/>
        <!-- Visage -->
        <circle  cx="252" cy="163" r="17" fill="#FFCCBC"/>
        <!-- Dessus cheveux -->
        <ellipse cx="252" cy="142" rx="16" ry="11" fill="#6D4C41"/>
        <!-- Oreilles -->
        <circle cx="235" cy="163" r="5" fill="#FFCCBC"/>
        <circle cx="269" cy="163" r="5" fill="#FFCCBC"/>
        <!-- Yeux -->
        <circle cx="246" cy="160" r="2.5" fill="#37474F"/>
        <circle cx="258" cy="160" r="2.5" fill="#37474F"/>
        <!-- Reflets yeux -->
        <circle cx="247" cy="159" r="1" fill="white"/>
        <circle cx="259" cy="159" r="1" fill="white"/>
        <!-- Sourcils -->
        <path d="M243 155 Q246 153 249 155" fill="none" stroke="#5D4037" stroke-width="1.5" stroke-linecap="round"/>
        <path d="M255 155 Q258 153 261 155" fill="none" stroke="#5D4037" stroke-width="1.5" stroke-linecap="round"/>
        <!-- Sourire -->
        <path d="M245 168 Q252 175 259 168" fill="none" stroke="#BF7860" stroke-width="2" stroke-linecap="round"/>
        <!-- Blouse blanche -->
        <rect x="230" y="178" width="44" height="40" rx="5" fill="white"/>
        <!-- Col blouse -->
        <path d="M238 178 L252 192 L266 178" fill="none" stroke="#e0e0e0" stroke-width="2"/>
        <!-- Insigne coloré -->
        <rect x="234" y="188" width="10" height="14" rx="2" fill="#00897B"/>

        <!-- ══ CLIENT ══ -->
        <!-- Cheveux -->
        <ellipse cx="44" cy="145" rx="19" ry="21" fill="#5D4037"/>
        <!-- Visage -->
        <circle  cx="44" cy="153" r="16" fill="#FFCCBC"/>
        <!-- Dessus cheveux -->
        <ellipse cx="44" cy="133" rx="15" ry="10" fill="#5D4037"/>
        <!-- Oreilles -->
        <circle cx="28" cy="153" r="5" fill="#FFCCBC"/>
        <circle cx="60" cy="153" r="5" fill="#FFCCBC"/>
        <!-- Yeux -->
        <circle cx="38" cy="150" r="2.5" fill="#37474F"/>
        <circle cx="50" cy="150" r="2.5" fill="#37474F"/>
        <circle cx="39" cy="149" r="1" fill="white"/>
        <circle cx="51" cy="149" r="1" fill="white"/>
        <!-- Sourcils -->
        <path d="M35 145 Q38 143 41 145" fill="none" stroke="#5D4037" stroke-width="1.5" stroke-linecap="round"/>
        <path d="M47 145 Q50 143 53 145" fill="none" stroke="#5D4037" stroke-width="1.5" stroke-linecap="round"/>
        <!-- Corps pull rouge -->
        <rect x="24" y="167" width="40" height="55" rx="5" fill="#E53935"/>
        <!-- Bras tendu vers le comptoir -->
        <rect x="62" y="188" width="30" height="12" rx="6" fill="#E53935"/>
        <!-- Main -->
        <circle cx="96" cy="194" r="8"  fill="#FFCCBC"/>
        <!-- Doigts -->
        <rect x="97" y="185" width="5" height="10" rx="2.5" fill="#FFCCBC"/>
        <rect x="103" y="187" width="5" height="9"  rx="2.5" fill="#FFCCBC"/>
        <!-- Pantalon gris -->
        <rect x="24" y="218" width="17" height="60" rx="4" fill="#546E7A"/>
        <rect x="47" y="218" width="17" height="60" rx="4" fill="#546E7A"/>
        <!-- Chaussures -->
        <rect x="20" y="272" width="22" height="10" rx="4" fill="#1A237E"/>
        <rect x="43" y="272" width="22" height="10" rx="4" fill="#1A237E"/>

        <!-- ══ PLANTE DÉCORATIVE ══ -->
        <!-- Pot -->
        <rect x="350" y="268" width="40" height="30" rx="4" fill="#FFC107"/>
        <rect x="347" y="262" width="46" height="10" rx="3" fill="#FFB300"/>
        <!-- Tige -->
        <line x1="370" y1="262" x2="370" y2="215" stroke="#388E3C" stroke-width="3.5"/>
        <!-- Feuilles -->
        <ellipse cx="353" cy="233" rx="22" ry="10" fill="#43A047" transform="rotate(-35 353 233)"/>
        <ellipse cx="387" cy="226" rx="20" ry="10" fill="#2E7D32" transform="rotate(25 387 226)"/>
        <ellipse cx="355" cy="215" rx="18" ry="9"  fill="#66BB6A" transform="rotate(-20 355 215)"/>
        <ellipse cx="385" cy="210" rx="16" ry="8"  fill="#388E3C" transform="rotate(30 385 210)"/>
        <ellipse cx="365" cy="205" rx="12" ry="7"  fill="#81C784" transform="rotate(-5 365 205)"/>

      </svg>
    </div>

    <!-- Tagline -->
    <div class="panel-tagline">
      <h2>Rejoignez le réseau PharmaNet</h2>
      <p>Accédez à vos médicaments, suivez vos commandes<br>et gérez votre santé en quelques clics.</p>
    </div>

  </div>

  <!-- ══ PANNEAU DROIT ══════════════════════════════════════════════ -->
  <div class="panel-right">
    <div class="form-card">

      <h3>Créer un compte</h3>
      <p class="subtitle">Inscription client — tous les champs marqués * sont obligatoires.</p>

      @if ($errors->any())
        <div class="alert-error">
          <i class="ti ti-alert-circle"></i> {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- ─ Identité ─ -->
        <div class="section-label">Identité</div>
        <div class="row g-2 mb-2">
          <div class="col-6">
            <label class="form-label">Prénom *</label>
            <input type="text" name="prenom" value="{{ old('prenom') }}"
              class="form-control @error('prenom') is-invalid @enderror"
              placeholder="Mohamed" required>
            @error('prenom')<div class="error-text">{{ $message }}</div>@enderror
          </div>
          <div class="col-6">
            <label class="form-label">Nom *</label>
            <input type="text" name="nom" value="{{ old('nom') }}"
              class="form-control @error('nom') is-invalid @enderror"
              placeholder="Benali" required>
            @error('nom')<div class="error-text">{{ $message }}</div>@enderror
          </div>
        </div>

        <div class="row g-2 mb-2">
          <div class="col-6">
            <label class="form-label">Date de naissance *</label>
            <div class="input-icon-wrap">
              <input type="date" name="date_naissance" value="{{ old('date_naissance') }}"
                class="form-control @error('date_naissance') is-invalid @enderror" required>
              <i class="ti ti-calendar"></i>
            </div>
            @error('date_naissance')<div class="error-text">{{ $message }}</div>@enderror
          </div>
          <div class="col-6">
            <label class="form-label">Sexe *</label>
            <select name="sexe" class="form-select @error('sexe') is-invalid @enderror" required>
              <option value="" disabled {{ old('sexe') ? '' : 'selected' }}>Choisir…</option>
              <option value="homme" {{ old('sexe') === 'homme' ? 'selected' : '' }}>Homme</option>
              <option value="femme" {{ old('sexe') === 'femme' ? 'selected' : '' }}>Femme</option>
            </select>
            @error('sexe')<div class="error-text">{{ $message }}</div>@enderror
          </div>
        </div>

        <!-- ─ Contact ─ -->
        <div class="section-label">Contact</div>
        <div class="mb-2">
          <label class="form-label">Adresse e-mail *</label>
          <div class="input-icon-wrap">
            <input type="email" name="email" value="{{ old('email') }}"
              class="form-control @error('email') is-invalid @enderror"
              placeholder="exemple@email.com" required autocomplete="username">
            <i class="ti ti-mail"></i>
          </div>
          @error('email')<div class="error-text">{{ $message }}</div>@enderror
        </div>

        <div class="row g-2 mb-2">
          <div class="col-6">
            <label class="form-label">Téléphone *</label>
            <div class="input-icon-wrap">
              <input type="tel" name="telephone" value="{{ old('telephone') }}"
                class="form-control @error('telephone') is-invalid @enderror"
                placeholder="06 XX XX XX XX" required>
              <i class="ti ti-phone"></i>
            </div>
            @error('telephone')<div class="error-text">{{ $message }}</div>@enderror
          </div>
          <div class="col-6">
            <label class="form-label">Adresse</label>
            <div class="input-icon-wrap">
              <input type="text" name="adresse" value="{{ old('adresse') }}"
                class="form-control @error('adresse') is-invalid @enderror"
                placeholder="Rue, Ville">
              <i class="ti ti-map-pin"></i>
            </div>
            @error('adresse')<div class="error-text">{{ $message }}</div>@enderror
          </div>
        </div>

        <!-- ─ Sécurité ─ -->
        <div class="section-label">Sécurité</div>
        <div class="mb-2">
          <label class="form-label">Mot de passe *</label>
          <div class="input-icon-wrap">
            <input type="password" name="password" id="password"
              class="form-control @error('password') is-invalid @enderror"
              placeholder="Minimum 8 caractères" required autocomplete="new-password">
            <i class="ti ti-eye toggle-pwd" onclick="togglePwd('password', this)"></i>
          </div>
          @error('password')<div class="error-text">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Confirmer le mot de passe *</label>
          <div class="input-icon-wrap">
            <input type="password" name="password_confirmation" id="password_confirmation"
              class="form-control" placeholder="Répétez le mot de passe"
              required autocomplete="new-password">
            <i class="ti ti-eye toggle-pwd" onclick="togglePwd('password_confirmation', this)"></i>
          </div>
        </div>

        <button type="submit" class="btn-register">
          <i class="ti ti-user-plus me-1"></i> Créer mon compte
        </button>

        <div class="divider"></div>

        <p class="text-center mb-0" style="font-size:.85rem;color:#6c757d;">
          Déjà inscrit ?
          <a href="{{ route('login') }}" class="login-link">Se connecter</a>
        </p>

      </form>
    </div>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function togglePwd(id, icon) {
    const input = document.getElementById(id);
    if (input.type === 'password') {
      input.type = 'text';
      icon.classList.replace('ti-eye', 'ti-eye-off');
    } else {
      input.type = 'password';
      icon.classList.replace('ti-eye-off', 'ti-eye');
    }
  }
</script>
</body>
</html>
