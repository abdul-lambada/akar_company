<div class="service-item position-relative d-flex flex-column h-100 w-100">
  <div class="card h-100 border-0 shadow-sm w-100">
    <div class="card-body d-flex flex-column align-items-center text-center p-4 pb-3">
      <div class="icon mb-3 w-100 d-flex justify-content-center">
    @php
      $logo = config('app.logo');
      $logoUrl = null;
      if (!empty($logo)) {
        if (\Illuminate\Support\Str::startsWith($logo, ['http://', 'https://', '/'])) {
          $logoUrl = $logo;
        } else {
          $logoUrl = \Illuminate\Support\Facades\Storage::url($logo);
        }
      }
      $logoUrl = $logoUrl ?: asset('BizLand/assets/img/logo.png');
    @endphp
        <img src="{{ $logoUrl }}" alt="{{ config('app.name','BizLand') }} logo" class="rounded-circle" style="width: 48px; height: 48px; object-fit: cover;" loading="lazy">
      </div>
@push('styles')
<style>
  .service-item .card, .service-item{ transition: transform .16s ease, box-shadow .16s ease; }
  .service-item:hover{ transform: translateY(-3px); box-shadow: 0 12px 24px rgba(0,0,0,.08); }
  .service-item .icon img{ transition: transform .16s ease; }
  .service-item:hover .icon img{ transform: scale(1.05); }
  .portfolio-item .card{ transition: transform .16s ease, box-shadow .16s ease; }
  .portfolio-item .card:hover{ transform: translateY(-4px); box-shadow: 0 14px 28px rgba(0,0,0,.10); }
  .portfolio-item img{ transition: transform .2s ease; }
  .portfolio-item .card:hover img{ transform: scale(1.02); }
</style>
@endpush
      <a href="{{ route('public.product-details', $service->slug) }}" class="text-decoration-none"><h3 class="h4 mb-2">{{ $service->service_name }}</h3></a>
      @if(($showPrice ?? true))
        <div class="text-muted small">Mulai dari</div>
        <div class="h5 mb-3">{{ !is_null($service->price) ? 'Rp ' . number_format((float)$service->price, 0, ',', '.') : 'Hubungi Kami' }}</div>
      @endif
      <div class="mt-auto pt-1 d-flex gap-2 position-relative" style="z-index:2;">
        <a href="{{ route('public.product-details', $service->slug) }}" class="btn btn-outline-primary btn-sm">Detail</a>
        <a href="{{ route('public.order.create', ['service_id' => $service->getKey(), 'package_name' => $service->service_name, 'budget' => $service->price]) }}" class="btn btn-primary btn-sm">Order Sekarang</a>
      </div>
    </div>
  </div>
</div>