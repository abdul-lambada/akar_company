@extends('layouts.bizland')

@section('title','Beranda')
@section('body_class','index-page')

@section('content')
  <section id="hero" class="hero section hero-pro">
    <div class="container">
      <div class="row gy-4 align-items-center">
        <div class="col-md-8 d-flex flex-column justify-content-center text-center text-md-start" data-aos="zoom-out">
          @php
            $heroTitle = (string) (config('app.hero_heading') ?: 'Solusi Kreatif & Strategis untuk Bisnis Anda');
            $heroDesc  = (string) (config('app.hero_description') ?: 'Kami membantu brand tumbuh melalui layanan desain, pengembangan, dan strategi pemasaran yang berdampak.');
          @endphp
          <h1 class="mb-2">{{ $heroTitle }}</h1>
          <p class="mb-3 mb-md-4">{{ $heroDesc }}</p>
          <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-2">
            <a href="{{ route('public.about') }}" class="btn-get-started">Tentang Kami</a>
            <a href="{{ route('public.contact') }}" class="btn-get-started ms-0 ms-md-2">Kontak</a>
            <a href="#" class="btn-get-started ms-0 ms-md-2" data-bs-toggle="modal" data-bs-target="#pricingModal">Lihat Harga</a>
          </div>
        </div>
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
        <div class="col-12 col-md-4 d-flex align-items-center justify-content-center mt-3 mt-md-0" data-aos="zoom-in">
          <div class="hero-blob position-relative">
            <img src="{{ $logoUrl }}" alt="{{ config('app.name','BizLand') }}" class="hero-blob-logo">
          </div>
        </div>
      </div>
    </div>
  </section>

  @push('styles')
  @php
    $primaryHex = (string) config('app.brand_primary', '#2563eb');
    $accentHex  = (string) config('app.brand_accent', '#f59e0b');
    $hexToRgb = function($hex){
      $hex = ltrim($hex, '#');
      if (strlen($hex) === 3) { $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2]; }
      $int = hexdec($hex);
      return [($int >> 16) & 255, ($int >> 8) & 255, $int & 255];
    };
    [$pr,$pg,$pb] = $hexToRgb($primaryHex);
    [$ar,$ag,$ab] = $hexToRgb($accentHex);
  @endphp
  <style>
    :root{
      --brand-primary: {{ $primaryHex }};
      --brand-accent:  {{ $accentHex }};
      --bp-r: {{ $pr }}; --bp-g: {{ $pg }}; --bp-b: {{ $pb }};
      --ba-r: {{ $ar }}; --ba-g: {{ $ag }}; --ba-b: {{ $ab }};
    }
    /* Professional hero using brand-based gradients */
    .hero.hero-pro {
      position: relative;
      padding: 80px 0 60px;
      background:
        radial-gradient(1200px 600px at 12% 0%, rgba(var(--bp-r), var(--bp-g), var(--bp-b), .14) 0%, rgba(var(--bp-r), var(--bp-g), var(--bp-b), .08) 28%, transparent 60%),
        radial-gradient(950px 520px at 88% 12%, rgba(var(--ba-r), var(--ba-g), var(--ba-b), .16) 0%, rgba(var(--ba-r), var(--ba-g), var(--ba-b), .10) 32%, transparent 66%),
        linear-gradient(135deg, #f8fbff 0%, color-mix(in srgb, var(--brand-primary) 18%, #ffffff) 40%, color-mix(in srgb, var(--brand-accent) 18%, #ffffff) 100%);
      overflow: hidden;
    }
    .hero.hero-pro:before {
      content: ""; position: absolute; inset: 0;
      background-image:
        radial-gradient(800px 300px at -10% -10%, rgba(var(--bp-r), var(--bp-g), var(--bp-b), .15), transparent 60%),
        radial-gradient(600px 240px at 110% 0%, rgba(var(--ba-r), var(--ba-g), var(--ba-b), .14), transparent 60%),
        radial-gradient(420px 220px at 85% 85%, rgba(var(--bp-r), var(--bp-g), var(--bp-b), .10), transparent 60%),
        linear-gradient(90deg, rgba(255,255,255,.35) 1px, transparent 1px),
        linear-gradient(0deg, rgba(255,255,255,.35) 1px, transparent 1px);
      background-size: 100% 100%, 100% 100%, 100% 100%, 24px 24px, 24px 24px;
      background-position: center center; pointer-events: none;
    }
    .hero.hero-pro h1 { color: #0f172a; font-weight: 700; letter-spacing: .2px; }
    .hero.hero-pro p { color: #334155; font-size: 1.05rem; margin-bottom: 1rem; }
    .hero.hero-pro .btn-get-started { background: var(--brand-primary); color: #fff; border-radius: .5rem; padding: .65rem 1.1rem; transition: .2s ease; }
    .hero.hero-pro .btn-get-started:hover { background: color-mix(in srgb, var(--brand-primary) 80%, #000 20%); color: #fff; transform: translateY(-1px); }
    @media (min-width: 992px) { .hero.hero-pro { padding: 110px 0 80px; } }

    /* Right-side blob with brand colors - responsive and logo above */
    .hero-blob{
      width: clamp(240px, 30vw, 420px);
      aspect-ratio: 7 / 5; /* smoother oval */
      background: linear-gradient(160deg,
                  color-mix(in srgb, var(--brand-primary) 85%, #12346b 15%) 0%,
                  color-mix(in srgb, var(--brand-primary) 70%, #2a7de6 30%) 55%,
                  color-mix(in srgb, var(--brand-primary) 45%, var(--brand-accent) 55%) 100%);
      border-radius: 48% 48% 52% 52% / 58% 42% 58% 42%;
      box-shadow: 0 20px 45px rgba(0,0,0,.12), 0 6px 18px rgba(0,0,0,.08);
      position: relative;
      animation: blobFloat 6s ease-in-out infinite;
    }
    .hero-blob-logo{
      position: absolute; left: 50%; top: 50%; transform: translate(-50%, -50%);
      /* roughly 48% of blob width, responsive */
      width: clamp(110px, 48%, 200px);
      aspect-ratio: 1 / 1;
      object-fit: cover; border-radius: 50%;
      background: #fff; border: clamp(6px, 1vw, 10px) solid #fff;
      box-shadow: 0 14px 30px rgba(0,0,0,.22);
      animation: logoFloat 6s ease-in-out infinite, logoTilt 8s ease-in-out infinite;
    }
    @media (max-width: 991.98px){
      .hero-blob{ width: clamp(240px, 60vw, 420px); }
    }

    @keyframes blobFloat {
      0% { transform: translateY(0); }
      50% { transform: translateY(-6px); }
      100% { transform: translateY(0); }
    }
    @keyframes logoFloat {
      0% { transform: translate(-50%, -50%); }
      50% { transform: translate(-50%, calc(-50% - 8px)); }
      100% { transform: translate(-50%, -50%); }
    }
    @keyframes logoTilt {
      0% { transform: translate(-50%, -50%) rotate(0deg); }
      25% { transform: translate(-50%, calc(-50% - 3px)) rotate(-1.2deg); }
      50% { transform: translate(-50%, calc(-50% - 6px)) rotate(0.8deg); }
      75% { transform: translate(-50%, calc(-50% - 3px)) rotate(-1deg); }
      100% { transform: translate(-50%, -50%) rotate(0deg); }
    }
  </style>
  @endpush

  @include('components.pricing-modal', ['services' => $pricingServices ?? collect()])
  @push('scripts')
  <script>
    (function(){
      function openPricing(){
        if (new URLSearchParams(window.location.search).get('showPricing') !== '1') return;
        var el = document.getElementById('pricingModal');
        if (!el) return;
        // Prefer Bootstrap namespace
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal){
          var modal = bootstrap.Modal.getOrCreateInstance(el);
          modal.show();
        } else {
          // Fallback: trigger via data API
          el.classList.add('show');
          el.style.display = 'block';
          el.removeAttribute('aria-hidden');
          el.setAttribute('aria-modal', 'true');
        }
      }
      if (document.readyState === 'complete') openPricing();
      window.addEventListener('load', openPricing);
    })();
  </script>
  @endpush

  <section id="services" class="services section">
    @php
      $servicesHeading = (string) (config('app.services_heading') ?: 'Produk');
      $servicesDesc    = (string) (config('app.services_description') ?: 'Jelajahi Produk Kami');
    @endphp
    <x-section-heading :title="$servicesHeading" :subtitle="$servicesDesc" badge="Produk" />
    <div class="container">
      <div class="mb-3">
        <a href="{{ route('public.products') }}" class="btn btn-outline-primary btn-sm">Lihat semua produk</a>
      </div>
      <div class="row gy-4">
        @forelse($services as $service)
          <div class="col-lg-4 col-md-6 d-flex" data-aos="fade-up">
            @include('components.service-card', ['service' => $service, 'showPrice' => true])
          </div>
        @empty
          <div class="col-12 text-center text-muted">Belum ada produk.</div>
        @endforelse
      </div>
    </div>
  </section>

  <section id="contact-cta" class="section light-background">
    <div class="container">
      @php
        $ctaTitle = (string) config('app.contact_cta_title', 'Butuh Bantuan?');
        $ctaDesc  = (string) config('app.contact_cta_description', 'Hubungi kami untuk konsultasi gratis dan penawaran terbaik.');
        $waRaw    = preg_replace('/\D+/', '', (string) (config('app.company_whatsapp') ?: config('app.whatsapp_number')));
        $waLink   = null;
        if (!empty($waRaw)) {
          $msg   = urlencode('Halo, saya ingin konsultasi tentang layanan ' . (string) config('app.name'));
          $waLink = 'https://wa.me/' . $waRaw . '?text=' . $msg;
        }
      @endphp
      <div class="row align-items-center gy-3">
        <div class="col-lg-8">
          <h3 class="mb-1">{{ $ctaTitle }}</h3>
          <p class="text-muted mb-0">{{ $ctaDesc }}</p>
        </div>
        <div class="col-lg-4 text-lg-end">
          <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
            <a href="{{ route('public.contact') }}" class="btn btn-outline-primary">Hubungi Kami</a>
            @if($waLink)
              <a href="{{ $waLink }}" target="_blank" rel="noopener" class="btn btn-success"><i class="bi bi-whatsapp me-1"></i>Konsultasi via WhatsApp</a>
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>

  <section id="portfolio" class="portfolio section">
    <div class="container section-title" data-aos="fade-up">
      <h2>Portfolio</h2>
      <p><span>Proyek</span> <span class="description-title">Terbaru</span></p>
    </div>
    <div class="container">
      <div class="row gy-4">
        @forelse($projects as $project)
          <div class="col-lg-4 col-md-6 portfolio-item">
            @include('components.portfolio-card', ['project' => $project])
          </div>
        @empty
          <div class="col-12 text-center text-muted">Belum ada proyek.</div>
        @endforelse
      </div>
    </div>
  </section>

  <!-- Clients Section -->
  <section id="clients" class="clients section light-background">
    <div class="container">
      <div class="swiper clients-swiper">
        <script type="application/json" class="swiper-config">
        {
          "loop": true,
          "speed": 600,
          "autoplay": {
            "delay": 5000
          },
          "slidesPerView": "auto",
          "pagination": {
            "el": ".swiper-pagination",
            "type": "bullets",
            "clickable": true
          },
          "breakpoints": {
            "320": {
              "slidesPerView": 2,
              "spaceBetween": 40
            },
            "480": {
              "slidesPerView": 3,
              "spaceBetween": 60
            },
            "640": {
              "slidesPerView": 4,
              "spaceBetween": 80
            },
            "992": {
              "slidesPerView": 6,
              "spaceBetween": 120
            }
          }
        }
        </script>
        @php
          // Kumpulkan klien unik dari testimoni (prioritaskan pool lebih besar jika ada)
          $clientLogos = ($clientTestimonials ?? $testimonials ?? collect())
            ->filter(fn($t) => !empty($t->client_name))
            ->unique('client_name')
            ->values();
        @endphp
        <div class="swiper-wrapper align-items-center">
          @forelse($clientLogos as $t)
            <div class="swiper-slide text-center">
              <img src="{{ $t->image_url ?: asset('BizLand/assets/img/clients/client-1.png') }}" class="img-fluid rounded-circle" alt="{{ $t->client_name }}" style="width: 100px; height: 100px; object-fit: cover;">
              <div class="small text-muted mt-2">{{ $t->client_name }}</div>
            </div>
          @empty
            <div class="swiper-slide text-center">
              <img src="{{ asset('BizLand/assets/img/clients/client-1.png') }}" class="img-fluid" alt="Client">
            </div>
          @endforelse
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
  </section><!-- /Clients Section -->

  @push('scripts')
  <script>
    (function(){
      function initClientsSwiper(){
        var container = document.querySelector('#clients .clients-swiper');
        if(!container) return;
        if (typeof Swiper === 'undefined') return; // vendor not loaded yet
        // If already initialized, skip
        if (container.swiper) return;
        var cfgEl = container.querySelector('.swiper-config');
        var cfg = {};
        if (cfgEl) {
          try { cfg = JSON.parse((cfgEl.textContent || cfgEl.innerHTML || '').trim()); } catch(e) { cfg = {}; }
        }
        // Calculate slides count and clamp config to avoid loop warnings
        var wrapper = container.querySelector('.swiper-wrapper');
        var slidesCount = wrapper ? wrapper.querySelectorAll('.swiper-slide').length : 0;
        // Find max slidesPerView declared (consider breakpoints and root value)
        var maxSpv = 1;
        if (cfg.slidesPerView && cfg.slidesPerView !== 'auto') {
          maxSpv = Math.max(maxSpv, parseInt(cfg.slidesPerView, 10) || 1);
        }
        if (cfg.breakpoints) {
          Object.keys(cfg.breakpoints).forEach(function(bp){
            var bpCfg = cfg.breakpoints[bp] || {};
            if (bpCfg.slidesPerView && bpCfg.slidesPerView !== 'auto') {
              var spv = parseInt(bpCfg.slidesPerView, 10) || 1;
              maxSpv = Math.max(maxSpv, spv);
              // Clamp to slidesCount so Swiper won't warn
              bpCfg.slidesPerView = Math.min(spv, Math.max(1, slidesCount));
              cfg.breakpoints[bp] = bpCfg;
            }
          });
        }
        // If not enough slides for loop, duplicate slides lightly instead of disabling loop
        if (slidesCount > 0 && slidesCount <= maxSpv && wrapper) {
          // Target minimal count: at least maxSpv + 1 for smooth loop
          var minNeeded = Math.max(maxSpv + 1, 2);
          // Cap total slides to original * 2 to avoid DOM bloat
          var cap = Math.max(minNeeded, Math.min(slidesCount * 2, minNeeded));
          var originals = Array.from(wrapper.children);
          while (wrapper.children.length < minNeeded && wrapper.children.length < slidesCount * 2) {
            originals.forEach(function(node){
              if (wrapper.children.length < minNeeded && wrapper.children.length < slidesCount * 2) {
                wrapper.appendChild(node.cloneNode(true));
              }
            });
          }
          // Recalculate slidesCount after duplication
          slidesCount = wrapper.querySelectorAll('.swiper-slide').length;
        }
        // slidesPerGroup safety
        if (cfg.slidesPerGroup && slidesCount < cfg.slidesPerGroup) {
          cfg.slidesPerGroup = Math.max(1, slidesCount);
        }
        new Swiper(container, cfg);
      }
      if (document.readyState === 'complete' || document.readyState === 'interactive') {
        setTimeout(initClientsSwiper, 0);
      } else {
        document.addEventListener('DOMContentLoaded', initClientsSwiper);
      }
      window.addEventListener('load', initClientsSwiper);

      function initTestimonialsSwiper(){
        var container = document.querySelector('#testimonials .testimonials-swiper');
        if(!container) return;
        if (typeof Swiper === 'undefined') return;
        if (container.swiper) return;
        var cfgEl = container.querySelector('.swiper-config');
        var cfg = {};
        if (cfgEl) {
          try { cfg = JSON.parse((cfgEl.textContent || cfgEl.innerHTML || '').trim()); } catch(e) { cfg = {}; }
        }
        var wrapper = container.querySelector('.swiper-wrapper');
        var slidesCount = wrapper ? wrapper.querySelectorAll('.swiper-slide').length : 0;
        var maxSpv = 1;
        if (cfg.slidesPerView && cfg.slidesPerView !== 'auto') {
          maxSpv = Math.max(maxSpv, parseInt(cfg.slidesPerView, 10) || 1);
        }
        if (cfg.breakpoints) {
          Object.keys(cfg.breakpoints).forEach(function(bp){
            var bpCfg = cfg.breakpoints[bp] || {};
            if (bpCfg.slidesPerView && bpCfg.slidesPerView !== 'auto') {
              var spv = parseInt(bpCfg.slidesPerView, 10) || 1;
              maxSpv = Math.max(maxSpv, spv);
              bpCfg.slidesPerView = Math.min(spv, Math.max(1, slidesCount));
              cfg.breakpoints[bp] = bpCfg;
            }
          });
        }
        if (slidesCount > 0 && slidesCount <= maxSpv && wrapper) {
          var minNeeded = Math.max(maxSpv + 1, 2);
          var originals = Array.from(wrapper.children);
          while (wrapper.children.length < minNeeded && wrapper.children.length < slidesCount * 2) {
            originals.forEach(function(node){
              if (wrapper.children.length < minNeeded && wrapper.children.length < slidesCount * 2) {
                wrapper.appendChild(node.cloneNode(true));
              }
            });
          }
          slidesCount = wrapper.querySelectorAll('.swiper-slide').length;
        }
        if (cfg.slidesPerGroup && slidesCount < cfg.slidesPerGroup) {
          cfg.slidesPerGroup = Math.max(1, slidesCount);
        }
        new Swiper(container, cfg);
      }
      if (document.readyState === 'complete' || document.readyState === 'interactive') {
        setTimeout(initTestimonialsSwiper, 0);
      } else {
        document.addEventListener('DOMContentLoaded', initTestimonialsSwiper);
      }
      window.addEventListener('load', initTestimonialsSwiper);
    })();
  </script>
  @endpush

  <section id="testimonials" class="testimonials section dark-background">
    <div class="container section-title" data-aos="fade-up">
      <h2>Testimoni</h2>
      <p><span>Apa kata</span> <span class="description-title">Klien</span></p>
    </div>
    <div class="container" data-aos="fade-up" data-aos-delay="100">
      <div class="swiper testimonials-swiper">
        <script type="application/json" class="swiper-config">
          {
            "loop": true,
            "speed": 600,
            "autoplay": { "delay": 5000 },
            "slidesPerView": "auto",
            "pagination": { "el": ".swiper-pagination", "type": "bullets", "clickable": true },
            "breakpoints": {
              "320": { "slidesPerView": 1, "spaceBetween": 20 },
              "768": { "slidesPerView": 2, "spaceBetween": 24 },
              "992": { "slidesPerView": 3, "spaceBetween": 24 }
            }
          }
        </script>
        <div class="swiper-wrapper">
          @forelse($testimonials as $t)
            <div class="swiper-slide">
              <div class="p-4 bg-dark text-white h-100 rounded-3 text-center">
                @if(!empty($t->image_url))
                  <img src="{{ $t->image_url }}" alt="{{ $t->client_name ?? 'Client' }}" class="rounded-circle mb-3" style="width: 72px; height: 72px; object-fit: cover;">
                @endif
                <p class="mb-2">“{{ $t->testimonial_text ?? '' }}”</p>
                <div class="small opacity-75">— {{ $t->author_name ?? ($t->client_name ?? 'Klien') }}</div>
              </div>
            </div>
          @empty
            <div class="swiper-slide text-center text-muted">Belum ada testimoni.</div>
          @endforelse
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>
  </section>

  <section id="blog" class="section">
    <div class="container section-title" data-aos="fade-up">
      <h2>Blog</h2>
      <p><span>Tulisan</span> <span class="description-title">Terbaru</span></p>
    </div>
    <div class="container">
      <div class="row gy-4">
        @forelse($posts as $post)
          <div class="col-lg-4 col-md-6">
            @include('components.post-card', ['post' => $post])
          </div>
        @empty
          <div class="col-12 text-center text-muted">Belum ada postingan.</div>
        @endforelse
      </div>
    </div>
  </section>
@endsection
