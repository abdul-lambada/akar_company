@extends('layouts.niceadmin')

@section('title', 'Portfolio')

@section('content')
<div class="pagetitle">
  <h1>Portfolio</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item active">Portfolio</li>
    </ol>
  </nav>
</div>

<section class="section">
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mt-3">
        <h5 class="card-title mb-0">Projects</h5>
        <a href="{{ route('portfolio.create') }}" class="btn btn-primary">Add Project</a>
      </div>

      @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
      @endif

      <div class="table-responsive mt-3">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
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
                  <a href="{{ route('portfolio.show', $project) }}" class="btn btn-sm btn-info">View</a>
                  <a href="{{ route('portfolio.edit', $project) }}" class="btn btn-sm btn-warning">Edit</a>
                  <form action="{{ route('portfolio.destroy', $project) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this project?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center text-muted">No projects yet.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="mt-3">
        {{ $projects->links() }}
      </div>
    </div>
  </div>
</section>
@endsection