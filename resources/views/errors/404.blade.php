@extends('layouts.public')

@section('title', '404 - Page Not Found')
@section('meta_description', 'Halaman tidak ditemukan di '.config('app.name'))

@section('content')
<section class="section-gap text-center">
  <div class="container">
    <h1 class="display-4 mb-3">404</h1>
    <p class="mb-4">Maaf, halaman yang Anda cari tidak ditemukan.</p>
    <a href="{{ url('/') }}" class="primary-btn d-inline-flex align-items-center"><span class="lnr lnr-home mr-2"></span> Kembali ke Beranda</a>
  </div>
</section>
@endsection