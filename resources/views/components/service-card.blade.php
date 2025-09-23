<div class="service-item position-relative">
  <div class="icon">
    <i class="bi bi-stack"></i>
  </div>
  <a href="{{ route('public.service-details', $service->slug) }}" class="stretched-link">
    <h3>{{ $service->service_name }}</h3>
  </a>
  @if(($showPrice ?? true))
    <p>Mulai dari Rp {{ number_format($service->price ?? 0, 0, ',', '.') }}</p>
  @endif
</div>