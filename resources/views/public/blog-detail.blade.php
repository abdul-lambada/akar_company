@extends('layouts.public')

@section('title', $post->title)

@section('content')
<section class="section-gap" id="blog-detail">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <article class="single-post">
          <h1 class="mb-3">{{ $post->title }}</h1>
          <p class="text-muted mb-4">oleh {{ optional($post->user)->name ?? 'Admin' }} · {{ $post->created_at?->format('d M Y') }}</p>
          @php
            $thumb = optional($post->images->first())->image_path;
          @endphp
          @if($thumb)
            <img src="{{ asset('storage/'.$thumb) }}" class="img-fluid rounded mb-4" alt="{{ $post->title }}">
          @endif
          <div class="content">
            {!! $post->content !!}
          </div>
        </article>
        @if($related->count())
        <hr class="my-5">
        <h4 class="mb-3">Artikel Terkait</h4>
        <div class="row">
          @foreach($related as $rel)
            @php $img = optional($rel->images->first())->image_path; @endphp
            <div class="col-md-4 mb-3">
              <a href="{{ route('public.blog-detail', $rel->slug) }}" class="d-block">
                <img src="{{ $img ? asset('storage/'.$img) : asset('public_template/img/s3.jpg') }}" class="img-fluid rounded" alt="{{ $rel->title }}">
                <div class="mt-2 small">{{ \Illuminate\Support\Str::limit($rel->title, 50) }}</div>
              </a>
            </div>
          @endforeach
        </div>
        @endif
      </div>
    </div>
  </div>
</section>
@endsection