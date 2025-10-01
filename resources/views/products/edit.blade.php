@extends('layouts.niceadmin')

@section('title', 'Edit Product')

@section('content')
<div class="pagetitle">
  <h1>Edit Product</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
      <li class="breadcrumb-item active">Edit</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Edit Product</h5>
      <form method="POST" action="{{ route('products.update', $service) }}">
        @csrf
        @method('PUT')
        @include('products._form', ['service' => $service])
        <div class="mt-3">
          <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
          <button class="btn btn-primary" type="submit">Update</button>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection