@extends('layouts.niceadmin')

@section('title', 'Add Post')

@section('content')
<div class="pagetitle">
  <h1>Add Post</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('posts.index') }}">Posts</a></li>
      <li class="breadcrumb-item active">Create</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Create Post</h5>
      <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
        @csrf
        @include('posts._form')
        <div class="mt-3">
          <a href="{{ route('posts.index') }}" class="btn btn-secondary">Cancel</a>
          <button class="btn btn-primary" type="submit">Save</button>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection