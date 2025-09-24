@props(['paginator'])

@if($paginator instanceof \Illuminate\Contracts\Pagination\Paginator || $paginator instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
  <div class="mt-4 d-flex justify-content-center">
    {{ $paginator->links() }}
  </div>
@endif
