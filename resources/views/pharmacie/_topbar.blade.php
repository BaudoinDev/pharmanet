@php
  $notifCount    = $pharmacie->commandes()->where('statut', 'en_attente')->count();
  $notifRecentes = $pharmacie->commandes()
      ->with('client')
      ->where('statut', 'en_attente')
      ->latest()
      ->take(5)
      ->get();
@endphp

<header class="topbar">
  {{-- Gauche : titre + badge --}}
  <div class="d-flex align-items-center gap-2">
    <span class="topbar-title">{{ $pageTitle ?? 'Tableau de bord' }}</span>
    <span class="badge-acceptee"><i class="ti ti-circle-check"></i> Pharmacie validée</span>
  </div>

  {{-- Droite : cloche + profil --}}
  <div class="d-flex align-items-center gap-2">

    {{-- Cloche --}}
    <div class="notif-wrap" id="notifWrap">
      <button class="notif-btn" id="notifBtn" onclick="toggleNotif(event)" title="Notifications">
        <i class="ti ti-bell"></i>
        @if($notifCount > 0)
          <span class="notif-badge">{{ $notifCount > 9 ? '9+' : $notifCount }}</span>
        @endif
      </button>

      <div class="notif-dropdown" id="notifDropdown">
        <div class="notif-header">
          <span class="fw-bold" style="font-size:.875rem;">Notifications</span>
          @if($notifCount > 0)
            <span style="background:#fff7ed;color:#ea580c;border:1px solid #fed7aa;border-radius:2rem;padding:.1rem .6rem;font-size:.72rem;font-weight:700;">
              {{ $notifCount }} en attente
            </span>
          @else
            <span style="color:#9ca3af;font-size:.78rem;">Aucune nouvelle</span>
          @endif
        </div>

        @forelse($notifRecentes as $cmd)
        <a href="{{ route('pharmacie.commandes') }}" class="notif-item">
          <div class="notif-icon" style="background:#fff7ed;">
            <i class="ti ti-shopping-bag" style="color:#ea580c;"></i>
          </div>
          <div style="min-width:0;flex:1;">
            <div class="fw-semibold" style="font-size:.82rem;color:#111;">
              Commande #{{ str_pad($cmd->id, 4, '0', STR_PAD_LEFT) }}
            </div>
            <div class="text-muted" style="font-size:.75rem;">
              {{ $cmd->client->prenom ?? '' }} {{ $cmd->client->nom ?? 'Client inconnu' }}
              · {{ number_format($cmd->montant_total ?? 0, 0, ',', ' ') }} FCFA
            </div>
            <div style="font-size:.72rem;color:#9ca3af;margin-top:.1rem;">
              {{ $cmd->created_at->diffForHumans() }}
            </div>
          </div>
          <span style="background:#fff7ed;color:#ea580c;border:1px solid #fed7aa;border-radius:2rem;padding:.1rem .5rem;font-size:.68rem;font-weight:700;white-space:nowrap;align-self:flex-start;margin-top:.1rem;">
            En attente
          </span>
        </a>
        @empty
        <div style="padding:2rem 1rem;text-align:center;color:#9ca3af;">
          <i class="ti ti-checks" style="font-size:1.75rem;display:block;margin-bottom:.4rem;color:#d1d5db;"></i>
          <p class="small mb-0">Aucune commande en attente</p>
        </div>
        @endforelse

        <div class="notif-footer">
          <a href="{{ route('pharmacie.commandes') }}" style="font-size:.8rem;color:var(--green-dark);font-weight:600;text-decoration:none;">
            Voir toutes les commandes →
          </a>
        </div>
      </div>
    </div>

    {{-- Profil --}}
    <div class="avatar-initials" style="width:34px;height:34px;font-size:.75rem;">
      {{ strtoupper(substr($pharmacie->nom, 0, 2)) }}
    </div>
    <div class="d-none d-md-block" style="font-size:.825rem;">
      <div class="fw-semibold" style="line-height:1.2;">{{ $pharmacie->nom }}</div>
      <div style="color:#9ca3af;font-size:.72rem;">Pharmacien</div>
    </div>
  </div>
</header>

<script>
function toggleNotif(e) {
  e.stopPropagation();
  document.getElementById('notifDropdown').classList.toggle('open');
}
document.addEventListener('click', function(e) {
  const wrap = document.getElementById('notifWrap');
  if (wrap && !wrap.contains(e.target)) {
    document.getElementById('notifDropdown').classList.remove('open');
  }
});
</script>
