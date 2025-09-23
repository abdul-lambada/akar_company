@extends('layouts.public')

@section('title', 'Blog')

@section('content')
    <!-- Page Header -->
    <section class="page-header d-flex align-items-center" style="background:url('{{ asset('public_template/img/header-bg.jpg') }}') center/cover no-repeat; min-height:300px">
        <div class="container text-center">
            <h1 class="display-4 fw-bold text-white">Blog & Insights</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb justify-content-center mb-0">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}" class="text-white-50">Home</a></li>
                    <li class="breadcrumb-item active text-white" aria-current="page">Blog</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Blog Posts -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-5 justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="fw-bold">Latest Articles</h2>
                    <p class="text-muted">Stay updated with our latest news, tips, and insights.</p>
                </div>
            </div>
            <div class="row g-4">
                @forelse($posts as $post)
                    <div class="col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm border-0 blog-card">
                            <div class="ratio ratio-4x3">
                                <img src="{{ $post->cover_image ? asset('storage/'.$post->cover_image) : asset('public_template/img/blog-placeholder.jpg') }}" class="img-fluid object-fit-cover" alt="{{ $post->title }} cover">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <span class="badge bg-primary mb-2">{{ $post->category->name ?? 'General' }}</span>
                                <h5 class="card-title fw-semibold">{{ $post->title }}</h5>
                                <p class="card-text text-muted small mb-2">{{ $post->published_at->format('M d, Y') }}</p>
                                <p class="card-text flex-grow-1">{{ Str::limit($post->excerpt, 100) }}</p>
                                <a href="{{ route('blog.show', $post->slug) }}" class="mt-3 text-decoration-none fw-semibold">Read More &rarr;</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center">
                        <p class="text-muted">No posts found.</p>
                    </div>
                @endforelse
            </div>

            @if($posts instanceof \Illuminate\Pagination\LengthAwarePaginator)
                <div class="d-flex justify-content-center mt-5">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection

@push('styles')
<style>
    .blog-card img {transition: transform .3s ease;}
    .blog-card:hover img {transform: scale(1.05);}    
</style>
@endpush