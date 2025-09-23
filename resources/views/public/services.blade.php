@extends('layouts.public')

@section('title', 'Our Services')

@section('content')
    <!-- Page Header -->
    <section class="page-header d-flex align-items-center" style="background:url('{{ asset('public_template/img/header-bg.jpg') }}') center/cover no-repeat; min-height:300px">
        <div class="container text-center">
            <h1 class="display-4 fw-bold text-white">Our Services</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Services</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Services List -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-5 justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="fw-bold">What We Offer</h2>
                    <p class="text-muted">Browse our range of professional services designed to help your business grow and succeed.</p>
                </div>
            </div>
            <div class="row g-4">
                @forelse($services as $service)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0 service-card">
                            <img src="{{ $service->image_path ? asset('storage/'.$service->image_path) : asset('public_template/img/service-placeholder.jpg') }}" class="card-img-top" alt="{{ $service->name }} image">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-semibold">{{ $service->name }}</h5>
                                <p class="card-text flex-grow-1">{{ Str::limit($service->description, 100) }}</p>
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <span class="fw-bold text-primary">{{ $service->formatted_price ?? 'Contact Us' }}</span>
                                    <a href="{{ route('services.show', $service->slug) }}" class="btn btn-sm btn-outline-primary">Learn More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">No services found. Please check back later.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-5 bg-primary text-white text-center">
        <div class="container">
            <h3 class="fw-bold mb-3">Ready to elevate your business?</h3>
            <p class="mb-4">Contact our expert team today to discover how we can help you achieve your goals.</p>
            <a href="{{ url('/contact') }}" class="btn btn-light btn-lg">Get in Touch</a>
        </div>
    </section>
@endsection

@push('styles')
<style>
    .service-card img {object-fit: cover; height: 200px;}
</style>
@endpush