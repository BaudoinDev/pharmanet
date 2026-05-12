<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <title>PharmaNet — Paramètres</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
  @include('pharmacie._styles')
  <style>
    .avatar-lg { width:72px;height:72px;border-radius:.85rem;background:linear-gradient(135deg,#7ed957,#5ab832);color:#fff;font-size:1.6rem;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0; }
    .avatar-lg img { width:100%;height:100%;object-fit:cover;border-radius:.85rem; }
    .upload-zone { border:2px dashed #d1d5db;border-radius:.75rem;padding:1rem;text-align:center;cursor:pointer;position:relative;transition:all .2s; }
    .upload-zone:hover { border-color:#7ed957;background:#f0fdf4; }
    .upload-zone input { position:absolute;inset:0;opacity:0;cursor:pointer;width:100%;height:100%; }
    .garde-toggle { display:flex;align-items:center;justify-content:space-between;background:#f9fafb;border:1.5px solid #e5e7eb;border-radius:.75rem;padding:.85rem 1rem; }
    .input-icon-wrap { position:relative; }
    .input-icon-wrap i.toggle { position:absolute;right:.75rem;top:50%;transform:translateY(-50%);color:#9ca3af;cursor:pointer;font-size:1rem; }
    .danger-zone { border:1.5px solid #fecaca;border-radius:1rem;padding:1.5rem; }
    .btn-danger-out { background:none;border:1.5px solid #fca5a5;color:#dc2626;border-radius:.6rem;padding:.5rem 1.1rem;font-size:.875rem;font-weight:600;cursor:pointer;transition:all .15s; }
    .btn-danger-out:hover { background:#fef2f2; }
  </style>
</head>
<body>

@include('pharmacie._sidebar', ['active' => 'parametres'])
@include('pharmacie._topbar', ['pageTitle' => 'Paramètres'])

<main class="main-content">

  <div class="mb-4">
    <h4 class="fw-bold mb-1">Paramètres de la pharmacie</h4>
    <p class="text-muted small mb-0">Gérez les informations de votre établissement et votre compte.</p>
  </div>

  @if(session('success'))
    <div class="alert-success-ph"><i class="ti ti-circle-check"></i> {{ session('success') }}</div>
  @endif
  @if($errors->any())
    <div class="alert-error-ph"><i class="ti ti-alert-circle"></i> {{ $errors->first() }}</div>
  @endif

  <form method="POST" action="{{ route('pharmacie.parametres.update') }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="row g-3">
      <div class="col-12 col-lg-8">

        <!-- Identité pharmacie -->
        <div class="card-white mb-3">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div class="avatar-lg">
              @if($pharmacie->logo)
                <img src="{{ Storage::url($pharmacie->logo) }}" alt="{{ $pharmacie->nom }}" id="logoPreview">
              @else
                <span id="logoInitials">{{ strtoupper(substr($pharmacie->nom, 0, 2)) }}</span>
                <img src="#" alt="" id="logoPreview" style="display:none;">
              @endif
            </div>
            <div>
              <div class="fw-bold" style="font-size:1rem;">{{ $pharmacie->nom }}</div>
              <div class="text-muted small">{{ $pharmacie->adresse }}</div>
            </div>
          </div>

          <div class="section-label">Informations de l'établissement</div>
          <div class="row g-2">
            <div class="col-12">
              <label class="form-label">Nom de la pharmacie <span style="color:#dc2626;">*</span></label>
              <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror"
                value="{{ old('nom', $pharmacie->nom) }}" required>
              @error('nom')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
              <label class="form-label">Adresse <span style="color:#dc2626;">*</span></label>
              <input type="text" name="adresse" class="form-control @error('adresse') is-invalid @enderror"
                value="{{ old('adresse', $pharmacie->adresse) }}" required>
            </div>
            <div class="col-6">
              <label class="form-label">Téléphone</label>
              <input type="tel" name="telephone" class="form-control"
                value="{{ old('telephone', $pharmacie->telephone) }}" placeholder="+225 01 23 45 67">
            </div>
            <div class="col-6">
              <label class="form-label">Numéro d'agrément</label>
              <input type="text" name="numero_agrement" class="form-control"
                value="{{ old('numero_agrement', $pharmacie->numero_agrement) }}" placeholder="AGR-XXXXX">
            </div>
          </div>

          <div class="section-label">Logo</div>
          <div class="upload-zone" id="logoZone">
            <input type="file" name="logo" accept="image/jpeg,image/png,image/webp" onchange="previewLogo(this)">
            <i class="ti ti-photo-up" style="font-size:1.5rem;color:#9ca3af;display:block;margin-bottom:.35rem;"></i>
            <p class="text-muted small mb-0">Cliquez ou glissez une image<br><span style="font-size:.72rem;">JPG, PNG, WEBP — max 2 Mo</span></p>
          </div>

          <div class="section-label">Garde de nuit</div>
          <div class="garde-toggle">
            <div>
              <div class="fw-semibold" style="font-size:.875rem;">Pharmacie de garde</div>
              <div class="text-muted" style="font-size:.78rem;">Activez si vous participez aux gardes nocturnes et jours fériés.</div>
            </div>
            <div class="form-check form-switch ms-3">
              <input class="form-check-input" type="checkbox" name="garde" id="gardeSwitch" value="1"
                style="width:2.4rem;height:1.3rem;cursor:pointer;"
                {{ old('garde', $pharmacie->garde) ? 'checked' : '' }}>
            </div>
          </div>
        </div>

        <!-- Compte responsable -->
        <div class="card-white mb-3">
          <div class="section-label" style="margin-top:0;">Compte responsable</div>
          <div class="row g-2">
            <div class="col-12">
              <label class="form-label">Nom du responsable <span style="color:#dc2626;">*</span></label>
              <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                value="{{ old('name', Auth::user()->name) }}" required>
            </div>
            <div class="col-12">
              <label class="form-label">Adresse e-mail</label>
              <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled
                style="background:#f9fafb;color:#9ca3af;">
              <div class="text-muted small mt-1">L'email ne peut pas être modifié ici.</div>
            </div>
          </div>

          <div class="section-label">Changer le mot de passe</div>
          <p class="text-muted small mb-3">Laissez vide pour conserver le mot de passe actuel.</p>
          <div class="row g-2">
            <div class="col-6">
              <label class="form-label">Nouveau mot de passe</label>
              <div class="input-icon-wrap">
                <input type="password" name="password" id="pwd" class="form-control" placeholder="••••••••">
                <i class="ti ti-eye toggle" onclick="togglePwd('pwd',this)"></i>
              </div>
            </div>
            <div class="col-6">
              <label class="form-label">Confirmer</label>
              <div class="input-icon-wrap">
                <input type="password" name="password_confirmation" id="pwd2" class="form-control" placeholder="••••••••">
                <i class="ti ti-eye toggle" onclick="togglePwd('pwd2',this)"></i>
              </div>
            </div>
          </div>
        </div>

        <button type="submit" class="btn-green" style="padding:.75rem 2rem;font-size:.95rem;">
          <i class="ti ti-device-floppy"></i> Enregistrer les modifications
        </button>

      </div>

      <!-- Colonne droite -->
      <div class="col-12 col-lg-4">
        <div class="card-white mb-3">
          <h6 class="fw-bold mb-3">Résumé du compte</h6>
          <div class="d-flex flex-column gap-2" style="font-size:.875rem;">
            <div class="d-flex justify-content-between">
              <span class="text-muted">Statut</span>
              <span style="background:#dcfce7;color:#15803d;border:1px solid #86efac;border-radius:2rem;padding:.1rem .65rem;font-size:.72rem;font-weight:700;">Validée</span>
            </div>
            <div class="d-flex justify-content-between">
              <span class="text-muted">Inscrite le</span>
              <span class="fw-medium">{{ $pharmacie->created_at->format('d/m/Y') }}</span>
            </div>
            <div class="d-flex justify-content-between">
              <span class="text-muted">Garde</span>
              <span class="fw-medium" id="gardeLabel">{{ $pharmacie->garde ? 'Oui' : 'Non' }}</span>
            </div>
            @if($pharmacie->numero_agrement)
            <div class="d-flex justify-content-between">
              <span class="text-muted">Agrément</span>
              <span class="fw-medium" style="font-family:monospace;font-size:.8rem;">{{ $pharmacie->numero_agrement }}</span>
            </div>
            @endif
          </div>
        </div>

        <div class="danger-zone">
          <h6 class="fw-bold mb-1" style="color:#dc2626;">Zone sensible</h6>
          <p class="text-muted small mb-3">La suppression du compte est irréversible et entraînera la perte de toutes vos données.</p>
          <button type="button" class="btn-danger-out w-100" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
            <i class="ti ti-trash me-1"></i> Supprimer le compte
          </button>
        </div>
      </div>
    </div>
  </form>

</main>

<!-- ═══ Modal Suppression de compte ════════════════════════════ -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" style="max-width:420px;">
    <div class="modal-content" style="border-radius:1rem;border:none;">
      <div class="modal-body p-4">
        <div style="width:52px;height:52px;background:#fef2f2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto .85rem;">
          <i class="ti ti-alert-triangle" style="font-size:1.5rem;color:#dc2626;"></i>
        </div>
        <h5 class="fw-bold text-center mb-1">Supprimer le compte ?</h5>
        <p class="text-muted text-center small mb-3">
          Cette action supprimera définitivement votre pharmacie, vos médicaments et votre compte. Elle est <strong>irréversible</strong>.
        </p>

        @if($errors->has('delete_password'))
          <div class="alert-error-ph mb-3"><i class="ti ti-alert-circle"></i> {{ $errors->first('delete_password') }}</div>
        @endif

        <form method="POST" action="{{ route('pharmacie.compte.supprimer') }}">
          @csrf
          @method('DELETE')
          <div class="mb-3">
            <label class="form-label fw-semibold" style="font-size:.875rem;">Confirmez votre mot de passe</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required autofocus>
          </div>
          <div class="d-flex gap-2">
            <button type="button" class="btn btn-light flex-fill" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-danger flex-fill fw-semibold">
              <i class="ti ti-trash me-1"></i> Supprimer définitivement
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
@if($errors->has('delete_password'))
document.addEventListener('DOMContentLoaded', () => {
  new bootstrap.Modal(document.getElementById('deleteAccountModal')).show();
});
@endif
function togglePwd(id, icon) {
  const inp = document.getElementById(id);
  inp.type = inp.type === 'password' ? 'text' : 'password';
  icon.classList.toggle('ti-eye'); icon.classList.toggle('ti-eye-off');
}
document.getElementById('gardeSwitch').addEventListener('change', function () {
  document.getElementById('gardeLabel').textContent = this.checked ? 'Oui' : 'Non';
});
function previewLogo(input) {
  if (!input.files || !input.files[0]) return;
  const reader = new FileReader();
  reader.onload = e => {
    const prev = document.getElementById('logoPreview');
    const init = document.getElementById('logoInitials');
    prev.src = e.target.result;
    prev.style.display = 'block';
    if (init) init.style.display = 'none';
  };
  reader.readAsDataURL(input.files[0]);
}
</script>
</body>
</html>
