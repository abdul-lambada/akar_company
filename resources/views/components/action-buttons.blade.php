@props([
  'viewUrl' => null,
  'editUrl' => null,
  'deleteUrl' => null,
  'confirm' => 'Delete this item?',
  'size' => 'sm', // sm | md
])

@if($viewUrl)
  <a href="{{ $viewUrl }}" class="btn btn-{{ $size }} btn-info me-1" title="View">
    <i class="bi bi-eye"></i>
  </a>
@endif

@if($editUrl)
  <a href="{{ $editUrl }}" class="btn btn-{{ $size }} btn-warning me-1" title="Edit">
    <i class="bi bi-pencil"></i>
  </a>
@endif

@if($deleteUrl)
  <form action="{{ $deleteUrl }}" method="POST" class="d-inline" onsubmit="return confirm('{{ $confirm }}');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-{{ $size }} btn-danger" title="Delete">
      <i class="bi bi-trash"></i>
    </button>
  </form>
@endif