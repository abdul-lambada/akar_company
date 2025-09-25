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
              <blockquote class="blockquote border-start ps-3">“{{ $t->content ?? ($t->testimonial ?? '') }}”
                <footer class="blockquote-footer">{{ $t->author_name ?? ($t->client_name ?? 'Klien') }}</footer>
              </blockquote>
            @endforeach
          </div>
        @endif
      </div>
    </div>
  </div>
</section>
@endsection
