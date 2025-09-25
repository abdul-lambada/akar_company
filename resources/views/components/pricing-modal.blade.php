<div class="modal fade" id="pricingModal" tabindex="-1" aria-labelledby="pricingModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pricingModalLabel">Paket Layanan & Harga</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="row gy-3">
          @forelse(($services ?? []) as $service)
            <div class="col-md-6">
              <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center">
                  <h6 class="card-title mb-1">{{ $service->service_name }}</h6>
                  <div class="h4 my-2">{{ !is_null($service->price) ? number_format((float)$service->price, 0, ',', '.') : 'Hubungi Kami' }}</div>
                  <div class="d-flex justify-content-center gap-2">
                    <a href="{{ route('public.service-details', $service->slug) }}" class="btn btn-outline-primary btn-sm">Detail</a>
                    <a href="{{ route('public.order.create', ['service_id' => $service->id, 'package_name' => $service->service_name]) }}" class="btn btn-primary btn-sm">Order Sekarang</a>
                  </div>
                </div>
              </div>
            </div>
          @empty
            <div class="col-12 text-center text-muted">Belum ada paket.</div>
          @endforelse
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <a href="{{ route('public.contact') }}" class="btn btn-primary">Konsultasi</a>
      </div>
    </div>
  </div>
</div>
