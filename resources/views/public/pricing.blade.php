@extends('layouts.bizland')
@section('title','Harga')
@section('content')
<section class="section">
  <div class="container section-title" data-aos="fade-up">
    <h2>Harga</h2>
    <p><span>Paket</span> <span class="description-title">Layanan</span></p>
  </div>
  <div class="container">
    <div class="row gy-4">
      @forelse($services as $service)
        <div class="col-md-6 col-lg-4">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center">
              <h5 class="card-title">{{ $service->service_name }}</h5>
              <h3 class="my-3">{{ !is_null($service->price) ? number_format((float)$service->price, 0, ',', '.') : 'Hubungi Kami' }}</h3>
              <a href="{{ route('public.service-details', $service->slug) }}" class="btn btn-primary">Lihat detail</a>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12 text-muted">Belum ada paket.</div>
      @endforelse
    </div>
  </div>
</section>
@endsection
