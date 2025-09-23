@extends('layouts.public')

@section('title', 'Team')

@section('content')
<section class="section-gap" id="team">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="product-area-title text-center">
          <p class="text-uppercase">{{ config('app.team_description', 'Meet our professionals') }}</p>
          <h2 class="h1">{{ config('app.team_heading', 'Our Team') }}</h2>
        </div>
      </div>
    </div>
    <div class="row">
      @forelse($team as $member)
        <div class="col-6 col-md-4 col-lg-3">
          <div class="p-3 border rounded text-center h-100">
            <img src="{{ $member->avatar ? asset('storage/'.$member->avatar) : asset('NiceAdmin/assets/img/profile-img.jpg') }}" alt="{{ $member->full_name }}" class="img-fluid rounded-circle mb-2" style="width:96px;height:96px;object-fit:cover;">
            <div class="fw-bold">{{ $member->full_name }}</div>
            <div class="text-muted small">{{ $member->email }}</div>
          </div>
        </div>
      @empty
        <div class="col-12"><p class="text-center">No team member found.</p></div>
      @endforelse
    </div>
    <div class="d-flex justify-content-center mt-3">
      {{ $team->links() }}
    </div>
  </div>
</section>
@endsection