@extends('layouts.bizland')
@section('title','Produk')
@section('meta_description','Daftar produk/layanan yang kami tawarkan')
@section('content')
<section class="services section">
  <div class="container section-title" data-aos="fade-up">
    <x-breadcrumbs :items="[[ 'label' => 'Home', 'url' => route('public.index') ], [ 'label' => 'Produk' ]]" title="Produk" />
    <p><span>Daftar</span> <span class="description-title">Produk</span></p>
  </div>
  <div class="container">
    <div class="row gy-4">
      @forelse($services as $service)
        <div class="col-lg-4 col-md-6" data-aos="fade-up">
          @include('components.service-card', ['service' => $service, 'showPrice' => true])
        </div>
      @empty
        <div class="col-12 text-center text-muted">Belum ada produk.</div>
      @endforelse
    </div>
    <x-pagination :paginator="$services" />
    <div class="text-center mt-5">
      <div class="card border-0 shadow-sm d-inline-block">
        <div class="card-body p-4">
          <h5 class="mb-2">Bingung memilih produk?</h5>
          <p class="text-muted mb-3">Konsultasi gratis dan mulai order sekarang.</p>
          <a href="{{ route('public.order.create') }}" class="btn btn-primary">Order Sekarang</a>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
