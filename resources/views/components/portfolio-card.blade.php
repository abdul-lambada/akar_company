@props(['project'])
@php($cover = $project->images->first())
<div class="card h-100 border-0 shadow-sm">
  @if($cover)
    <img src="{{ $cover->url }}" class="card-img-top" alt="{{ $project->project_title }}" loading="lazy">
  @endif
  <div class="card-body">
    <h5 class="card-title mb-1">{{ $project->project_title }}</h5>
    <p class="card-text text-muted small mb-2">{{ $project->client_name }}</p>
    <div class="small mb-2">
      @foreach(($project->services ?? []) as $sv)
        <span class="badge bg-secondary">{{ $sv->service_name }}</span>
      @endforeach
    </div>
    <a href="{{ route('public.portfolio-details', $project) }}" class="stretched-link">Detail</a>
  </div>
</div>