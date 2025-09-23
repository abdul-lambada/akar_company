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
                        <p class="text-uppercase text-white">{{ config('app.hero_description', 'We work hard, we result perfect') }}</p>
                        <h1 class="text-uppercase text-white">{{ config('app.hero_heading', 'Crafting Digital Agency Experiences') }}</h1>
                        <a href="{{ route('public.services') }}" class="primary-btn banner-btn">Explore Us</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner Area -->

    <!-- Start About Area -->
    <section class="section-full gray-bg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="section-title text-center">
                        <p class="text-uppercase">About Our Digital Agency</p>
                        <h3>Plantronics with its GN Netcom <b>wireless headset</b> creates the next generation of wireless headset and other products such as wireless amplifiers, and <b>wireless headset</b> telephone.</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <figure class="signle-service">
                        <img src="{{ asset('public_template/img/s1.jpg') }}" class="img-fluid" alt="">
                        <figcaption class="text-center">
                            <h5 class="text-uppercase">Addiction Whit Gambling</h5>
                            <p>It is a good idea to think of your PC as an office. It stores files, programs, pictures. This can be compared to an actual office’s files</p>
                            <a href="{{ route('public.services') }}" class="primary-btn d-inline-flex align-items-center">Explore<span class="lnr lnr-arrow-right"></span></a>
                        </figcaption>
                    </figure>
                </div>
                <div class="col-md-4">
                    <figure class="signle-service">
                        <img src="{{ asset('public_template/img/s2.jpg') }}" class="img-fluid" alt="">
                        <figcaption class="text-center">
                            <h5 class="text-uppercase">Headset No Longer Wired</h5>
                            <p>If you are in the market for a computer, there are a number of factors to consider. Will it be used for your home, your office or perhaps </p>
                            <a href="{{ route('public.services') }}" class="primary-btn d-inline-flex align-items-center">Explore<span class="lnr lnr-arrow-right"></span></a>
                        </figcaption>
                    </figure>
                </div>
                <div class="col-md-4">
                    <figure class="signle-service">
                        <img src="{{ asset('public_template/img/s3.jpg') }}" class="img-fluid" alt="">
                        <figcaption class="text-center">
                            <h5 class="text-uppercase">Life Advice Looking At Window</h5>
                            <p>Having a baby can be a nerve wrackingexp erience for new parents – not the nine months of pregnancy, I’m talking</p>
                            <a href="{{ route('public.services') }}" class="primary-btn d-inline-flex align-items-center">Explore<span class="lnr lnr-arrow-right"></span></a>
                        </figcaption>
                    </figure>
                </div>
            </div>
        </div>
    </section>
    <!-- End About Area -->

    <!-- Services (Why Choose Us) -->
    <section id="services" class="title-bg section-full">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="product-area-title text-center">
                        <p class="text-white text-uppercase">{{ config('app.services_description', 'Why Choose Us') }}</p>
                        <h2 class="text-white h1">{{ config('app.services_heading', 'We ensure perfect quality Digital products for you') }}</h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="single-product">
                        <div class="icon">
                            <span class="lnr lnr-star"></span>
                        </div>
                        <div class="desc">
                            <h4>Unique Design</h4>
                            <p>Most people who work in an office environment, buy computer products, or have </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-product">
                        <div class="icon">
                            <span class="lnr lnr-magic-wand"></span>
                        </div>
                        <div class="desc">
                            <h4>Appropriate UX</h4>
                            <p>Today, many people rely on computers to do homework, work, and create or store useful</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-product">
                        <div class="icon">
                            <span class="lnr lnr-sun"></span>
                        </div>
                        <div class="desc">
                            <h4>Perfect Visual</h4>
                            <p>Having a baby can be a nerve wracking experience for new parents – not the nine months </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="single-product">
                        <div class="icon">
                            <span class="lnr lnr-layers"></span>
                        </div>
                        <div class="desc">
                            <h4>Different Layout</h4>
                            <p>It won’t be a bigger problem to find one video game lover in your neighbor. Since the </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA and Footer handled by layout -->
@endsection