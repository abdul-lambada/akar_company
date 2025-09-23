@extends('layouts.public')

@section('title', 'Tentang Kami - '.config('app.name'))

@section('content')
  <!-- Page Header -->
  <section class="banner-area relative small-banner">
    <div class="overlay overlay-bg"></div>
    <div class="container">
      <div class="row d-flex align-items-center justify-content-center">
        <div class="about-content col-lg-12">
          <h1 class="text-white">Tentang Kami</h1>
          <p class="text-white link-nav"><a href="/">Beranda </a>  <span class="lnr lnr-arrow-right"></span>  <a href="#"> Tentang Kami</a></p>
        </div>
      </div>
    </div>
  </section>
  <!-- /Page Header -->

  <!-- About Details -->
  <section class="section-full gray-bg" id="about-details">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0">
          <img class="img-fluid rounded shadow" src="{{ asset('public_template/img/about-img.jpg') }}" alt="About image" loading="lazy">
        </div>
        <div class="col-lg-6">
          <h2 class="mb-4">Kami Menciptakan Pengalaman Digital yang Menginspirasi</h2>
          <p>{{ config('app.name') }} merupakan agensi digital yang berfokus pada strategi, desain, dan teknologi untuk membantu merek bertumbuh.
          Kami percaya bahwa setiap ide hebat membutuhkan eksekusi sempurna untuk memberikan dampak maksimal.</p>
          <ul class="list mt-4">
            <li><span class="lnr lnr-checkmark-circle"></span> Tim ahli multidisiplin dengan pengalaman luas.</li>
            <li><span class="lnr lnr-checkmark-circle"></span> Pendekatan kolaboratif dan berorientasi hasil.</li>
            <li><span class="lnr lnr-checkmark-circle"></span> Teknologi mutakhir & praktik terbaik industri.</li>
          </ul>
        </div>
      </div>
    </div>
  </section>
  <!-- /About Details -->

  <!-- Mission & Vision -->
  <section class="section-full" id="mission-vision">
    <div class="container">
      <div class="row text-center mb-5">
        <div class="col-lg-8 mx-auto">
          <h2>Visi & Misi</h2>
          <p>Kami hadir untuk mendorong kesuksesan bisnis melalui solusi digital inovatif.</p>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6 mb-4">
          <div class="single-product p-4 h-100 text-center border rounded">
            <span class="lnr lnr-eye display-4 text-primary"></span>
            <h4 class="mt-3">Visi</h4>
            <p>Menjadi mitra terpercaya bagi perusahaan dalam transformasi digital di Asia Tenggara.</p>
          </div>
        </div>
        <div class="col-md-6 mb-4">
          <div class="single-product p-4 h-100 text-center border rounded">
            <span class="lnr lnr-chart-bars display-4 text-primary"></span>
            <h4 class="mt-3">Misi</h4>
            <p>Menyediakan layanan kreatif dan teknologi yang memaksimalkan nilai dan pertumbuhan klien.</p>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /Mission & Vision -->
@endsection