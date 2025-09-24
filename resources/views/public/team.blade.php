@extends('layouts.bizland')
@section('title','Tim Kami')
@section('content')
<section id="team" class="team section light-background">
  <div class="container section-title" data-aos="fade-up">
    <x-breadcrumbs :items="[[ 'label' => 'Home', 'url' => route('public.index') ], [ 'label' => 'Tim' ]]" title="Tim" />
    <p><span>Kenalan</span> <span class="description-title">Dengan Tim</span></p>
  </div>
  <div class="container">
    <div class="row gy-4">
      @forelse($team as $member)
        <div class="col-md-6 col-lg-4 col-xl-3">
          <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center">
              <h5 class="card-title">{{ $member->full_name ?? $member->name }}</h5>
              <p class="text-muted small mb-0">{{ $member->email }}</p>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12 text-muted">Belum ada anggota tim.</div>
      @endforelse
    </div>
    <x-pagination :paginator="$team" />
  </div>
</section>
@endsection
