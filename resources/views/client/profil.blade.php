<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8"/>
  <title>PharmaNet — Mon Profil</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css" rel="stylesheet">
  @include('client._styles')
  <style>
    .avatar-lg {
      width: 80px; height: 80px; border-radius: 50%;
      background: linear-gradient(135deg, #7ed957, #5ab832);
      color: #fff; font-size: 2rem; font-weight: 700;
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }
    .danger-zone {
      border: 1.5px solid #fecaca; border-radius: 1rem;
      padding: 1.5rem; background: #fff;
    }
    .btn-danger-outline {
      background: none; border: 1.5px solid #fca5a5; color: #dc2626;
      border-radius: .65rem; padding: .6rem 1.25rem;
      font-size: .875rem; font-weight: 600; cursor: pointer; transition: all .15s;
    }
    .btn-danger-outline:hover { background: #fef2f2; }
    .input-icon-wrap { position: relative; }
    .input-icon-wrap i {
      position: absolute; right: .85rem; top: 50%;
      transform: translateY(-50%); color: #9ca3af; font-size: 1rem; cursor: pointer;
    }
  </style>
</head>
<body>

@include('client._sidebar', ['active' => 'profil'])

<main class="main-content">

  <div class="mb-4">
    <h4 class="fw-bold mb-1">Mon Profil</h4>
    <p class="text-muted small mb-0">Gérez vos informations personnelles et votre sécurité.</p>
  </div>

  @if(session('success'))
  <div class="alert-success">
    <i class="ti ti-circle-check"></i> {{ session('success') }}
  </div>
  @endif

  @if($errors->any())
  <div style="background:#fef2f2;border:1px solid #fecaca;border-radius:.65rem;padding:.75rem 1rem;color:#dc2626;font-size:.875rem;display:flex;align-items:center;gap:.5rem;margin-bottom:1.25rem;">
    <i class="ti ti-alert-circle"></i> {{ $errors->first() }}
  </div>
  @endif

  <form method="POST" action="{{ route('client.profil.update') }}">
    @csrf
    @method('PUT')

    <div class="row g-3">

      <!-- Colonne gauche -->
      <div class="col-12 col-lg-8">

        <!-- Avatar + info -->
        <div class="card-white mb-3 d-flex align-items-center gap-3">
          <div class="avatar-lg">
            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
          </div>
          <div>
            <h5 class="fw-bold mb-0">{{ Auth::user()->name }}</h5>
            <p class="text-muted small mb-0">{{ Auth::user()->email }}</p>
            <span class="badge mt-1" style="background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;font-size:.72rem;">Client vérifié</span>
          </div>
        </div>

        <!-- Identité -->
        <div class="card-white mb-3">
          <div class="section-label">Informations personnelles</div>
          <div class="row g-2">
            <div class="col-6">
              <label class="form-label">Prénom</label>
              <input type="text" name="prenom" class="form-control @error('prenom') is-invalid @enderror"
                value="{{ old('prenom', $client->prenom ?? '') }}" required>
              @error('prenom')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="col-6">
              <label class="form-label">Nom</label>
              <input type="text" name="nom" class="form-control @error('nom') is-invalid @enderror"
                value="{{ old('nom', $client->nom ?? '') }}" required>
              @error('nom')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
            </div>
            <div class="col-6">
              <label class="form-label">Date de naissance</label>
              <input type="date" name="date_naissance" class="form-control @error('date_naissance') is-invalid @enderror"
                value="{{ old('date_naissance', optional($client)->date_naissance) }}" required>
            </div>
            <div class="col-6">
              <label class="form-label">Sexe</label>
              <select name="sexe" class="form-select @error('sexe') is-invalid @enderror" required>
                <option value="homme" {{ old('sexe', $client->sexe ?? '') === 'homme' ? 'selected' : '' }}>Homme</option>
                <option value="femme" {{ old('sexe', $client->sexe ?? '') === 'femme' ? 'selected' : '' }}>Femme</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Contact -->
        <div class="card-white mb-3">
          <div class="section-label">Coordonnées</div>
          <div class="row g-2">
            <div class="col-12">
              <label class="form-label">Adresse e-mail</label>
              <input type="email" class="form-control" value="{{ Auth::user()->email }}" disabled
                style="background:#f9fafb;color:#9ca3af;">
              <div class="small text-muted mt-1">L'email ne peut pas être modifié ici.</div>
            </div>
            <div class="col-6">
              <label class="form-label">Téléphone</label>
              <input type="tel" name="telephone" class="form-control @error('telephone') is-invalid @enderror"
                value="{{ old('telephone', $client->telephone ?? '') }}" required>
            </div>
            <div class="col-6">
              <label class="form-label">Adresse</label>
              <input type="text" name="adresse" class="form-control"
                value="{{ old('adresse', $client->adresse ?? '') }}" placeholder="Rue, Ville">
            </div>
          </div>
        </div>

        <!-- Sécurité -->
        <div class="card-white mb-3">
          <div class="section-label">Changer le mot de passe</div>
          <p class="text-muted small mb-3">Laissez vide pour conserver le mot de passe actuel.</p>
          <div class="row g-2">
            <div class="col-6">
              <label class="form-label">Nouveau mot de passe</label>
              <div class="input-icon-wrap">
                <input type="password" name="password" id="pwd" class="form-control" placeholder="••••••••">
                <i class="ti ti-eye" onclick="togglePwd('pwd',this)"></i>
              </div>
            </div>
            <div class="col-6">
              <label class="form-label">Confirmer</label>
              <div class="input-icon-wrap">
                <input type="password" name="password_confirmation" id="pwd2" class="form-control" placeholder="••••••••">
                <i class="ti ti-eye" onclick="togglePwd('pwd2',this)"></i>
              </div>
            </div>
          </div>
        </div>

        <button type="submit" class="btn-green">
          <i class="ti ti-device-floppy me-1"></i> Enregistrer les modifications
        </button>

      </div>

      <!-- Colonne droite -->
      <div class="col-12 col-lg-4">

        <!-- Résumé compte -->
        <div class="card-white mb-3">
          <h6 class="fw-bold mb-3">Résumé du compte</h6>
          <div class="d-flex flex-column gap-2" style="font-size:.875rem;">
            <div class="d-flex justify-content-between">
              <span class="text-muted">Membre depuis</span>
              <span class="fw-medium">{{ Auth::user()->created_at->format('M Y') }}</span>
            </div>
            <div class="d-flex justify-content-between">
              <span class="text-muted">Rôle</span>
              <span class="fw-medium">Client</span>
            </div>
            <div class="d-flex justify-content-between">
              <span class="text-muted">Statut</span>
              <span style="color:#16a34a;font-weight:600;">Actif</span>
            </div>
          </div>
        </div>

        <!-- Zone danger -->
        <div class="danger-zone">
          <h6 class="fw-bold mb-1" style="color:#dc2626;">Zone sensible</h6>
          <p class="text-muted small mb-3">La suppression de votre compte est irréversible.</p>
          <button type="button" class="btn-danger-outline w-100" data-bs-toggle="modal" data-bs-target="#deleteModal">
            <i class="ti ti-trash me-1"></i> Supprimer mon compte
          </button>
        </div>

      </div>
    </div>
  </form>

</main>

<!-- Modal suppression -->
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered" style="max-width:380px;">
    <div class="modal-content" style="border-radius:1rem;border:none;">
      <div class="modal-body text-center p-4">
        <div style="width:56px;height:56px;background:#fef2f2;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto .75rem;">
          <i class="ti ti-alert-triangle" style="font-size:1.5rem;color:#dc2626;"></i>
        </div>
        <h5 class="fw-bold mb-1">Supprimer le compte ?</h5>
        <p class="text-muted small mb-3">Cette action est irréversible. Toutes vos données seront définitivement supprimées.</p>
        <div class="d-flex gap-2 justify-content-center">
          <button class="btn btn-light px-4" data-bs-dismiss="modal">Annuler</button>
          <button class="btn px-4" style="background:#dc2626;color:#fff;border-radius:.5rem;">Supprimer</button>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  function togglePwd(id, icon) {
    const input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
    icon.classList.toggle('ti-eye');
    icon.classList.toggle('ti-eye-off');
  }
</script>
</body>
</html>
