@extends('layouts.public')

@section('title', 'Services')
@section('meta_description', 'Layanan ' . config('app.name') . ' — jelajahi paket layanan dan solusi yang kami tawarkan untuk bisnis Anda.')

@section('content')
<section class="section-gap services-area wow fadeInUp" id="services">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="product-area-title text-center">
          <p class="text-uppercase">{{ config('app.services_description', 'What We Offer') }}</p>
          <h2 class="h1">{{ config('app.services_heading', 'Services') }}</h2>
        </div>
      </div>
    </div>
    <div class="row wow fadeInUp">
      @forelse($services as $service)
        <div class="col-lg-4 col-md-6">
          <div class="single-service d-flex flex-column p-4 border rounded h-100">
            <h4 class="mb-2">{{ $service->service_name }}</h4>
            @if(!is_null($service->price))
              <div class="text-primary mb-2">{{ config('app.currency', 'Rp') }} {{ number_format($service->price, 0, ',', '.') }}</div>
            @endif
            <p class="flex-grow-1 text-muted">Hubungi kami untuk informasi lebih lanjut.</p>
            <a href="{{ route('public.service-details', $service->slug) }}" class="text-uppercase">Details</a>
          </div>
        </div>
      @empty
        <div class="col-12"><p class="text-center">No services available.</p></div>
      @endforelse
    </div>
    <div class="d-flex justify-content-center mt-4">
      {{ $services->links() }}
    </div>
  </div>
</section>
@endsection