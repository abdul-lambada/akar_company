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
  @php($modalId = 'confirmDelete-'.md5($deleteUrl))
  <button type="button" class="btn btn-{{ $size }} btn-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#{{ $modalId }}">
    <i class="bi bi-trash"></i>
  </button>

  <!-- NiceAdmin / Bootstrap 5 Delete Confirmation Modal -->
  <div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-labelledby="{{ $modalId }}Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="{{ $modalId }}Label">
            <i class="bi bi-exclamation-triangle-fill text-danger me-2"></i> Konfirmasi Hapus
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {{ $confirm }}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <form action="{{ $deleteUrl }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
              <i class="bi bi-trash"></i> Hapus
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endif