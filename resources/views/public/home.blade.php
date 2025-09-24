@extends('layouts.bizland')

@section('title','Home')
@section('body_class','index-page')

@section('content')
  <section id="hero" class="hero section light-background">
    <div class="container">
      <div class="row gy-4">
        <div class="col-lg-8 d-flex flex-column justify-content-center" data-aos="zoom-out">
          <h1>Selamat datang di <span>{{ config('app.name','BizLand') }}</span></h1>
          <p>Kami membantu Anda membangun solusi digital yang berdampak.</p>
          <div class="d-flex">
            <a href="{{ route('public.about') }}" class="btn-get-started">Tentang Kami</a>
            <a href="{{ route('public.contact') }}" class="btn-get-started ms-3">Kontak</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="services" class="services section">
    <div class="container section-title" data-aos="fade-up">
      <h2>Layanan</h2>
      <p><span>Jelajahi</span> <span class="description-title">Layanan Kami</span></p>
    </div>
    <div class="container">
      <div class="row gy-4">
        @forelse($services as $service)
          <div class="col-lg-4 col-md-6" data-aos="fade-up">
            <div class="service-item position-relative">
              <div class="icon"><i class="bi bi-briefcase"></i></div>
              <a href="{{ route('public.service-details', $service->slug) }}" class="stretched-link">
                <h3>{{ $service->service_name }}</h3>
              </a>
              @if(!is_null($service->price))
                <p class="mb-0 text-muted">Mulai {{ number_format((float)$service->price, 0, ',', '.') }}</p>
              @endif
            </div>
          </div>
        @empty
          <div class="col-12 text-center text-muted">Belum ada layanan.</div>
        @endforelse
      </div>
    </div>
  </section>

  <section id="portfolio" class="portfolio section">
    <div class="container section-title" data-aos="fade-up">
      <h2>Portfolio</h2>
      <p><span>Proyek</span> <span class="description-title">Terbaru</span></p>
    </div>
    <div class="container">
      <div class="row gy-4">
        @forelse($projects as $project)
          @php $cover = $project->images->first(); @endphp
          <div class="col-lg-4 col-md-6 portfolio-item">
            <div class="card h-100 border-0 shadow-sm">
              @if($cover)
                <img src="{{ $cover->url }}" class="card-img-top" alt="{{ $project->project_title }}">
              @endif
              <div class="card-body">
                <h5 class="card-title mb-1">{{ $project->project_title }}</h5>
                <p class="card-text text-muted small mb-2">{{ $project->client_name }}</p>
                <a href="{{ route('public.portfolio-details', $project) }}" class="stretched-link">Detail</a>
              </div>
            </div>
          </div>
        @empty
          <div class="col-12 text-center text-muted">Belum ada proyek.</div>
        @endforelse
      </div>
    </div>
  </section>

  <section id="clients" class="clients section light-background">
    <div class="container section-title" data-aos="fade-up">
      <h2>Clients</h2>
      <p><span>Beberapa</span> <span class="description-title">Klien Kami</span></p>
    </div>
    <div class="container">
      @php
        // Ambil client unik berdasarkan nama dari testimoni (pool lebih besar)
        $clientLogos = ($clientTestimonials ?? $testimonials ?? collect())
          ->filter(fn($t) => !empty($t->client_name))
          ->unique('client_name')
          ->take(12);
      @endphp
      <div class="row gy-4 align-items-center justify-content-center">
        @forelse($clientLogos as $t)
          <div class="col-6 col-md-3 col-lg-2 text-center" data-aos="fade-up">
            @if(!empty($t->image_url))
              <img src="{{ $t->image_url }}" alt="{{ $t->client_name }}" class="img-fluid rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
              <div class="small text-muted mt-2">{{ $t->client_name }}</div>
            @else
              <div class="p-3 border rounded-3">{{ $t->client_name }}</div>
            @endif
          </div>
        @empty
          <div class="col-12 text-center text-muted">Belum ada data klien.</div>
        @endforelse
      </div>
    </div>
  </section>

  <section id="testimonials" class="testimonials section dark-background">
    <div class="container section-title" data-aos="fade-up">
      <h2>Testimoni</h2>
      <p><span>Apa kata</span> <span class="description-title">Klien</span></p>
    </div>
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row gy-4">
        @forelse($testimonials as $t)
          <div class="col-lg-4">
            <div class="p-4 bg-dark text-white h-100 rounded-3">
              <p class="mb-2">“{{ $t->testimonial_text ?? '' }}”</p>
              <div class="small opacity-75">— {{ $t->author_name ?? ($t->client_name ?? 'Klien') }}</div>
            </div>
          </div>
        @empty
          <div class="col-12 text-center text-muted">Belum ada testimoni.</div>
        @endforelse
      </div>
    </div>
  </section>

  <section id="blog" class="section">
    <div class="container section-title" data-aos="fade-up">
      <h2>Blog</h2>
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
              </div>
            </div>
          </div>
        @empty
          <div class="col-12 text-center text-muted">Belum ada postingan.</div>
        @endforelse
      </div>
    </div>
  </section>
@endsection
