@extends('layouts.bizland')
@section('title','Tentang Kami')
@section('content')
<section id="about" class="about section light-background">
  <div class="container section-title" data-aos="fade-up">
    <h2>Tentang</h2>
    <p><span>Kenali</span> <span class="description-title">Kami</span></p>
  </div>
  <div class="container">
    <div class="row text-center mb-5">
      <div class="col-md-4"><h3>{{ $counters['years'] ?? 0 }}+</h3><div>Tahun Pengalaman</div></div>
      <div class="col-md-4"><h3>{{ $counters['projects'] ?? 0 }}</h3><div>Proyek</div></div>
      <div class="col-md-4"><h3>{{ $counters['clients'] ?? 0 }}</h3><div>Klien</div></div>
    </div>

    <h4 class="mb-3">Klien Kami</h4>
    <div class="row gy-4 mb-5">
      @forelse($clients as $client)
        <div class="col-6 col-md-3 text-center">
          <div class="p-3 border rounded-3">{{ $client->name ?? $client->client_name ?? 'Client' }}</div>
        </div>
      @empty
        <div class="col-12 text-muted">Belum ada klien.</div>
      @endforelse
    </div>

    <h4 class="mb-3">Tim</h4>
    <div class="row gy-4">
      @forelse($team as $member)
        <div class="col-md-4 col-lg-3">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center">
              <h5 class="card-title">{{ $member->full_name ?? $member->name }}</h5>
              <p class="text-muted small mb-0">{{ $member->email }}</p>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12 text-muted">Belum ada anggota tim.</div>
      @endforelse
    </div>
  </div>
</section>
@endsection
