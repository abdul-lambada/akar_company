@extends('layouts.strategy')

@section('title', 'Portfolio - ' . config('app.name', 'Akar Company'))
@section('meta_description', 'Koleksi proyek terbaru dan studi kasus dari ' . config('app.name'))
@section('meta_keywords', 'portfolio, proyek, studi kasus, layanan')

@section('content')
  <section class="section" id="portfolio">
    <div class="container section-title" data-aos="fade-up">
      <h2>{{ config('app.portfolio_heading') }}</h2>
      <div><span>Our</span> <span class="description-title">{{ config('app.portfolio_description') }}</span></div>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
        <!-- Filters -->
        @if(isset($filters) && count($filters))
        <ul class="portfolio-filters isotope-filters">
          <li data-filter="*" class="filter-active">All</li>
          @foreach($filters as $f)
            <li data-filter=".filter-{{ $f->slug }}">{{ $f->service_name }}</li>
          @endforeach
        </ul>
        @endif

        <!-- Grid -->
        <div class="row gy-4 isotope-container">
          @foreach($projects as $project)
          @php
            $cover = optional($project->images->first())->image_path;
            $cats = $project->services->pluck('slug')->map(fn($s) => 'filter-' . $s)->implode(' ');
          @endphp
          <div class="col-xl-4 col-md-6 portfolio-item isotope-item {{ $cats }}">
            <div class="portfolio-content h-100">
              <a href="{{ route('public.portfolio-details', $project->getKey()) }}" class="d-block">
                <img src="{{ $cover ? asset('storage/'.$cover) : asset('Strategy/assets/img/portfolio/portfolio-1.jpg') }}" class="img-fluid" alt="{{ $project->project_title }}">
              </a>
              <div class="portfolio-info">
                <h4><a href="{{ route('public.portfolio-details', $project->getKey()) }}">{{ $project->project_title }}</a></h4>
                <p>Client: {{ $project->client_name }}</p>
                @if($cover)
                  <a href="{{ asset('storage/'.$cover) }}" title="{{ $project->project_title }}" data-gallery="portfolio-grid" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
                @endif
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>

      <div class="mt-4">
        {{ $projects->links() }}
      </div>
    </div>
  </section>
@endsection