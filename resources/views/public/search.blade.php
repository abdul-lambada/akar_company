@extends('layouts.public')

@section('title', 'Search')

@section('content')
<section class="section-gap" id="search">
  <div class="container">
    <div class="row justify-content-center mb-4">
      <div class="col-lg-8 text-center">
        <h2 class="h1">Hasil Pencarian</h2>
        <p class="text-muted">Kata kunci: <strong>{{ $q }}</strong></p>
        <form action="{{ route('public.search') }}" method="get" class="mt-3">
          <div class="input-group">
            <input type="text" class="form-control" name="q" value="{{ $q }}" placeholder="Cari layanan, proyek, atau artikel...">
            <button class="btn btn-primary" type="submit">Cari</button>
          </div>
        </form>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-4 mb-4">
        <h4>Layanan</h4>
        <ul class="list-unstyled">
          @forelse($services as $s)
            <li class="mb-2"><a href="{{ route('public.service-details', $s->slug) }}">{{ $s->service_name }}</a></li>
          @empty
            <li class="text-muted">Tidak ditemukan.</li>
          @endforelse
        </ul>
      </div>
      <div class="col-lg-4 mb-4">
        <h4>Portfolio</h4>
        @forelse($projects as $p)
          @php $thumb = optional($p->images->first())->image_path; @endphp
          <div class="d-flex mb-3">
            <a class="me-3" href="{{ route('public.portfolio-details', $p) }}">
              <img src="{{ $thumb ? asset('storage/'.$thumb) : asset('public_template/img/p4.jpg') }}" alt="{{ $p->project_title }}" width="80" height="60" class="rounded" style="object-fit:cover;">
            </a>
            <div>
              <a href="{{ route('public.portfolio-details', $p) }}" class="fw-semibold">{{ $p->project_title }}</a>
              <div class="small text-muted">Client: {{ $p->client_name }}</div>
            </div>
          </div>
        @empty
          <div class="text-muted">Tidak ditemukan.</div>
        @endforelse
      </div>
      <div class="col-lg-4 mb-4">
        <h4>Artikel</h4>
        @forelse($posts as $post)
          @php $thumb = optional($post->images->first())->image_path; @endphp
          <div class="d-flex mb-3">
            <a class="me-3" href="{{ route('public.blog-detail', $post->slug) }}">
              <img src="{{ $thumb ? asset('storage/'.$thumb) : asset('public_template/img/s2.jpg') }}" alt="{{ $post->title }}" width="80" height="60" class="rounded" style="object-fit:cover;">
            </a>
            <div>
              <a href="{{ route('public.blog-detail', $post->slug) }}" class="fw-semibold">{{ $post->title }}</a>
              <div class="small text-muted">{{ \Illuminate\Support\Str::limit(strip_tags($post->content), 120) }}</div>
            </div>
          </div>
        @empty
          <div class="text-muted">Tidak ditemukan.</div>
        @endforelse
      </div>
    </div>
  </div>
</section>
@endsection