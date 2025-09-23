@extends('layouts.public')

@section('title', 'Blog')
@section('meta_description', 'Blog ' . config('app.name') . ' — artikel, berita, dan insight seputar desain, teknologi, dan pengembangan produk.')

@section('content')
<section class="section-gap" id="blog">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="product-area-title text-center">
          <p class="text-uppercase">Artikel</p>
          <h2 class="h1">Blog</h2>
        </div>
      </div>
    </div>
    <div class="row">
      @forelse($posts as $post)
        @php
          $thumb = optional($post->images->first())->image_path;
          $img = $thumb ? asset('storage/'.$thumb) : asset('public_template/img/s2.jpg');
        @endphp
        <div class="col-lg-4 col-md-6">
          <div class="single-blog border rounded h-100 d-flex flex-column overflow-hidden">
            <a href="{{ route('public.blog-detail', $post->slug) }}" class="d-block">
              <img src="{{ $img }}" class="img-fluid w-100" alt="{{ $post->title }}">
            </a>
            <div class="p-3 d-flex flex-column flex-grow-1">
              <h5 class="mb-1"><a href="{{ route('public.blog-detail', $post->slug) }}" class="text-dark">{{ $post->title }}</a></h5>
              <p class="small text-muted mb-2">oleh {{ optional($post->user)->name ?? 'Admin' }} · {{ $post->created_at?->format('d M Y') }}</p>
              <p class="text-muted flex-grow-1">{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 120) }}</p>
              <div class="mt-2">
                <a href="{{ route('public.blog-detail', $post->slug) }}" class="primary-btn d-inline-flex align-items-center">Baca Selengkapnya <span class="lnr lnr-arrow-right ml-2"></span></a>
              </div>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12"><p class="text-center">Belum ada artikel.</p></div>
      @endforelse
    </div>
    <div class="d-flex justify-content-center mt-4">
      {{ $posts->links() }}
    </div>
  </div>
</section>
@endsection