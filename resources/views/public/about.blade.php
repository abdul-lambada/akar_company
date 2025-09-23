@extends('layouts.public')

@section('title', 'About')

@section('content')
<section class="about-area section-gap" id="about">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <img class="img-fluid" src="{{ asset('public_template/img/about.jpg') }}" alt="About">
      </div>
      <div class="col-lg-6">
        <h3>{{ config('app.about_heading', 'About Us') }}</h3>
        <p>{{ config('app.about_description', 'Kami adalah tim profesional yang berfokus pada solusi digital end-to-end.') }}</p>
        <div class="row mt-4">
          <div class="col-4 text-center">
            <h2>{{ $counters['years'] }}</h2>
            <p>Years</p>
          </div>
          <div class="col-4 text-center">
            <h2>{{ $counters['projects'] }}</h2>
            <p>Projects</p>
          </div>
          <div class="col-4 text-center">
            <h2>{{ $counters['clients'] }}</h2>
            <p>Clients</p>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <h4 class="mb-2">{{ config('app.clients_heading', 'Our Clients') }}</h4>
      </div>
      @forelse($clients as $client)
        <div class="col-6 col-md-3">
          <div class="p-3 border rounded h-100 d-flex align-items-center justify-content-center text-center">
            <div>
              <div class="fw-bold">{{ $client->client_name }}</div>
              @if($client->email)<div class="text-muted small">{{ $client->email }}</div>@endif
            </div>
          </div>
        </div>
      @empty
        <div class="col-12"><p class="text-muted">Belum ada data klien.</p></div>
      @endforelse
    </div>

    <div class="row" id="team">
      <div class="col-12">
        <h4 class="mb-2">{{ config('app.team_heading', 'Team') }}</h4>
      </div>
      @forelse($team as $member)
        <div class="col-6 col-md-4 col-lg-3">
          <div class="p-3 border rounded h-100 text-center">
            <img src="{{ $member->avatar ? asset('storage/'.$member->avatar) : asset('NiceAdmin/assets/img/profile-img.jpg') }}" alt="{{ $member->name }}" class="img-fluid rounded-circle mb-2" style="width:96px;height:96px;object-fit:cover;">
            <div class="fw-bold">{{ $member->name }}</div>
            <div class="text-muted small">{{ $member->email }}</div>
          </div>
        </div>
      @empty
        <div class="col-12"><p class="text-muted">Belum ada anggota tim.</p></div>
      @endforelse
    </div>
  </div>
</section>
@endsection