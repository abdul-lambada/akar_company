@props(['post'])
@php($thumb = $post->images->first())
@php($categories = $post->categories ?? collect())
@php($author = $post->user->full_name ?? ($post->user->name ?? 'Admin'))
@php($published = optional($post->created_at)->format('d M Y'))
@php($plain = trim(strip_tags($post->content ?? '')))
@php($words = str_word_count($plain))
@php($readMinutes = max(1, (int) ceil($words / 200)))
<div class="card h-100 border-0 shadow-sm post-card d-flex flex-column">
  @if($thumb)
    <a href="{{ route('public.blog-detail', $post->slug) }}" class="d-block">
      <img src="{{ $thumb->url }}" class="card-img-top" alt="{{ $post->title }}" loading="lazy">
    </a>
  @endif
  <div class="card-body d-flex flex-column">
    @if($categories->count())
      <div class="mb-2 d-flex flex-wrap gap-2 align-items-center">
        @foreach($categories as $cat)
          <span class="badge bg-light text-dark border">{{ $cat->name ?? $cat->category_name ?? 'Kategori' }}</span>
        @endforeach
      </div>
    @endif
    <a href="{{ route('public.blog-detail', $post->slug) }}" class="text-decoration-none">
      <h5 class="card-title mb-2">{{ $post->title }}</h5>
    </a>
    <div class="small text-muted mb-2">
      <span>Oleh {{ $author }}</span>
      @if($published)
        <span class="mx-1">·</span>
        <span>{{ $published }}</span>
      @endif
      <span class="mx-1">·</span>
      <span>{{ $readMinutes }} menit baca</span>
    </div>
    <div class="small text-muted">{{ \Illuminate\Support\Str::limit($plain, 140) }}</div>
    <div class="mt-auto pt-2">
      <a href="{{ route('public.blog-detail', $post->slug) }}" class="btn btn-outline-primary btn-sm">Baca</a>
    </div>
  </div>
</div>
<style>
  .post-card{ transition: box-shadow .18s ease, transform .18s ease; }
  .post-card:hover{ transform: translateY(-2px); box-shadow: 0 1rem 2rem rgba(0,0,0,.12); }
</style>
