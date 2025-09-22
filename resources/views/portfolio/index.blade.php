@extends('layouts.niceadmin')

@section('title', 'Portfolio')

@section('content')
<div class="pagetitle">
  <h1>Portfolio</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Portfolio</li>
    </ol>
  </nav>
</div>

<section class="section">
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
        <h5 class="card-title mb-0">List</h5>
        <a href="{{ route('portfolio.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Add Project</a>
      </div>

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Photo</th>
              <th>Title</th>
              <th>Client</th>
              <th>Services</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($projects as $project)
              <tr>
                <td>{{ $project->project_id }}</td>
                <td>
                  @php $thumb = optional($project->images->first())->image_path ?? null; @endphp
                  @if($thumb)
                    <img src="{{ asset('storage/'.$thumb) }}" alt="thumb" class="rounded" style="width:64px;height:64px;object-fit:cover;">
                  @else
                    <div class="bg-light border rounded d-inline-flex align-items-center justify-content-center" style="width:64px;height:64px;">-</div>
                  @endif
                </td>
                <td>{{ $project->project_title }}</td>
                <td>{{ $project->client_name }}</td>
                <td>
                  @if($project->services->isEmpty())
                    <span class="text-muted">-</span>
                  @else
                    <span class="badge bg-secondary">{{ $project->services->pluck('service_name')->implode(', ') }}</span>
                  @endif
                </td>
                <td class="text-end">
                  @include('components.action-buttons', [
                    'viewUrl' => route('portfolio.show', $project),
                    'editUrl' => route('portfolio.edit', $project),
                    'deleteUrl' => route('portfolio.destroy', $project),
                    'confirm' => 'Delete this project?'
                  ])
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="text-center">No data</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      {{ $projects->links() }}
    </div>
  </div>
</section>
@endsection