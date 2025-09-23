@extends('layouts.public')

@section('title', 'Our Portfolio')

@section('content')
    <!-- Page Header -->
    <section class="page-header d-flex align-items-center" style="background:url('{{ asset('public_template/img/header-bg.jpg') }}') center/cover no-repeat; min-height:300px">
        <div class="container text-center">
            <h1 class="display-4 fw-bold text-white">Portfolio</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Portfolio</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Portfolio Grid -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-lg-8 text-center mx-auto">
                    <h2 class="fw-bold">Recent Projects</h2>
                    <p class="text-muted">Take a look at some of our most impactful work across various industries.</p>
                </div>
            </div>

            <div class="row g-4" id="portfolio-grid">
                @forelse($portfolios as $project)
                    <div class="col-sm-6 col-lg-4 portfolio-item" data-category="{{ $project->category->slug ?? 'general' }}">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="ratio ratio-4x3">
                                <img src="{{ $project->cover_image ? asset('storage/'.$project->cover_image) : asset('public_template/img/portfolio-placeholder.jpg') }}" class="img-fluid object-fit-cover" alt="{{ $project->title }} cover">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title fw-semibold">{{ $project->title }}</h5>
                                <p class="card-text small text-muted mb-2">{{ $project->category->name ?? '' }}</p>
                                <p class="card-text">{{ Str::limit($project->excerpt, 90) }}</p>
                                <a href="{{ route('portfolio.show', $project->slug) }}" class="stretched-link"></a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">No portfolio items found at the moment.</p>
                    </div>
                @endforelse
            </div>

            @if($portfolios instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="d-flex justify-content-center mt-4">
                    {{ $portfolios->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection

@push('styles')
<style>
    #portfolio-grid .portfolio-item img {transition: transform .3s ease;}
    #portfolio-grid .portfolio-item:hover img {transform: scale(1.05);}    
</style>
@endpush