@extends('layouts.niceadmin')

@section('title', 'Settings')

@section('content')
<div class="pagetitle">
  <h1>Settings</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Settings</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mt-3">
        <h5 class="card-title m-0">Application Settings</h5>
      </div>
      @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row g-3">
          <div class="col-md-6">
            <label for="app_name" class="form-label">App Name</label>
            <input type="text" name="app_name" id="app_name" class="form-control @error('app_name') is-invalid @enderror" value="{{ old('app_name', $settings['app_name'] ?? '') }}">
            @error('app_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6">
            <label for="mail_from_address" class="form-label">Mail From Address</label>
            <input type="email" name="mail_from_address" id="mail_from_address" class="form-control @error('mail_from_address') is-invalid @enderror" value="{{ old('mail_from_address', $settings['mail_from_address'] ?? '') }}">
            @error('mail_from_address')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6">
            <label for="app_url" class="form-label">App URL</label>
            <input type="url" name="app_url" id="app_url" class="form-control @error('app_url') is-invalid @enderror" value="{{ old('app_url', $settings['app_url'] ?? '') }}">
            @error('app_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-3">
            <label for="app_locale" class="form-label">Locale</label>
            <input type="text" name="app_locale" id="app_locale" class="form-control @error('app_locale') is-invalid @enderror" value="{{ old('app_locale', $settings['app_locale'] ?? 'en') }}">
            @error('app_locale')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-3">
            <label for="app_timezone" class="form-label">Timezone</label>
            <input type="text" name="app_timezone" id="app_timezone" class="form-control @error('app_timezone') is-invalid @enderror" value="{{ old('app_timezone', $settings['app_timezone'] ?? 'UTC') }}">
            @error('app_timezone')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6">
            <label for="app_logo" class="form-label">App Logo</label>
            <input type="file" name="app_logo" id="app_logo" class="form-control @error('app_logo') is-invalid @enderror" accept="image/*">
            @error('app_logo')<div class="invalid-feedback">{{ $message }}</div>@enderror
            @php($appLogo = $settings['app_logo'] ?? null)
            @php($hasLogo = !empty($appLogo) && \Illuminate\Support\Facades\Storage::disk('public')->exists($appLogo))
            @if($hasLogo)
              <div class="mt-2">
                <img src="{{ asset('storage/'.$appLogo) }}" alt="Logo" style="height:48px">
              </div>
            @endif
          </div>
          <div class="col-md-3">
            <label for="app_currency" class="form-label">Default Currency</label>
            <input type="text" name="app_currency" id="app_currency" class="form-control @error('app_currency') is-invalid @enderror" value="{{ old('app_currency', $settings['app_currency'] ?? 'USD') }}">
            @error('app_currency')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-3">
            <label for="app_date_format" class="form-label">Date Format</label>
            <input type="text" name="app_date_format" id="app_date_format" class="form-control @error('app_date_format') is-invalid @enderror" value="{{ old('app_date_format', $settings['app_date_format'] ?? 'Y-m-d') }}">
            @error('app_date_format')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>
        <hr class="my-4">
        <div class="d-flex justify-content-between align-items-center">
          <h5 class="card-title m-0">Public Website</h5>
        </div>
        <div class="row g-3">
          <div class="col-md-6">
            <label for="company_whatsapp" class="form-label">Company WhatsApp</label>
            <input type="text" name="company_whatsapp" id="company_whatsapp" class="form-control @error('company_whatsapp') is-invalid @enderror" value="{{ old('company_whatsapp', $settings['company_whatsapp'] ?? '') }}" placeholder="+62...">
            @error('company_whatsapp')<div class="invalid-feedback">{{ $message }}</div>@enderror
            <small class="text-muted">Masukkan nomor WhatsApp. Format apapun akan dibersihkan otomatis saat disimpan.</small>
          </div>
          <div class="col-md-6">
            <label for="hero_heading" class="form-label">Hero Heading</label>
            <input type="text" name="hero_heading" id="hero_heading" class="form-control @error('hero_heading') is-invalid @enderror" value="{{ old('hero_heading', $settings['hero_heading'] ?? '') }}">
            @error('hero_heading')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-12">
            <label for="hero_description" class="form-label">Hero Description</label>
            <textarea name="hero_description" id="hero_description" rows="2" class="form-control @error('hero_description') is-invalid @enderror">{{ old('hero_description', $settings['hero_description'] ?? '') }}</textarea>
            @error('hero_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6">
            <label for="services_heading" class="form-label">Services Heading</label>
            <input type="text" name="services_heading" id="services_heading" class="form-control @error('services_heading') is-invalid @enderror" value="{{ old('services_heading', $settings['services_heading'] ?? '') }}">
            @error('services_heading')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6">
            <label for="services_description" class="form-label">Services Description</label>
            <input type="text" name="services_description" id="services_description" class="form-control @error('services_description') is-invalid @enderror" value="{{ old('services_description', $settings['services_description'] ?? '') }}">
            @error('services_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6">
            <label for="portfolio_heading" class="form-label">Portfolio Heading</label>
            <input type="text" name="portfolio_heading" id="portfolio_heading" class="form-control @error('portfolio_heading') is-invalid @enderror" value="{{ old('portfolio_heading', $settings['portfolio_heading'] ?? '') }}">
            @error('portfolio_heading')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6">
            <label for="portfolio_description" class="form-label">Portfolio Description</label>
            <input type="text" name="portfolio_description" id="portfolio_description" class="form-control @error('portfolio_description') is-invalid @enderror" value="{{ old('portfolio_description', $settings['portfolio_description'] ?? '') }}">
            @error('portfolio_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6">
            <label for="testimonials_heading" class="form-label">Testimonials Heading</label>
            <input type="text" name="testimonials_heading" id="testimonials_heading" class="form-control @error('testimonials_heading') is-invalid @enderror" value="{{ old('testimonials_heading', $settings['testimonials_heading'] ?? '') }}">
            @error('testimonials_heading')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6">
            <label for="testimonials_description" class="form-label">Testimonials Description</label>
            <input type="text" name="testimonials_description" id="testimonials_description" class="form-control @error('testimonials_description') is-invalid @enderror" value="{{ old('testimonials_description', $settings['testimonials_description'] ?? '') }}">
            @error('testimonials_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6">
            <label for="contact_cta_title" class="form-label">Contact CTA Title</label>
            <input type="text" name="contact_cta_title" id="contact_cta_title" class="form-control @error('contact_cta_title') is-invalid @enderror" value="{{ old('contact_cta_title', $settings['contact_cta_title'] ?? '') }}">
            @error('contact_cta_title')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
          <div class="col-md-6">
            <label for="contact_cta_description" class="form-label">Contact CTA Description</label>
            <textarea name="contact_cta_description" id="contact_cta_description" rows="2" class="form-control @error('contact_cta_description') is-invalid @enderror">{{ old('contact_cta_description', $settings['contact_cta_description'] ?? '') }}</textarea>
            @error('contact_cta_description')<div class="invalid-feedback">{{ $message }}</div>@enderror
          </div>
        </div>
        <div class="mt-4">
          <button class="btn btn-primary" type="submit"><i class="bi bi-save"></i> Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection