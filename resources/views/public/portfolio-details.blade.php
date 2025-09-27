@extends('layouts.bizland')
@section('title', $project->project_title)
@section('meta_description', $project->project_title . ' untuk ' . ($project->client_name ?? 'Klien'))
@section('content')
<section class="section">
  <div class="container">
    <div class="container section-title" data-aos="fade-up">
      <x-breadcrumbs :items="[[ 'label' => 'Home', 'url' => route('public.index') ], [ 'label' => 'Portfolio', 'url' => route('public.portfolio') ], [ 'label' => $project->project_title ]]" title="Detail Proyek" />
    </div>
    <div class="row gy-4">
      <div class="col-lg-7">
        @if($project->images->count())
          <div class="position-relative mb-2">
            <div id="carouselProject" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                @foreach($project->images as $idx => $img)
                  <div class="carousel-item {{ $idx === 0 ? 'active' : '' }}">
                    <img src="{{ $img->url }}" class="d-block w-100" alt="{{ $project->project_title }}" loading="lazy">
                  </div>
                @endforeach
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselProject" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselProject" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
            <a href="{{ $project->images->first()->url ?? '#' }}" class="btn btn-outline-secondary btn-sm position-absolute top-0 end-0 m-2 glightbox" data-gallery="portfolio-details-{{ $project->project_id }}" title="Perbesar">Perbesar</a>
            @foreach($project->images as $img)
              <a href="{{ $img->url }}" class="glightbox d-none" data-gallery="portfolio-details-{{ $project->project_id }}" title="{{ $project->project_title }}"></a>
            @endforeach
          </div>
          @push('styles')
          <style>
            /* Samakan ukuran area gambar carousel */
            #carouselProject .carousel-item { height: 420px; }
            #carouselProject .carousel-item img { width: 100%; height: 100%; object-fit: cover; }
            @media (max-width: 576px) { #carouselProject .carousel-item { height: 240px; } }
          </style>
          @endpush
        @endif
      </div>
      <div class="col-lg-5">
        <h2 class="mb-2">{{ $project->project_title }}</h2>
        <p class="text-muted">Klien: {{ $project->client_name }}</p>
        <div class="mb-3">
          @foreach($project->services as $sv)
            <span class="badge bg-secondary">{{ $sv->service_name }}</span>
          @endforeach
        </div>
        @if($project->testimonials->count())
          <h5 class="mt-4">Testimoni</h5>
          <div class="vstack gap-3">
            @foreach($project->testimonials as $t)
              <div class="card text-bg-light border shadow-sm">
                <div class="card-body d-flex align-items-start gap-3">
                  @if(!empty($t->image_url))
                    <img src="{{ $t->image_url }}" alt="{{ $t->client_name ?? 'Client' }}" class="rounded-circle flex-shrink-0" style="width: 56px; height: 56px; object-fit: cover;" loading="lazy">
                  @endif
                  <div>
                    <blockquote class="blockquote mb-1">
                      <p class="mb-1"><em>&ldquo;{{ $t->testimonial_text }}&rdquo;</em></p>
                    </blockquote>
                    <footer class="blockquote-footer mt-2">{{ $t->author_name ?? ($t->client_name ?? 'Klien') }}</footer>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @endif
      </div>
    </div>
  </div>
</section>
@endsection
