@extends('layouts.niceadmin')

@section('title', 'Edit Category')

@section('content')
<div class="pagetitle">
  <h1>Edit Category</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categories</a></li>
      <li class="breadcrumb-item active">Edit</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Edit Category</h5>
      <form method="POST" action="{{ route('categories.update', $category) }}">
        @csrf
        @method('PUT')
        @include('categories._form', ['category' => $category])
        <div class="mt-3">
          <a href="{{ route('categories.index') }}" class="btn btn-secondary">Cancel</a>
          <button class="btn btn-primary" type="submit">Update</button>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection