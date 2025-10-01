@extends('layouts.niceadmin')

@section('title', 'Product Detail')

@section('content')
<div class="pagetitle">
  <h1>Product Detail</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></li>
      <li class="breadcrumb-item active">Detail</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Product #{{ $service->service_id }}</h5>
      <dl class="row mb-0">
        <dt class="col-sm-3">Name</dt>
        <dd class="col-sm-9">{{ $service->service_name }}</dd>
        <dt class="col-sm-3">Slug</dt>
        <dd class="col-sm-9">{{ $service->slug }}</dd>
        <dt class="col-sm-3">Price</dt>
        <dd class="col-sm-9">Rp {{ number_format($service->price, 0, ',', '.') }}</dd>
        <dt class="col-sm-3">Projects Count</dt>
        <dd class="col-sm-9">{{ $service->portfolios_count ?? 0 }}</dd>
      </dl>
      <div class="mt-3">
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('products.edit', $service) }}" class="btn btn-primary">Edit</a>
      </div>
    </div>
  </div>
</section>
@endsection