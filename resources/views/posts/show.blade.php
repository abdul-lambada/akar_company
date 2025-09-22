@extends('layouts.niceadmin')

@section('title', 'Post Detail')

@section('content')
<div class="pagetitle">
  <h1>Post Detail</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Posts</a></li>
      <li class="breadcrumb-item active">Detail</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Post #{{ $post->post_id }}</h5>
      <dl class="row mb-0">
        <dt class="col-sm-3">Title</dt>
        <dd class="col-sm-9">{{ $post->title }}</dd>
        <dt class="col-sm-3">Slug</dt>
        <dd class="col-sm-9">{{ $post->slug }}</dd>
        <dt class="col-sm-3">Author</dt>
        <dd class="col-sm-9">{{ $post->user->full_name ?? $post->user->username ?? '-' }}</dd>
        <dt class="col-sm-3">Categories</dt>
        <dd class="col-sm-9">
          @forelse($post->categories as $cat)
            <span class="badge bg-secondary">{{ $cat->category_name }}</span>
          @empty
            -
          @endforelse
        </dd>
        <dt class="col-sm-3">Content</dt>
        <dd class="col-sm-9">{!! nl2br(e($post->content)) !!}</dd>
      </dl>

      <hr>
      <h6>Images</h6>
      @if($post->images->isEmpty())
        <p class="text-muted">No images.</p>
      @else
        <div class="row g-2">
          @foreach($post->images as $img)
            <div class="col-6 col-md-3">
              <a href="{{ asset('storage/'.$img->image_path) }}" target="_blank">
                <img src="{{ asset('storage/'.$img->image_path) }}" class="img-fluid rounded" style="aspect-ratio:1/1;object-fit:cover;" alt="image">
              </a>
            </div>
          @endforeach
        </div>
      @endif

      <div class="mt-3">
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('posts.edit', $post) }}" class="btn btn-primary">Edit</a>
      </div>
    </div>
  </div>
</section>
@endsection