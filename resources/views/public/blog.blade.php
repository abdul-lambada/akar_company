@extends('layouts.bizland')
@section('title','Blog')
@section('content')
<section class="section">
  <div class="container section-title" data-aos="fade-up">
    <x-breadcrumbs :items="[[ 'label' => 'Home', 'url' => route('public.index') ], [ 'label' => 'Blog' ]]" title="Blog" />
    <p><span>Tulisan</span> <span class="description-title">Terbaru</span></p>
  </div>
  <div class="container">
    <div class="row gy-4">
      @forelse($posts as $post)
        @php $thumb = $post->images->first(); @endphp
        <div class="col-lg-4 col-md-6">
          <div class="card h-100 border-0 shadow-sm">
            @if($thumb)
              <img src="{{ $thumb->url }}" class="card-img-top" alt="{{ $post->title }}">
            @endif
            <div class="card-body">
              <a href="{{ route('public.blog-detail', $post->slug) }}" class="text-decoration-none"><h5 class="card-title">{{ $post->title }}</h5></a>
              <p class="card-text text-muted small">Oleh {{ $post->user->full_name ?? ($post->user->name ?? 'Admin') }}</p>
              <div class="small text-muted">{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 120) }}</div>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12 text-center text-muted">Belum ada postingan.</div>
      @endforelse
    </div>
    <x-pagination :paginator="$posts" />
  </div>
</section>
@endsection
