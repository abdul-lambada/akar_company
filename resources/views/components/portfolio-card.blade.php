@props(['project'])
@php($cover = $project->images->first())
<div class="card h-100 border-0 shadow-sm d-flex flex-column">
  @if($cover)
    <a href="{{ $cover->url }}" class="glightbox" data-gallery="portfolio-gallery-{{ $project->project_id }}" title="{{ $project->project_title }}">
      <img src="{{ $cover->url }}" class="card-img-top" alt="{{ $project->project_title }}" loading="lazy">
    </a>
    @foreach($project->images->skip(1) as $img)
      <a href="{{ $img->url }}" class="glightbox d-none" data-gallery="portfolio-gallery-{{ $project->project_id }}" title="{{ $project->project_title }}"></a>
    @endforeach
  @endif
  <div class="card-body d-flex flex-column">
    <h5 class="card-title mb-1">{{ $project->project_title }}</h5>
    <p class="card-text text-muted small mb-2">{{ $project->client_name }}</p>
    <div class="small mb-2">
      @foreach(($project->services ?? []) as $sv)
        <span class="badge bg-secondary">{{ $sv->service_name }}</span>
      @endforeach
    </div>
    <div class="mt-auto pt-2 d-flex justify-content-between align-items-center">
      <a href="{{ route('public.portfolio-details', $project) }}" class="btn btn-outline-primary btn-sm">Detail</a>
      <a href="{{ route('public.portfolio-details', $project) }}" class="stretched-link" aria-label="Buka detail"></a>
    </div>
  </div>
</div>