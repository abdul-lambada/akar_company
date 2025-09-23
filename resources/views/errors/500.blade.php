@extends('layouts.public')

@section('title', '500 - Server Error')
@section('meta_description', 'Terjadi kesalahan di sisi server pada '.config('app.name'))

@section('content')
<section class="section-gap text-center">
  <div class="container">
    <h1 class="display-4 mb-3">500</h1>
    <p class="mb-4">Ups! Terjadi kesalahan internal pada server kami.<br>Silakan coba beberapa saat lagi.</p>
    <a href="{{ url('/') }}" class="primary-btn d-inline-flex align-items-center"><span class="lnr lnr-home mr-2"></span> Kembali ke Beranda</a>
  </div>
</section>
@endsection