@extends('layouts.niceadmin')

@section('title', 'Category Detail')

@section('content')
<div class="pagetitle">
  <h1>Category Detail</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categories</a></li>
      <li class="breadcrumb-item active">Detail</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Category #{{ $category->category_id }}</h5>
      <dl class="row mb-0">
        <dt class="col-sm-3">Name</dt>
        <dd class="col-sm-9">{{ $category->category_name }}</dd>
        <dt class="col-sm-3">Slug</dt>
        <dd class="col-sm-9">{{ $category->slug }}</dd>
        <dt class="col-sm-3">Posts Count</dt>
        <dd class="col-sm-9">{{ $category->posts_count ?? 0 }}</dd>
      </dl>
      <div class="mt-3">
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('categories.edit', $category) }}" class="btn btn-primary">Edit</a>
      </div>
    </div>
  </div>
</section>
@endsection