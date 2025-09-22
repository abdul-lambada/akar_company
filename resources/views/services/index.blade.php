@extends('layouts.niceadmin')

@section('title', 'Services')

@section('content')
<div class="pagetitle">
  <h1>Services</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Services</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
        <h5 class="card-title mb-0">List</h5>
        <a href="{{ route('services.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Add Service</a>
      </div>
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Service Name</th>
              <th>Slug</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($services as $service)
              <tr>
                <td>{{ $service->service_id }}</td>
                <td>{{ $service->service_name }}</td>
                <td>{{ $service->slug }}</td>
                <td class="text-end">
                  @include('components.action-buttons', [
                    'viewUrl' => route('services.show', $service),
                    'editUrl' => route('services.edit', $service),
                    'deleteUrl' => route('services.destroy', $service),
                    'confirm' => 'Delete this service?'
                  ])
                </td>
              </tr>
            @empty
              <tr><td colspan="4" class="text-center">No data</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      {{ $services->links() }}
    </div>
  </div>
</section>
@endsection