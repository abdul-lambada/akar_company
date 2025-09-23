@extends('layouts.public')

@section('title', 'Home')

@section('content')
    <!-- Start Banner Area -->
    <section class="banner-area relative">
        <div class="overlay overlay-bg"></div>
        <div class="container">
            <div class="row fullscreen justify-content-center align-items-center">
                <div class="col-lg-8">
                    <div class="banner-content text-center">
                        <p class="text-uppercase text-white">
                            {{ config('app.hero_description', 'We work hard, we result perfect') }}</p>
                        <h1 class="text-uppercase text-white">
                            {{ config('app.hero_heading', 'Crafting Digital Agency Experiences') }}</h1>
                        <a href="{{ route('public.services') }}" class="primary-btn banner-btn">Lihat Layanan</a>
                        <a href="{{ route('public.portfolio') }}" class="primary-btn banner-btn ml-2">Lihat Portfolio</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->
    <!-- Services (Dynamic Grid) -->
    <section class="section-gap services-area" id="services-list">
        <div class="container">
            <div class="row justify-content-center mb-4">
                <div class="col-lg-8">
                    <div class="product-area-title text-center">
                        <p class="text-uppercase">{{ config('app.services_description', 'Layanan Kami') }}</p>
                        <h2 class="h1">{{ config('app.services_heading', 'Pilihan Layanan') }}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse($services as $service)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="single-service d-flex flex-column p-4 border rounded h-100">
                            <h4 class="mb-2">{{ $service->service_name }}</h4>
                            @if (!is_null($service->price))
                                <div class="text-primary mb-2">{{ config('app.currency', 'Rp') }}
                                    {{ number_format($service->price, 0, ',', '.') }}</div>
                            @endif
                            <p class="flex-grow-1 text-muted">Hubungi kami untuk informasi lebih lanjut.</p>
                            <a href="{{ route('public.service-details', $service->slug) }}"
                                class="text-uppercase">Details</a>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center">Belum ada layanan tersedia.</p>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-2">
                <a href="{{ route('public.services') }}" class="primary-btn d-inline-flex align-items-center">Lihat Semua
                    Layanan <span class="lnr lnr-arrow-right ml-2"></span></a>
            </div>
        </div>
    </section>

    <!-- Portfolio (Latest Projects) -->
    <section class="section-gap" id="latest-projects">
        <div class="container">
            <div class="row justify-content-center mb-4">
                <div class="col-lg-8">
                    <div class="product-area-title text-center">
                        <p class="text-uppercase">Karya Terbaru</p>
                        <h2 class="h1">Portfolio Terbaru</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse($projects as $project)
                    @php
                        $thumb = optional($project->images->first())->image_path;
                    @endphp
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="signle-service border rounded overflow-hidden h-100">
                            <a href="{{ route('public.portfolio-details', $project) }}" class="d-block">
                                <img src="{{ $thumb ? asset('storage/' . $thumb) : asset('public_template/img/s1.jpg') }}"
                                    class="img-fluid w-100" alt="{{ $project->project_title }}">
                            </a>
                            <figcaption class="p-3">
                                <h5 class="text-uppercase mb-1">{{ $project->project_title }}</h5>
                                <p class="text-muted mb-2">{{ $project->services->pluck('service_name')->join(', ') }}</p>
                                <a href="{{ route('public.portfolio-details', $project) }}"
                                    class="primary-btn d-inline-flex align-items-center">Lihat Detail<span
                                        class="lnr lnr-arrow-right"></span></a>
                            </figcaption>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center">Belum ada project ditampilkan.</p>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-2">
                <a href="{{ route('public.portfolio') }}" class="primary-btn d-inline-flex align-items-center">Lihat Semua
                    Portfolio <span class="lnr lnr-arrow-right ml-2"></span></a>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="section-gap gray-bg" id="testimonials">
        <div class="container">
            <div class="row justify-content-center mb-4">
                <div class="col-lg-8">
                    <div class="product-area-title text-center">
                        <p class="text-uppercase">Apa Kata Klien</p>
                        <h2 class="h1">Testimonials</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="owl-carousel" id="testimonials-carousel">
                        @forelse($testimonials as $t)
                            <div class="single-testimonial text-center p-4">
                                @php $avatar = $t->image_path ? asset('storage/'.$t->image_path) : asset('public_template/img/t1.jpg'); @endphp
                                <img src="{{ $avatar }}" class="img-fluid rounded-circle mb-3"
                                    style="width:80px;height:80px;object-fit:cover;" alt="{{ $t->client_name }}">
                                <p class="mb-2">“{{ $t->testimonial_text }}”</p>
                                <h6 class="text-uppercase mb-0">{{ $t->client_name }}</h6>
                            </div>
                        @empty
                            <div class="text-center">
                                <p>Belum ada testimoni.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog (Latest 3 Posts) -->
    <section class="section-gap" id="latest-blog">
        <div class="container">
            <div class="row justify-content-center mb-4">
                <div class="col-lg-8">
                    <div class="product-area-title text-center">
                        <p class="text-uppercase">Artikel Terbaru</p>
                        <h2 class="h1">Blog</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse($posts as $post)
                    @php
                        $thumb = optional($post->images->first())->image_path;
                        $img = $thumb ? asset('storage/' . $thumb) : asset('public_template/img/s2.jpg');
                    @endphp
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="single-blog border rounded h-100 d-flex flex-column overflow-hidden">
                            <a href="{{ route('public.blog-detail', $post->slug) }}" class="d-block">
                                <img src="{{ $img }}" class="img-fluid w-100" alt="{{ $post->title }}">
                            </a>
                            <div class="p-3 d-flex flex-column flex-grow-1">
                                <h5 class="mb-1"><a href="{{ route('public.blog-detail', $post->slug) }}"
                                        class="text-dark">{{ $post->title }}</a></h5>
                                <p class="small text-muted mb-2">oleh {{ optional($post->user)->name ?? 'Admin' }} ·
                                    {{ $post->created_at?->format('d M Y') }}</p>
                                <p class="text-muted flex-grow-1">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 120) }}</p>
                                <div class="mt-2">
                                    <a href="{{ route('public.blog-detail', $post->slug) }}"
                                        class="primary-btn d-inline-flex align-items-center">Baca Selengkapnya <span
                                            class="lnr lnr-arrow-right ml-2"></span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center">Belum ada artikel.</p>
                    </div>
                @endforelse
            </div>
            <div class="text-center mt-2">
                <a href="{{ route('public.blog') }}" class="primary-btn d-inline-flex align-items-center">Lihat Semua
                    Artikel <span class="lnr lnr-arrow-right ml-2"></span></a>
            </div>
        </div>
    </section>

    @push('scripts')
        <script>
            jQuery(function($) {
                $('#testimonials-carousel').owlCarousel({
                    items: 3,
                    margin: 24,
                    loop: true,
                    autoplay: true,
                    autoplayTimeout: 3500,
                    smartSpeed: 600,
                    dots: true,
                    nav: false,
                    responsive: {
                        0: {
                            items: 1
                        },
                        768: {
                            items: 2
                        },
                        1024: {
                            items: 3
                        }
                    }
                });
            });
        </script>
    @endpush

    <!-- CTA and Footer handled by layout -->
@endsection
