@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<main>
  <div class="container">
    <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

            <div class="d-flex justify-content-center py-4">
              <a href="{{ url('/') }}" class="logo d-flex align-items-center w-auto">
                <img src="{{ asset('NiceAdmin/assets/img/logo.png') }}" alt="">
                <span class="d-none d-lg-block">{{ config('app.name', 'Akar Company') }}</span>
              </a>
            </div>

            <div class="card mb-3 w-100">
              <div class="card-body">
                <div class="pt-4 pb-2">
                  <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                  <p class="text-center small">Enter your email/username & password to login</p>
                </div>

                <form class="row g-3 needs-validation" method="POST" action="{{ route('login.post') }}" novalidate>
                  @csrf

                  <div class="col-12">
                    <label for="login" class="form-label">Email or Username</label>
                    <div class="input-group has-validation">
                      <input type="text" name="login" class="form-control @error('login') is-invalid @enderror" id="login" value="{{ old('login') }}" required autofocus>
                      @error('login')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>

                  <div class="col-12">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" required>
                    @error('password')
                      <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                  </div>

                  <div class="col-12">
                    <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                      <label class="form-check-label" for="remember">Remember me</label>
                    </div>
                  </div>

                  <div class="col-12">
                    <button class="btn btn-primary w-100" type="submit">Login</button>
                  </div>

                </form>
              </div>
            </div>

            <div class="credits text-center">
              Designed by Akar Sekawan
            </div>

          </div>
        </div>
      </div>
    </section>
  </div>
</main>
@endsection