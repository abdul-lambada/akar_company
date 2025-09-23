@extends('layouts.public')

@section('title', 'Project: ' . $project->project_title)

@section('content')
<section class="section-gap" id="portfolio-details">
  <div class="container">
    <div class="row mb-4">
      <div class="col-12">
        <h2 class="mb-2">{{ $project->project_title }}</h2>
        <p class="text-muted">Client: {{ $project->client_name }}</p>
        <div class="mb-2">
          @foreach($project->services as $srv)
            <span class="badge bg-secondary me-1">{{ $srv->service_name }}</span>
          @endforeach
        </div>
      </div>
    </div>

    <div class="row">
      @forelse($project->images as $img)
        <div class="col-md-6 col-lg-4 mb-4">
          <img src="{{ asset('storage/' . $img->image_path) }}" alt="{{ $project->project_title }}" class="img-fluid rounded">
        </div>
      @empty
        <div class="col-12"><p class="text-center">Belum ada gambar untuk proyek ini.</p></div>
      @endforelse
    </div>

    @if($project->testimonials && $project->testimonials->count())
      <div class="row mt-4">
        <div class="col-12">
          <h4 class="mb-3">Testimonials</h4>
        </div>
        @foreach($project->testimonials as $t)
          <div class="col-md-6 mb-3">
            <div class="p-3 border rounded h-100">
              <div class="d-flex align-items-center mb-2">
                <img src="{{ $t->image_path ? asset('storage/'.$t->image_path) : asset('NiceAdmin/assets/img/profile-img.jpg') }}" alt="{{ $t->client_name }}" class="rounded-circle me-2" style="width:40px;height:40px;object-fit:cover;">
                <div class="fw-bold">{{ $t->client_name }}</div>
              </div>
              <p class="mb-0">"{{ $t->testimonial_text }}"</p>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</section>
@endsection