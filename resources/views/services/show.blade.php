@extends('layouts.niceadmin')

@section('title', 'Service Detail')

@section('content')
<div class="pagetitle">
  <h1>Service Detail</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('services.index') }}">Services</a></li>
      <li class="breadcrumb-item active">Detail</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Service #{{ $service->service_id }}</h5>
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
        <a href="{{ route('services.index') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('services.edit', $service) }}" class="btn btn-primary">Edit</a>
      </div>
    </div>
  </div>
</section>
@endsection