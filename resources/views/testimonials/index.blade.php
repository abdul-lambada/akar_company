@extends('layouts.niceadmin')

@section('title', 'Testimonials')

@section('content')
<div class="pagetitle">
  <h1>Testimonials</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Testimonials</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
        <h5 class="card-title mb-0">List</h5>
        <a href="{{ route('testimonials.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Add Testimonial</a>
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
              <th>Testimonial</th>
              <th>Project</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($testimonials as $testimonial)
              <tr>
                <td>{{ $testimonial->testimonial_id }}</td>
                <td>{{ $testimonial->client_name }}</td>
                <td>{{ $testimonial->testimonial_text }}</td>
                <td>{{ ($testimonial->portfolio)->project_title ?? '-' }}</td>
                <td class="text-end">
                  @include('components.action-buttons', [
                    'viewUrl' => route('testimonials.show', $testimonial),
                    'editUrl' => route('testimonials.edit', $testimonial),
                    'deleteUrl' => route('testimonials.destroy', $testimonial),
                    'confirm' => 'Delete this testimonial?'
                  ])
                </td>
              </tr>
            @empty
              <tr><td colspan="5" class="text-center">No data</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      {{ $testimonials->links() }}
    </div>
  </div>
</section>
@endsection