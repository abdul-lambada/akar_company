@extends('layouts.bizland')
@section('title', $post->title)
@section('content')
<section class="section">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <h1 class="mb-3">{{ $post->title }}</h1>
        <p class="text-muted">Oleh {{ $post->user->full_name ?? ($post->user->name ?? 'Admin') }}</p>
        <article class="mt-4">
          {!! $post->content !!}
        </article>
      </div>
      <div class="col-lg-4">
        @if($related->count())
          <h5>Artikel terkait</h5>
          <ul class="list-unstyled">
            @foreach($related as $r)
              <li class="mb-2"><a href="{{ route('public.blog-detail', $r->slug) }}">{{ $r->title }}</a></li>
            @endforeach
          </ul>
        @endif
      </div>
    </div>
  </div>
</section>
@endsection
