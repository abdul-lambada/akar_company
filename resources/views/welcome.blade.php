@extends('layouts.strategy')

@section('title', config('app.name', 'Akar Company'))
@section('meta_description', config('app.hero_description'))
@section('meta_keywords', 'jasa, agency, desain, pengembangan, pemasaran')

@section('content')
  <!-- Hero Section -->
  <section id="hero" class="hero section">
    <div class="container">
      <div class="row">
        <div class="col-lg-7 content-col" data-aos="fade-up">
          <div class="content">
            <div class="agency-name">
              <h5>{{ config('app.name', 'Akar Company') }}</h5>
            </div>
            <div class="main-heading">
              <h1>{{ config('app.hero_heading') }}</h1>
            </div>
            <div class="divider"></div>
            <div class="description">
              <p>{{ config('app.hero_description') }}</p>
            </div>
            <div class="cta-button">
              <a href="#services" class="btn">
                <span>JELAJAHI LAYANAN</span>
                <i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>
        </div>
        <div class="col-lg-5" data-aos="zoom-out">
          <div class="visual-content">
            <div class="fluid-shape">
              <img src="{{ asset('Strategy/assets/img/abstract/abstract-1.webp') }}" alt="Abstract" class="fluid-img">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Services Section -->
  <section id="services" class="services section">
    <div class="container section-title" data-aos="fade-up">
      <h2>{{ config('app.services_heading') }}</h2>
      <div><span>What We</span> <span class="description-title">{{ config('app.services_description') }}</span></div>
    </div>
    <div class="container">
      <div class="row gy-4">
        @foreach($services as $service)
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <x-service-card :service="$service" />
        </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Portfolio Section -->
  <section id="portfolio" class="portfolio section light-background">
    <div class="container section-title" data-aos="fade-up">
      <h2>{{ config('app.portfolio_heading') }}</h2>
      <div><span>Recent</span> <span class="description-title">{{ config('app.portfolio_description') }}</span></div>
    </div>
    <div class="container">
      <div class="row gy-4 portfolio-container" data-aos="fade-up" data-aos-delay="200">
        @foreach($projects as $project)
        <div class="col-xl-4 col-md-6 portfolio-item">
          <x-portfolio-card :project="$project" :gallery="'portfolio-gallery'" />
        </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Testimonials Section -->
  <section id="testimonials" class="section">
    <div class="container section-title" data-aos="fade-up">
      <h2>{{ config('app.testimonials_heading') }}</h2>
      <div><span>What Clients</span> <span class="description-title">{{ config('app.testimonials_description') }}</span></div>
    </div>
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row">
        @foreach($testimonials as $t)
        <div class="col-lg-4">
          <div class="testimonial-item">
            <p>"{{ $t->testimonial_text }}"</p>
            <div class="client-info d-flex align-items-center mt-4">
              @php $timg = $t->image_path ? asset('storage/'.$t->image_path) : asset('Strategy/assets/img/person/person-f-1.webp'); @endphp
              <img src="{{ $timg }}" class="client-img" alt="Client">
              <div>
                <h6 class="mb-0">{{ $t->client_name }}</h6>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </section>

  <!-- Contact CTA -->
  <section id="contact" class="section">
    <div class="container" data-aos="fade-up">
      <div class="text-center">
        <h3>{{ config('app.contact_cta_title') }}</h3>
        <p>{{ config('app.contact_cta_description') }}</p>
        <a class="btn btn-primary" href="https://wa.me/{{ preg_replace('/\D/', '', config('app.company_whatsapp', '')) }}" target="_blank">
          <i class="bi bi-whatsapp"></i> Chat WhatsApp
        </a>
      </div>
    </div>
  </section>
@endsection

@php
  // Gunakan data dari controller jika tersedia, fallback ke query langsung
  $services = $services ?? \App\Models\Service::orderBy('service_name')->take(6)->get();
  $projects = $projects ?? \App\Models\Portfolio::with(['images' => function($q){ $q->orderBy('id'); }])->latest()->take(6)->get();
  $testimonials = $testimonials ?? \App\Models\Testimonial::latest()->take(3)->get();
@endphp
