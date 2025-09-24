@extends('layouts.bizland')
@section('title','Kontak')
@section('content')
<section id="contact" class="contact section">
  <div class="container section-title" data-aos="fade-up">
    <h2>Kontak</h2>
    <p><span>Hubungi</span> <span class="description-title">Kami</span></p>
  </div>
  <div class="container">
    <div class="row gy-4">
      <div class="col-lg-6">
        <form class="php-email-form" onsubmit="return false">
          <div class="row gy-4">
            <div class="col-md-6">
              <input type="text" name="name" class="form-control" placeholder="Nama" required>
            </div>
            <div class="col-md-6">
              <input type="email" name="email" class="form-control" placeholder="Email" required>
            </div>
            <div class="col-12">
              <input type="text" name="subject" class="form-control" placeholder="Subjek" required>
            </div>
            <div class="col-12">
              <textarea name="message" class="form-control" rows="6" placeholder="Pesan" required></textarea>
            </div>
            <div class="col-12 text-end">
              <button type="submit" class="btn btn-primary">Kirim</button>
            </div>
          </div>
        </form>
      </div>
      <div class="col-lg-6">
        <div class="p-4 bg-light rounded-3 h-100">
          <h5>Informasi</h5>
          <p class="mb-1"><i class="bi bi-envelope"></i> contact@example.com</p>
          <p class="mb-1"><i class="bi bi-phone"></i> +1 5589 55488 55</p>
          <p class="mb-0"><i class="bi bi-geo-alt"></i> Alamat kantor Anda</p>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
