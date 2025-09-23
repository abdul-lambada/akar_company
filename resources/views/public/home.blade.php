@extends('layouts.public')

@section('title', 'Beranda - '.config('app.name'))

@section('content')
  <!-- Hero -->
  <section class="banner-area relative">
    <div class="overlay overlay-bg"></div>
    <div class="container">
      <div class="row fullscreen justify-content-center align-items-center">
        <div class="col-lg-8">
          <div class="banner-content text-center">
            <p class="text-uppercase text-white">Kami bekerja kreatif</p>
            <h1 class="text-uppercase text-white">Solusi Digital Terbaik</h1>
            <a href="#services" class="primary-btn banner-btn">Lihat Layanan</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /Hero -->

  <!-- About -->
  <section class="section-full gray-bg" id="about">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          <div class="section-title text-center">
            <p class="text-uppercase">Tentang Kami</p>
            <h3>{{ config('app.name') }} menghadirkan layanan digital dan pengembangan berfokus hasil.</h3>
          </div>
        </div>
      </div>
      <div class="row">
        @foreach([
          ['s1.jpg','Strategi Digital','Pendekatan menyeluruh mencapai tujuan'],
          ['s2.jpg','Desain UI/UX','Pengalaman pengguna intuitif'],
          ['s3.jpg','Pengembangan','Web & mobile andal']
        ] as $svc)
          <div class="col-md-4">
            <figure class="signle-service">
              <img src="{{ asset('public_template/img/'.$svc[0]) }}" class="img-fluid" alt="{{ $svc[1] }}">
              <figcaption class="text-center">
                <h5 class="text-uppercase">{{ $svc[1] }}</h5>
                <p>{{ $svc[2] }}</p>
              </figcaption>
            </figure>
          </div>
        @endforeach
      </div>
    </div>
  </section>
  <!-- /About -->

  <!-- Services highlight -->
  <section id="services" class="title-bg section-full">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="product-area-title text-center">
            <p class="text-white text-uppercase">Kenapa Kami</p>
            <h2 class="text-white h1">Kualitas & Inovasi</h2>
          </div>
        </div>
      </div>
      <div class="row">
        @php($icons=['lnr-star','lnr-magic-wand','lnr-sun','lnr-layers'])
        @foreach(['Desain Unik','UX Optimal','Visual Mengesankan','Layout Fleksibel'] as $i=>$t)
          <div class="col-lg-3 col-sm-6">
            <div class="single-product text-center">
              <span class="icon {{ $icons[$i] }} mb-3"></span>
              <h4>{{ $t }}</h4>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </section>
  <!-- /Services highlight -->

  <!-- CTA -->
  <section class="cta-area">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 d-flex justify-content-between align-items-center">
          <h5 class="text-uppercase text-white">Siap berkolaborasi?</h5>
          <a href="#contact" class="primary-btn d-inline-flex text-uppercase text-white align-items-center">Hubungi kami<span class="lnr lnr-arrow-right"></span></a>
        </div>
      </div>
    </div>
  </section>
  <!-- /CTA -->
@endsection