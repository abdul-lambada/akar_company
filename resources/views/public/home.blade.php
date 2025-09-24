@extends('public.layouts.app')

@section('title','Home')

@section('content')
    {{-- Hero / Slider section  --}}
    <div class="slider-apecsa">
        <div class="tp-banner-container">
            <div class="tp-banner">
                <ul>
                    <li data-transition="slotzoom-horizontal" data-slotamount="1" data-masterspeed="1000" data-thumb="{{ asset('template_fe/assets/images/slider/slider_4.jpg') }}" data-saveperformance="off" data-title="We are Awesome">
                        <img src="{{ asset('template_fe/assets/images/slider/slider_4.jpg') }}" alt="" data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">
                    </li>
                    <li data-transition="curtain-3" data-slotamount="1" data-masterspeed="1300" data-thumb="{{ asset('template_fe/assets/images/slider/slider_1.jpg') }}" data-saveperformance="off" data-title="With Awesome Services">
                        <img src="{{ asset('template_fe/assets/images/slider/slider_1.jpg') }}" alt="" data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">
                    </li>
                    <li data-transition="slideright" data-slotamount="1" data-masterspeed="1300" data-thumb="{{ asset('template_fe/assets/images/slider/slider_4.jpg') }}" data-saveperformance="off" data-title="Creative & Professional">
                        <img src="{{ asset('template_fe/assets/images/slider/slider_4.jpg') }}" alt="" data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat">
                    </li>
                </ul>
                <div class="tp-bannertimer"></div>
            </div>
        </div>
    </div>

    {{-- Services Section --}}
    <section class="container section-services">
        <div class="row text-center">
            <h2>Layanan Kami</h2>
            <hr>
        </div>
        <div class="row">
            @foreach($services as $service)
                <div class="col-sm-4 col-md-4 text-center">
                    <div class="service-box">
                        <i class="fa fa-3x {{ $service->icon ?? 'fa-code' }} text-primary"></i>
                        <h4 class="my-3">{{ $service->service_name }}</h4>
                        <p>{{ Str::limit($service->description, 120) }}</p>
                        <a href="{{ route('public.service-details', $service->slug) }}" class="btn btn-link">Selengkapnya</a>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    {{-- Portfolio Section --}}
    <section class="section-portfolio diagonal-shadow">
        <div class="container">
            <div class="row text-center">
                <h2>Proyek Terbaru</h2>
                <hr>
            </div>
            <div class="row">
                @foreach($projects as $project)
                    <div class="col-sm-4">
                        <div class="portfolio-item">
                            <a href="{{ route('public.portfolio-details', $project) }}">
                                <img class="img-responsive" src="{{ $project->images->first()->image_path ?? '' }}" alt="{{ $project->project_title }}">
                            </a>
                            <h4 class="text-center mt-2">{{ $project->project_title }}</h4>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row text-center mt-4">
                <a href="{{ route('public.portfolio') }}" class="btn btn-primary">Lihat Semua Portfolio</a>
            </div>
        </div>
    </section>

    {{-- Testimonials Section --}}
    <section class="section-testimonials">
        <div class="container">
            <div class="row text-center">
                <h2>Testimonial</h2>
                <hr>
            </div>
            <div class="row owl-carousel" id="testimonial-carousel">
                @foreach($testimonials as $testi)
                    <div class="item text-center">
                        <blockquote class="blockquote">
                            <p>{{ $testi->content }}</p>
                            <footer class="blockquote-footer">{{ $testi->name }}</footer>
                        </blockquote>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Blog Section --}}
    <section class="section-blog bg-light">
        <div class="container">
            <div class="row text-center">
                <h2>Artikel Terbaru</h2>
                <hr>
            </div>
            <div class="row">
                @foreach($posts as $post)
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <img class="card-img-top" src="{{ $post->images->first()->image_path ?? '' }}" alt="{{ $post->title }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $post->title }}</h5>
                                <p class="card-text">{{ Str::limit(strip_tags($post->content), 120) }}</p>
                                <a href="{{ route('public.blog-detail', $post->slug) }}" class="btn btn-sm btn-outline-primary">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    (function ($) {
        "use strict";
        // Ensure slider initialized after DOM ready
        $(document).ready(function(){
            if($('.slider-apecsa .tp-banner').length){
                jQuery('.slider-apecsa .tp-banner').show().revolution({
                    delay:10000,
                    startwidth:1200,
                    startheight:620,
                    hideThumbs:600,
                    thumbWidth:80,
                    thumbHeight:50,
                    thumbAmount:5,
                    navigationType:"bullet",
                    navigationArrows:"0",
                    navigationStyle:"preview4",
                    touchenabled:"on",
                    onHoverStop:"off",
                    swipe_velocity: 0.7,
                    swipe_min_touches: 1,
                    swipe_max_touches: 1,
                    drag_block_vertical: false,
                    parallax:"mouse",
                    parallaxBgFreeze:"on",
                    parallaxLevels:[7,4,3,2,5,4,3,2,1,0],
                    keyboardNavigation:"off",
                    navigationHAlign:"center",
                    navigationVAlign:"bottom",
                    navigationHOffset:0,
                    navigationVOffset:20,
                    soloArrowLeftHalign:"left",
                    soloArrowLeftValign:"center",
                    soloArrowLeftHOffset:20,
                    soloArrowLeftVOffset:0,
                    soloArrowRightHalign:"right",
                    soloArrowRightValign:"center",
                    soloArrowRightHOffset:20,
                    soloArrowRightVOffset:0,
                    shadow:0,
                    fullWidth:"on",
                    fullScreen:"off",
                    spinner:"spinner4",
                    stopLoop:"off",
                    stopAfterLoops:-1,
                    stopAtSlide:-1,
                    shuffle:"off",
                    autoHeight:"off",
                    forceFullWidth:"on",
                    hideThumbsOnMobile:"on",
                    hideNavDelayOnMobile:1500,
                    hideBulletsOnMobile:"on",
                    hideArrowsOnMobile:"on",
                    hideThumbsUnderResolution:0,
                    hideSliderAtLimit:0,
                    hideCaptionAtLimit:0,
                    hideAllCaptionAtLilmit:0,
                    startWithSlide:0,
                    fullScreenOffsetContainer: ".slider-apecsa"
                });
            }
        });
    })(window.jQuery);
</script>
@endpush