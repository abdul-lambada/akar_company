@extends('layouts.niceadmin')

@section('title', 'Testimonials')

@section('content')
<div class="pagetitle">
  <h1>Testimonials</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item active">Testimonials</li>
    </ol>
  </nav>
</div>

<section class="section">
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mt-3">
        <h5 class="card-title mb-0">Testimonials</h5>
        <a href="{{ route('testimonials.create') }}" class="btn btn-primary">Add Testimonial</a>
      </div>

      @if(session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
      @endif

      <div class="table-responsive mt-3">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>ID</th>
              <th>Client</th>
              <th>Project</th>
              <th>Testimonial</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($testimonials as $t)
              <tr>
                <td>{{ $t->testimonial_id }}</td>
                <td>{{ $t->client_name }}</td>
                <td>{{ optional($t->portfolio)->project_title }}</td>
                <td>{{ \Illuminate\Support\Str::limit($t->testimonial_text, 60) }}</td>
                <td class="text-end">
                  <a href="{{ route('testimonials.show', $t) }}" class="btn btn-sm btn-info">View</a>
                  <a href="{{ route('testimonials.edit', $t) }}" class="btn btn-sm btn-warning">Edit</a>
                  <form action="{{ route('testimonials.destroy', $t) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this testimonial?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                  </form>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="5" class="text-center text-muted">No testimonials yet.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <div class="mt-3">
        {{ $testimonials->links() }}
      </div>
    </div>
  </div>
</section>
@endsection