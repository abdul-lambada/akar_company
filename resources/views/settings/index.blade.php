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
            @if(!empty($settings['app_logo']))
              <div class="mt-2">
                <img src="{{ asset('storage/'.$settings['app_logo']) }}" alt="Logo" style="height:48px">
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
        <div class="mt-4">
          <button class="btn btn-primary" type="submit"><i class="bi bi-save"></i> Save Changes</button>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection