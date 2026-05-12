@if ($paginator->hasPages())
<div class="d-flex align-items-center justify-content-between flex-wrap gap-3" style="padding:.85rem 1.25rem;border-top:1px solid #f0f0f0;">

  {{-- Info résultats --}}
  <p class="mb-0 text-muted" style="font-size:.82rem;">
    Affichage
    <strong style="color:#374151;">{{ $paginator->firstItem() }}–{{ $paginator->lastItem() }}</strong>
    sur <strong style="color:#374151;">{{ $paginator->total() }}</strong> résultat(s)
  </p>

  {{-- Boutons de pagination --}}
  <div class="d-flex align-items-center gap-1">

    {{-- Précédent --}}
    @if ($paginator->onFirstPage())
      <span class="page-btn disabled"><i class="ti ti-chevron-left"></i></span>
    @else
      <a href="{{ $paginator->previousPageUrl() }}" class="page-btn"><i class="ti ti-chevron-left"></i></a>
    @endif

    {{-- Pages --}}
    @foreach ($elements as $element)
      @if (is_string($element))
        <span class="page-btn disabled" style="border:none;color:#9ca3af;padding:0 .25rem;">…</span>
      @endif
      @if (is_array($element))
        @foreach ($element as $page => $url)
          @if ($page == $paginator->currentPage())
            <span class="page-btn active">{{ $page }}</span>
          @else
            <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
          @endif
        @endforeach
      @endif
    @endforeach

    {{-- Suivant --}}
    @if ($paginator->hasMorePages())
      <a href="{{ $paginator->nextPageUrl() }}" class="page-btn"><i class="ti ti-chevron-right"></i></a>
    @else
      <span class="page-btn disabled"><i class="ti ti-chevron-right"></i></span>
    @endif

  </div>
</div>
@endif
