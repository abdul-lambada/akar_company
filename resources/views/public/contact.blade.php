@extends('layouts.bizland')
@section('title','Kontak')
@section('meta_description','Hubungi kami untuk konsultasi dan informasi layanan')
@section('content')
<section id="contact" class="contact section">
  <div class="container section-title" data-aos="fade-up">
    <x-breadcrumbs :items="[[ 'label' => 'Home', 'url' => route('public.index') ], [ 'label' => 'Kontak' ]]" title="Kontak" />
    <p><span>Hubungi</span> <span class="description-title">Kami</span></p>
  </div>
  <div class="container">
    <div class="row gy-4">
      <div class="col-lg-6">
        @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form class="php-email-form" action="{{ route('public.contact.submit') }}" method="post">
          @csrf
          <div class="row gy-4">
            <div class="col-md-6">
              <input type="text" name="name" class="form-control" placeholder="Nama" value="{{ old('name') }}" required>
              @error('name')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-6">
              <input type="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required>
              @error('email')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
              <input type="text" name="subject" class="form-control" placeholder="Subjek" value="{{ old('subject') }}" required>
              @error('subject')<div class="text-danger small">{{ $message }}</div>@enderror
            </div>
            <div class="col-12">
              <textarea name="message" class="form-control" rows="6" placeholder="Pesan" required>{{ old('message') }}</textarea>
              @error('message')<div class="text-danger small">{{ $message }}</div>@enderror
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
          @php
            $contactEmail = config('app.contact_email') ?: config('mail.from.address') ?: 'akar@gmail.com';
            $contactPhone = config('app.contact_phone') ?: '085156553226';
            $officeAddress = config('app.office_address') ?: 'Jl. Cibiru No.01, Sangkanhurip, Kec. Sindang, Kabupaten Majalengka, Jawa Barat 45471';
          @endphp
          <p class="mb-1">
            <i class="bi bi-envelope"></i>
            <a href="mailto:{{ $contactEmail }}" class="text-decoration-none">{{ $contactEmail }}</a>
          </p>
          <p class="mb-1">
            <i class="bi bi-phone"></i>
            <a href="tel:{{ preg_replace('/[^\d+]/','',$contactPhone) }}" class="text-decoration-none">{{ $contactPhone }}</a>
          </p>
          <p class="mb-3"><i class="bi bi-geo-alt"></i> {{ $officeAddress }}</p>
          @php
            $mapsKey = config('services.google.maps_api_key') ?: config('app.google_maps_api_key');
            $lat = (string) (config('app.office_lat') ?? '');
            $lng = (string) (config('app.office_lng') ?? '');
            $hasCoord = ($lat !== '' && $lng !== '');
            if ($mapsKey) {
              // Prefer coordinates if available; otherwise use address string for place search
              $embedUrl = 'https://www.google.com/maps/embed/v1/place?key=' . urlencode($mapsKey) . '&q=' . ($hasCoord ? urlencode($lat . ',' . $lng) : urlencode($officeAddress));
            } else {
              // Fallback to query-based embed without API key
              $embedUrl = 'https://www.google.com/maps?q=' . rawurlencode($officeAddress) . '&output=embed';
            }
            // Link to Google Maps site/app
            $mapsLink = $hasCoord
              ? ('https://www.google.com/maps/search/?api=1&query=' . urlencode($lat . ',' . $lng))
              : ('https://www.google.com/maps/search/?api=1&query=' . urlencode($officeAddress));
          @endphp
          <div class="ratio ratio-16x9 mb-2">
            <iframe
              src="{{ $embedUrl }}"
              style="border:0;"
              allowfullscreen
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
              title="Lokasi Kantor"></iframe>
          </div>
          <a href="{{ $mapsLink }}" target="_blank" rel="noopener" class="btn btn-outline-primary btn-sm">Buka di Google Maps</a>
          
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
