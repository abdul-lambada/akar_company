@extends('layouts.niceadmin')

@section('title', 'Dashboard')
@section('content')
<div class="pagetitle">
  <h1>Dashboard</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ url('/') }}">Beranda</a></li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
  </nav>
</div>
<section class="section dashboard">
  <div class="row g-3">
    <!-- Orders Today -->
    <div class="col-xxl-3 col-md-6">
      <div class="card info-card sales-card h-100">
        <div class="card-body">
          <h5 class="card-title">Order <span>| Hari Ini</span></h5>
          <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
              <i class="bi bi-bag-check"></i>
            </div>
            <div class="ps-3">
              <h6>{{ number_format($todayOrdersCount ?? 0) }}</h6>
              <span class="text-muted small pt-2 ps-1">total order baru</span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Revenue Month -->
    <div class="col-xxl-4 col-md-6">
      <div class="card info-card revenue-card h-100">
        <div class="card-body">
          <h5 class="card-title">Pendapatan <span>| Bulan Ini</span></h5>
          <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
              <i class="bi bi-currency-dollar"></i>
            </div>
            <div class="ps-3">
              <h6>Rp {{ number_format($monthRevenue ?? 0, 0, ',', '.') }}</h6>
              <span class="text-muted small pt-2 ps-1">total nilai order bulan ini</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Customers Year -->
    <div class="col-xxl-3 col-md-6">
      <div class="card info-card customers-card h-100">
        <div class="card-body">
          <h5 class="card-title">Klien <span>| Tahun Ini</span></h5>
          <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
              <i class="bi bi-people"></i>
            </div>
            <div class="ps-3">
              <h6>{{ number_format($yearCustomers ?? 0) }}</h6>
              <span class="text-muted small pt-2 ps-1">klien baru terdaftar</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Services Active -->
    <div class="col-xxl-2 col-md-6">
      <div class="card info-card h-100">
        <div class="card-body">
          <h5 class="card-title">Layanan <span>| Aktif</span></h5>
          <div class="d-flex align-items-center">
            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
              <i class="bi bi-grid"></i>
            </div>
            <div class="ps-3">
              <h6>{{ number_format($servicesCount ?? 0) }}</h6>
              <span class="text-muted small pt-2 ps-1">jenis layanan</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Trend Charts -->
  <div class="row mt-3 g-3">
    <div class="col-md-6">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title">Tren Order 30 Hari</h5>
          <canvas id="ordersChart" height="120"></canvas>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title">Tren Pendapatan 30 Hari</h5>
          <canvas id="revenueChart" height="120"></canvas>
        </div>
      </div>
    </div>
  </div>

  <!-- Pending Orders & Unpaid Invoices -->
  <div class="row mt-3 g-3">
    <div class="col-md-6">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title">Order Belum Selesai</h5>
          @if(!empty($pendingOrders) && count($pendingOrders))
          <div class="table-responsive">
            <table class="table table-sm align-middle">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Layanan</th>
                  <th>Status</th>
                  <th>Tanggal</th>
                </tr>
              </thead>
              <tbody>
                @foreach($pendingOrders as $po)
                <tr>
                  <td>{{ $po->id ?? $po->order_id }}</td>
                  <td>
                    @if(!empty($po->service))
                      {{ $po->service->service_name }}
                    @else
                      <span class="badge text-bg-light border">Tidak ada layanan</span>
                    @endif
                  </td>
                  <td><span class="badge bg-warning text-dark">{{ ucfirst($po->status ?? 'pending') }}</span></td>
                  <td>{{ optional($po->created_at)->format('d M Y') }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @else
            <p class="text-muted small mb-0">Tidak ada order pending.</p>
          @endif
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card h-100">
        <div class="card-body">
          <h5 class="card-title">Invoice Belum Lunas</h5>
          @if(!empty($unpaidInvoices) && count($unpaidInvoices))
          <div class="table-responsive">
            <table class="table table-sm align-middle">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Klien</th>
                  <th>Total</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach($unpaidInvoices as $inv)
                <tr>
                  <td>{{ $inv->id ?? $inv->invoice_id }}</td>
                  <td>{{ $inv->client->client_name ?? '-' }}</td>
                  <td>Rp {{ number_format($inv->total_amount ?? 0, 0, ',', '.') }}</td>
                  <td><span class="badge bg-danger">{{ ucfirst($inv->status ?? 'unpaid') }}</span></td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @else
            <p class="text-muted small mb-0">Tidak ada invoice belum lunas.</p>
          @endif
        </div>
      </div>
    </div>
  </div>
            <div class="ps-3">
              <h6>{{ number_format($todayOrdersCount ?? 0) }}</h6>
              <span class="text-muted small pt-2 ps-1">total order baru</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Recent Orders -->
  <div class="row mt-3">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Order Terbaru</h5>
          @if(!empty($recentOrders) && count($recentOrders))
          <div class="table-responsive">
            <table class="table table-sm align-middle">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Layanan</th>
                  <th>Total</th>
                  <th>Status</th>
                  <th>Tanggal</th>
                </tr>
              </thead>
              <tbody>
                @foreach($recentOrders as $o)
                  <tr>
                    <td>{{ $o->id ?? $o->order_id }}</td>
                    <td>
                      @if(!empty($o->service))
                        {{ $o->service->service_name }}
                      @else
                        <span class="badge text-bg-light border">Tidak ada layanan</span>
                      @endif
                    </td>
                    <td>Rp {{ number_format($o->total_amount ?? 0, 0, ',', '.') }}</td>
                    <td><span class="badge bg-{{ ($o->status ?? 'baru') === 'selesai' ? 'success' : 'secondary' }}">{{ ucfirst($o->status ?? 'baru') }}</span></td>
                    <td>{{ optional($o->created_at)->format('d M Y') }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          @else
            <p class="text-muted small mb-0">Belum ada data order terbaru.</p>
          @endif
          <div class="mt-3 text-end">
            <a href="{{ route('orders.index') }}" class="btn btn-outline-primary btn-sm">Lihat semua order</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  (function(){
    const labels = @json($labels ?? []);
    const ordersSeries = @json($ordersSeries ?? []);
    const revenueSeries = @json($revenueSeries ?? []);
    const fmt = (n)=> new Intl.NumberFormat('id-ID').format(n||0);
    const ordersCtx = document.getElementById('ordersChart');
    if (ordersCtx && labels.length){
      new Chart(ordersCtx, {
        type:'line',
        data:{labels, datasets:[{label:'Order', data:ordersSeries, borderColor:'#2563eb', backgroundColor:'rgba(37,99,235,.15)', fill:true, tension:.3}]},
        options:{plugins:{legend:{display:false}}, scales:{y:{ticks:{callback:(v)=>fmt(v)}}}}
      });
    }
    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx && labels.length){
      new Chart(revenueCtx, {
        type:'line',
        data:{labels, datasets:[{label:'Pendapatan', data:revenueSeries, borderColor:'#16a34a', backgroundColor:'rgba(22,163,74,.15)', fill:true, tension:.3}]},
        options:{plugins:{legend:{display:false}}, scales:{y:{ticks:{callback:(v)=>'Rp '+fmt(v)}}}}
      });
    }
  })();
</script>
@endpush
@endsection