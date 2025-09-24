@extends('layouts.bizland')
@section('title','Layanan')
@section('content')
<section class="services section">
  <div class="container section-title" data-aos="fade-up">
    <x-breadcrumbs :items="[[ 'label' => 'Home', 'url' => route('public.index') ], [ 'label' => 'Layanan' ]]" title="Layanan" />
    <p><span>Daftar</span> <span class="description-title">Layanan</span></p>
  </div>
  <div class="container">
    <div class="row gy-4">
      @forelse($services as $service)
        <div class="col-lg-4 col-md-6" data-aos="fade-up">
          <div class="service-item position-relative h-100">
            <div class="icon"><i class="bi bi-gear"></i></div>
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
    <x-pagination :paginator="$services" />
  </div>
</section>
@endsection
