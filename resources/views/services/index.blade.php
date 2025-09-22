@extends('layouts.niceadmin')

@section('title', 'Services')

@section('content')
<div class="pagetitle">
  <h1>Services</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item active">Services</li>
    </ol>
  </nav>
</div>

<section class="section">
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mt-3">
        <h5 class="card-title mb-0">Service List</h5>
        <a href="{{ route('services.create') }}" class="btn btn-primary">Add Service</a>
      </div>

      @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
      @endif

      <div class="table-responsive mt-3">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Slug</th>
              <th class="text-end">Price</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($services as $service)
              <tr>
                <td>{{ $service->service_id }}</td>
                <td>{{ $service->service_name }}</td>
                <td>{{ $service->slug }}</td>
                <td class="text-end">{{ number_format($service->price, 2) }}</td>
                <td class="text-end">
                  <a href="{{ route('services.show', $service) }}" class="btn btn-sm btn-info">View</a>
                  <a href="{{ route('services.edit', $service) }}" class="btn btn-sm btn-warning">Edit</a>
                  <form action="{{ route('services.destroy', $service) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this service?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center text-muted">No services found.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="mt-3">
        {{ $services->links() }}
      </div>
    </div>
  </div>
</section>
@endsection