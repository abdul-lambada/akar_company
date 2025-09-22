@extends('layouts.niceadmin')

@section('title', 'Edit Post')

@section('content')
<div class="pagetitle">
  <h1>Edit Post</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Posts</a></li>
      <li class="breadcrumb-item active">Edit</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Edit Post</h5>
      <form method="POST" action="{{ route('posts.update', $post) }}">
        @csrf
        @method('PUT')
        @include('posts._form', ['post' => $post, 'selectedCategories' => $selectedCategories])
        <div class="mt-3">
          <a href="{{ route('posts.index') }}" class="btn btn-secondary">Cancel</a>
          <button class="btn btn-primary" type="submit">Update</button>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection