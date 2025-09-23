@extends('layouts.strategy')

@section('title', $project->project_title . ' - ' . config('app.name', 'Akar Company'))
@section('meta_description', 'Detail proyek ' . $project->project_title . ' dari ' . config('app.name'))
@section('meta_keywords', 'portfolio, proyek, galeri, ' . $project->project_title)

@section('content')
  <section class="section" id="portfolio-details">
    <div class="container section-title" data-aos="fade-up">
      <h2>{{ $project->project_title }}</h2>
      <div><span>Client</span> <span class="description-title">{{ $project->client_name }}</span></div>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row">
        <div class="col-lg-8">
          <div class="row gy-4">
            @php $images = $project->images; @endphp
            @forelse($images as $img)
              <div class="col-md-6">
                <div class="portfolio-content">
                  <a href="{{ asset('storage/'.$img->image_path) }}" class="glightbox" data-gallery="portfolio-detail">
                    <img src="{{ asset('storage/'.$img->image_path) }}" class="img-fluid" alt="{{ $project->project_title }}">
                  </a>
                </div>
              </div>
            @empty
              <div class="col-12"><p>Belum ada gambar untuk proyek ini.</p></div>
            @endforelse
          </div>
        </div>
        <div class="col-lg-4">
          <div class="info-box p-4">
            <h5 class="mb-3">Informasi Proyek</h5>
            <p class="mb-1"><strong>Klien:</strong> {{ $project->client_name }}</p>
            @if(!empty($project->description))
              <p class="mt-3">{!! nl2br(e($project->description)) !!}</p>
            @endif
            <div class="mt-3">
              @if(count($project->services))
                <h6>Layanan Terkait:</h6>
                <ul class="mb-0">
                  @foreach($project->services as $s)
                    <li><a href="{{ route('public.service-details', $s->slug) }}">{{ $s->service_name }}</a></li>
                  @endforeach
                </ul>
              @endif
            </div>
            <div class="mt-4">
              <a class="btn btn-primary w-100" href="https://wa.me/{{ preg_replace('/\D/', '', config('app.company_whatsapp', '')) }}" target="_blank">
                <i class="bi bi-whatsapp"></i> Tanya Proyek Ini
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection