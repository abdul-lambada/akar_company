@extends('layouts.auth')

@section('title', 'Masuk')

@section('content')
    <main>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                            <div class="d-flex justify-content-center py-4">
                                <a href="{{ url('/') }}" class="logo d-flex align-items-center w-auto">
                                    <img src="{{ config('app.logo') ? asset('storage/'.config('app.logo')) : asset('NiceAdmin/assets/img/logo.png') }}" alt="Logo">
                                    <span class="d-none d-lg-block">{{ config('app.name', 'Akar Company') }}</span>
                                </a>
                            </div>

                            <div class="card mb-3 w-100">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <h5 class="card-title text-center pb-0 fs-4">Masuk ke Akun Anda</h5>
                                        @if ($errors->has('login') && !old('password'))
                                          <div class="alert alert-danger small py-2 mt-2" role="alert">
                                            {{ $errors->first('login') }}
                                          </div>
                                        @endif
                                    </div>

                                    <form class="row g-3 needs-validation" method="POST" action="{{ route('login.post') }}" novalidate>
                                        @csrf

                                        <div class="col-12">
                                            <label for="login" class="form-label">Email atau Username</label>
                                            <div class="input-group has-validation">
                                                <input type="text" name="login" id="login"
                                                    class="form-control @error('login') is-invalid @enderror"
                                                    value="{{ old('login') }}" required autofocus placeholder="nama@domain.com atau username">
                                                @error('login')
                                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="password" class="form-label">Kata Sandi</label>
                                            <input type="password" name="password" id="password"
                                                class="form-control @error('password') is-invalid @enderror" required placeholder="••••••••">
                                            @error('password')
                                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                <label class="form-check-label" for="remember">Ingat saya</label>
                                            </div>
                                        </div>

                                        @php $recaptchaSiteKey = config('services.recaptcha.site_key'); @endphp
                                        @if(!empty($recaptchaSiteKey))
                                        <div class="col-12">
                                          <label class="form-label">Verifikasi Keamanan</label>
                                          <div class="g-recaptcha" data-sitekey="{{ $recaptchaSiteKey }}"></div>
                                          @if($errors->has('recaptcha'))
                                            <div class="invalid-feedback d-block">{{ $errors->first('recaptcha') }}</div>
                                          @endif
                                        </div>
                                        @endif

                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Masuk</button>
                                        </div>

                                    </form>
                                </div>
                            </div>

                            <div class="credits text-center">
                                Dikembangkan oleh Akar Sekawan
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
@endsection
@push('scripts')
@php $recaptchaSiteKey = config('services.recaptcha.site_key'); @endphp
@if(!empty($recaptchaSiteKey))
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endif
@endpush
