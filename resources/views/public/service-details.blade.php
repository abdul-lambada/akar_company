@extends('layouts.strategy')

@section('title', $service->service_name . ' - ' . config('app.name', 'Akar Company'))
@section('meta_description', 'Detail layanan ' . $service->service_name . ' dari ' . config('app.name'))
@section('meta_keywords', $service->service_name . ', layanan, jasa, harga')

@section('content')
  <section class="section" id="service-details">
    <div class="container section-title" data-aos="fade-up">
      <h2>{{ $service->service_name }}</h2>
      <div><span>About</span> <span class="description-title">{{ config('app.services_description') }}</span></div>
    </div>

    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="row">
        <div class="col-lg-8">
          <div class="content">
            @if(!empty($service->description))
              <p>{!! nl2br(e($service->description)) !!}</p>
            @else
              <p>Informasi detail layanan akan segera tersedia.</p>
            @endif
          </div>
        </div>
        <div class="col-lg-4">
          <div class="info-box p-4">
            <h5 class="mb-3">Harga</h5>
            <p class="mb-0">Mulai dari Rp {{ number_format($service->price ?? 0, 0, ',', '.') }}</p>
            <div class="mt-3">
              <a class="btn btn-primary w-100" href="https://wa.me/{{ preg_replace('/\D/', '', config('app.company_whatsapp', '')) }}" target="_blank">
                <i class="bi bi-whatsapp"></i> Konsultasi via WhatsApp
              </a>
            </div>
          </div>
        </div>
      </div>

      <hr class="my-5">

      <div class="section-title">
        <h3>Contoh Proyek Terkait</h3>
        <div><span>Recent</span> <span class="description-title">Projects</span></div>
      </div>

      <div class="row gy-4">
        @forelse($projects as $project)
          @php $cover = optional($project->images->first())->image_path; @endphp
          <div class="col-xl-4 col-md-6">
            <div class="portfolio-item">
              <x-portfolio-card :project="$project" :gallery="'service-related'" />
            </div>
          </div>
        @empty
          <div class="col-12"><p>Belum ada proyek terkait untuk layanan ini.</p></div>
        @endforelse
      </div>

      <div class="mt-4">
        {{ $projects->links() }}
      </div>
    </div>
  </section>
@endsection