@extends('layouts.niceadmin')

@section('title', 'Products')

@section('content')
<div class="pagetitle">
  <h1>Products</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Products</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
        <h5 class="card-title mb-0">List</h5>
        <a href="{{ route('products.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Add Product</a>
      </div>
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Product Name</th>
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
                    'viewUrl' => route('products.show', $service),
                    'editUrl' => route('products.edit', $service),
                    'deleteUrl' => route('products.destroy', $service),
                    'confirm' => 'Delete this product?'
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