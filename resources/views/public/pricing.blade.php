@extends('layouts.public')

@section('title', 'Pricing')

@section('content')
<section class="section-gap" id="pricing">
  <div class="container">
    <div class="row">
      @forelse($services as $service)
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="single-price p-4 border rounded h-100 text-center">
            <h4 class="mb-2">{{ $service->service_name }}</h4>
            @if(!is_null($service->price))
              <h2 class="mb-3">Rp {{ number_format($service->price, 0, ',', '.') }}</h2>
            @else
              <h6 class="text-muted mb-3">Contact us for pricing</h6>
            @endif
            <p class="text-muted">Paket layanan sesuai kebutuhan Anda.</p>
            <a href="{{ route('public.service-details', $service->slug) }}" class="primary-btn mt-3 d-inline-block">Choose</a>
          </div>
        </div>
      @empty
        <div class="col-12"><p class="text-center">No pricing available.</p></div>
      @endforelse
    </div>
  </div>
</section>
@endsection