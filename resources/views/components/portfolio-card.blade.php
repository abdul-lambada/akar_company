@php
  $cover = $cover 
    ?? (isset($project) ? optional($project->images->first())->image_path : null)
    ?? (isset($project) && method_exists($project, 'images') ? optional($project->images->first())->image_path : null);
@endphp
<div class="portfolio-content h-100">
  <a href="{{ route('public.portfolio-details', $project->getKey()) }}" class="d-block">
    <img src="{{ $cover ? asset('storage/'.$cover) : asset('Strategy/assets/img/portfolio/portfolio-1.jpg') }}" class="img-fluid" alt="{{ $project->project_title }}">
  </a>
  <div class="portfolio-info">
    <h4><a href="{{ route('public.portfolio-details', $project->getKey()) }}">{{ $project->project_title }}</a></h4>
    <p>Client: {{ $project->client_name }}</p>
    @if($cover)
      <a href="{{ asset('storage/'.$cover) }}" title="{{ $project->project_title }}" data-gallery="{{ $gallery ?? 'portfolio-grid' }}" class="glightbox preview-link"><i class="bi bi-zoom-in"></i></a>
    @endif
  </div>
</div>