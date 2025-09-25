@props(['post'])
@php($thumb = $post->images->first())
<div class="card h-100 border-0 shadow-sm">
  @if($thumb)
    <img src="{{ $thumb->url }}" class="card-img-top" alt="{{ $post->title }}" loading="lazy">
  @endif
  <div class="card-body">
    <a href="{{ route('public.blog-detail', $post->slug) }}" class="text-decoration-none">
      <h5 class="card-title">{{ $post->title }}</h5>
    </a>
    <p class="card-text text-muted small">Oleh {{ $post->user->full_name ?? ($post->user->name ?? 'Admin') }}</p>
    <div class="small text-muted">{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 120) }}</div>
  </div>
</div>
