@extends('layouts.public')

@section('title', 'Portfolio')

@section('content')
<section class="section-gap" id="portfolio">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="product-area-title text-center">
          <p class="text-uppercase">{{ config('app.portfolio_description', 'Recent Projects') }}</p>
          <h2 class="h1">{{ config('app.portfolio_heading', 'Portfolio') }}</h2>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-12 d-flex justify-content-center controls">
        @php $activeIds = $activeServiceIds ?? []; @endphp
        <a href="{{ route('public.portfolio') }}" class="btn btn-outline-primary {{ empty($activeIds) ? 'active' : '' }}">All</a>
        @foreach($filters as $f)
          <a href="{{ route('public.portfolio', ['service' => $f->service_id]) }}" class="btn btn-outline-primary ms-2 {{ in_array($f->service_id, $activeIds, true) ? 'active' : '' }}">{{ $f->service_name }}</a>
        @endforeach
      </div>
    </div>
    <div id="filter-content" class="row">
      @forelse($projects as $project)
        @php $thumb = optional($project->images->first())->image_path; @endphp
        <div class="col-lg-4 col-md-6">
          <div class="single-portfolio d-flex flex-column p-2 border rounded h-100">
            <a href="{{ route('public.portfolio-details', $project) }}" class="d-block mb-2">
              @if($thumb)
                <img src="{{ asset('storage/'.$thumb) }}" alt="{{ $project->project_title }}" class="img-fluid rounded">
              @else
                <img src="{{ asset('public_template/img/p4.jpg') }}" alt="{{ $project->project_title }}" class="img-fluid rounded">
              @endif
            </a>
            <div class="content mt-auto">
              <h4 class="mb-1">{{ $project->project_title }}</h4>
              <p class="text-muted mb-2">Client: {{ $project->client_name }}</p>
              <div>
                @foreach($project->services as $srv)
                  <span class="badge bg-secondary me-1">{{ $srv->service_name }}</span>
                @endforeach
              </div>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12"><p class="text-center">Tidak ada project untuk filter ini.</p></div>
      @endforelse
    </div>
    <div class="d-flex justify-content-center mt-4">
      {{ $projects->links() }}
    </div>
  </div>
</section>
@endsection