@extends('layouts.bizland')
@section('title','Tentang Kami')
@section('meta_description','Profil singkat perusahaan dan tim kami')
@section('content')
<section id="about" class="about section light-background">
  <div class="container section-title" data-aos="fade-up">
    <x-breadcrumbs :items="[[ 'label' => 'Home', 'url' => route('public.index') ], [ 'label' => 'Tentang' ]]" title="Tentang" />
    <p><span>Kenali</span> <span class="description-title">Kami</span></p>
  </div>
  <div class="container">
    <div class="row mb-5">
      <div class="col-md-4 mb-3 mb-md-0">
        <div class="card h-100 border-0 shadow-sm text-center">
          <div class="card-body py-4">
            <div class="display-6 fw-bold mb-1">{{ $counters['years'] ?? 0 }}+</div>
            <div class="text-muted">Tahun Pengalaman</div>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-3 mb-md-0">
        <div class="card h-100 border-0 shadow-sm text-center">
          <div class="card-body py-4">
            <div class="display-6 fw-bold mb-1">{{ $counters['projects'] ?? 0 }}</div>
            <div class="text-muted">Proyek</div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card h-100 border-0 shadow-sm text-center">
          <div class="card-body py-4">
            <div class="display-6 fw-bold mb-1">{{ $counters['clients'] ?? 0 }}</div>
            <div class="text-muted">Klien</div>
          </div>
        </div>
      </div>
    </div>

    <h4 class="mb-3">Klien Kami</h4>
    <div class="mb-5">
      @php
        $clientLogos = \App\Models\Testimonial::latest()->take(24)->get()
          ->filter(fn($t) => !empty($t->client_name))
          ->unique('client_name')
          ->values();
      @endphp
      @if($clientLogos->isEmpty())
        <div class="text-muted">Belum ada klien.</div>
      @else
        <div class="swiper init-swiper">
          <script type="application/json" class="swiper-config">
          {
            "loop": true,
            "speed": 600,
            "autoplay": { "delay": 5000 },
            "slidesPerView": "auto",
            "pagination": { "el": ".swiper-pagination", "type": "bullets", "clickable": true },
            "breakpoints": {
              "320": { "slidesPerView": 2, "spaceBetween": 30 },
              "576": { "slidesPerView": 3, "spaceBetween": 40 },
              "768": { "slidesPerView": 4, "spaceBetween": 60 },
              "992": { "slidesPerView": 6, "spaceBetween": 80 }
            }
          }
          </script>
          <div class="swiper-wrapper align-items-center">
            @foreach($clientLogos as $t)
              <div class="swiper-slide text-center">
                @if(!empty($t->image_url))
                  <img src="{{ $t->image_url }}" alt="{{ $t->client_name }}" class="img-fluid rounded-circle" style="width: 80px; height: 80px; object-fit: cover;" loading="lazy">
                @else
                  <div class="p-3 border rounded-3">{{ $t->client_name }}</div>
                @endif
                <div class="small text-muted mt-2">{{ $t->client_name }}</div>
              </div>
            @endforeach
          </div>
          <div class="swiper-pagination"></div>
        </div>
      @endif
    </div>

    <h4 class="mb-3">Tim</h4>
    <div class="swiper init-swiper">
      <script type="application/json" class="swiper-config">
      {
        "loop": true,
        "speed": 600,
        "autoplay": { "delay": 5000 },
        "slidesPerView": "auto",
        "pagination": { "el": ".swiper-pagination", "type": "bullets", "clickable": true },
        "breakpoints": {
          "320": { "slidesPerView": 1, "spaceBetween": 20 },
          "768": { "slidesPerView": 3, "spaceBetween": 24 },
          "992": { "slidesPerView": 4, "spaceBetween": 24 }
        }
      }
      </script>
      <style>
        /* Scoped hover indicator for team swiper cards */
        .team-mini-card{position:relative; overflow:hidden}
        .team-mini-card .hover-indicator{position:absolute; left:0; right:0; bottom:0; height:46px; display:flex; align-items:center; justify-content:center; color:#fff; font-weight:600; letter-spacing:.2px; background:linear-gradient(180deg, rgba(15,23,42,0) 0%, rgba(15,23,42,.66) 100%); opacity:0; transform:translateY(8px); transition:all .18s ease}
        .team-mini-card:hover .hover-indicator{opacity:1; transform:translateY(0)}
      </style>
      <div class="swiper-wrapper">
        @forelse($team as $member)
          <div class="swiper-slide">
            <div class="card h-100 border-0 shadow-sm text-center p-3 team-mini-card">
              @php
                $email = strtolower(trim((string)($member->email ?? '')));
                $hash = md5($email);
                $avatar = 'https://www.gravatar.com/avatar/' . $hash . '?s=160&d=identicon';
                if (!empty($member->avatar)) {
                  $avatar = \Illuminate\Support\Str::startsWith($member->avatar, ['http://','https://','/']) ? $member->avatar : asset('storage/'.$member->avatar);
                }
                $detailUrl = !empty($member->slug) ? route('public.team-detail', $member->slug) : null;
              @endphp
              <a href="{{ $detailUrl ?: '#' }}" class="text-decoration-none {{ $detailUrl ? '' : 'pointer-events-none' }}">
                <img src="{{ $avatar }}" alt="{{ $member->full_name ?? $member->name }}" class="rounded-circle mx-auto mb-2" style="width: 80px; height: 80px; object-fit: cover;">
                <h6 class="mb-0">{{ $member->full_name ?? $member->name }}</h6>
              <div class="text-muted small">{{ $member->job_title ?? ($member->role ?? 'Anggota Tim') }}</div>
              @if(!empty($member->short_bio))
                <p class="text-muted small mb-0 mt-1">{{ \Illuminate\Support\Str::limit($member->short_bio, 80) }}</p>
              @endif
              @if($detailUrl)
                <div class="hover-indicator">Lihat Detail</div>
              @endif
            </div>
          </div>
        @empty
          <div class="swiper-slide text-center text-muted">Belum ada anggota tim.</div>
        @endforelse
      </div>
      <div class="swiper-pagination"></div>
    </div>
  </div>
</section>
@endsection
