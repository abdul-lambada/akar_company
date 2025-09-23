@extends('layouts.public')

@section('title', 'Meet the Team')

@section('content')
    <!-- Page Header -->
    <section class="page-header d-flex align-items-center" style="background:url('{{ asset('public_template/img/header-bg.jpg') }}') center/cover no-repeat; min-height:300px">
        <div class="container text-center">
            <h1 class="display-4 fw-bold text-white">Our Team</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Team</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Team Members -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-5 justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="fw-bold">Professional &amp; Dedicated</h2>
                    <p class="text-muted">Get to know the people behind Akar Company who drive innovation and excellence every day.</p>
                </div>
            </div>
            <div class="row g-4 justify-content-center">
                @forelse($teamMembers as $member)
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="card border-0 shadow-sm team-card text-center h-100">
                            <div class="ratio ratio-1x1">
                                <img src="{{ $member->avatar ? asset('storage/'.$member->avatar) : asset('public_template/img/team-placeholder.jpg') }}" class="rounded-circle object-fit-cover" alt="{{ $member->name }} photo">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title mb-1 fw-semibold">{{ $member->name }}</h5>
                                <p class="card-text text-primary small mb-2">{{ $member->position }}</p>
                                <p class="card-text small text-muted">{{ Str::limit($member->bio, 80) }}</p>
                                <div>
                                    @if($member->linkedin)
                                        <a href="{{ $member->linkedin }}" class="text-primary me-2"><i class="bi bi-linkedin"></i></a>
                                    @endif
                                    @if($member->twitter)
                                        <a href="{{ $member->twitter }}" class="text-primary me-2"><i class="bi bi-twitter"></i></a>
                                    @endif
                                    @if($member->facebook)
                                        <a href="{{ $member->facebook }}" class="text-primary"><i class="bi bi-facebook"></i></a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">No team members found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    .team-card img {transition: transform .3s ease;}
    .team-card:hover img {transform: scale(1.08);}    
</style>
@endpush