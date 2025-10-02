@extends('layouts.bizland')
@section('title', $service->service_name)
@section('meta_description', 'Produk ' . $service->service_name)
@section('content')
<section class="section">
  <div class="container" data-aos="fade-up">
    <x-breadcrumbs :items="[[ 'label' => 'Home', 'url' => route('public.index') ], [ 'label' => 'Produk', 'url' => route('public.products') ], [ 'label' => $service->service_name ]]" title="Detail Produk" />
  </div>
  <x-section-heading title="Detail Produk" :subtitle="$service->service_name" />
  <div class="container">
    @if(!is_null($service->price))
      <p class="text-muted">Harga mulai: {{ number_format((float)$service->price, 0, ',', '.') }}</p>
    @endif
    <div class="mb-4">
      <a href="{{ route('public.order.create', ['service_id' => $service->getKey(), 'package_name' => $service->service_name, 'budget' => $service->price]) }}" class="btn btn-primary"><i class="bi bi-bag-check me-2"></i>Order Sekarang</a>
    </div>

    <hr class="my-4">
    <h4 class="mb-3">Proyek terkait</h4>
    <div class="row gy-4">
      @forelse($projects as $project)
        @php $cover = $project->images->first(); @endphp
        <div class="col-lg-4 col-md-6">
          <div class="card h-100 border-0 shadow-sm">
            @if($cover)
              <img src="{{ $cover->url }}" class="card-img-top" alt="{{ $project->project_title }}" loading="lazy">
            @endif
            <div class="card-body">
              <h5 class="card-title mb-1">{{ $project->project_title }}</h5>
              <p class="card-text text-muted small mb-2">{{ $project->client_name }}</p>
              <a class="stretched-link" href="{{ route('public.portfolio-details', $project) }}">Detail</a>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12 text-muted">Belum ada proyek.</div>
      @endforelse
    </div>

    <x-pagination :paginator="$projects" />
  </div>
</section>
@endsection
