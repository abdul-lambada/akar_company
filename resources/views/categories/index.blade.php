@extends('layouts.niceadmin')

@section('title', 'Categories')

@section('content')
<div class="pagetitle">
  <h1>Categories</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Categories</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
        <h5 class="card-title mb-0">List</h5>
        <a href="{{ route('categories.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Add Category</a>
      </div>
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Name</th>
              <th>Slug</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($categories as $cat)
              <tr>
                <td>{{ $cat->category_id }}</td>
                <td>{{ $cat->category_name }}</td>
                <td>{{ $cat->slug }}</td>
                <td>
                  <a class="btn btn-sm btn-warning" href="{{ route('categories.edit', $cat) }}"><i class="bi bi-pencil"></i></a>
                  <form action="{{ route('categories.destroy', $cat) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this category?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                  </form>
                </td>
              </tr>
            @empty
              <tr><td colspan="4" class="text-center">No data</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      {{ $categories->links() }}
    </div>
  </div>
</section>
@endsection