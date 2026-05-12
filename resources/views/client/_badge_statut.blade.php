@php
  $labels = ['en_attente' => 'En attente', 'confirmee' => 'Confirmée', 'livree' => 'Livrée', 'annulee' => 'Annulée'];
  $icons  = ['en_attente' => 'ti-clock', 'confirmee' => 'ti-circle-check', 'livree' => 'ti-package', 'annulee' => 'ti-x'];
@endphp
<span class="badge-statut badge-{{ $statut }}">
  <i class="ti {{ $icons[$statut] ?? 'ti-circle' }}" style="font-size:.65rem;"></i>
  {{ $labels[$statut] ?? ucfirst($statut) }}
</span>
