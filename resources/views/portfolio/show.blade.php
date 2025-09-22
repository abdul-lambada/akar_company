@extends('layouts.niceadmin')

@section('title', 'Project Detail')

@section('content')
<div class="pagetitle">
  <h1>Project Detail</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('portfolio.index') }}">Portfolio</a></li>
      <li class="breadcrumb-item active">Detail</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Project #{{ $portfolio->project_id }}</h5>
      <dl class="row mb-0">
        <dt class="col-sm-3">Project Title</dt>
        <dd class="col-sm-9">{{ $portfolio->project_title }}</dd>
        <dt class="col-sm-3">Client Name</dt>
        <dd class="col-sm-9">{{ $portfolio->client_name }}</dd>
        <dt class="col-sm-3">Services</dt>
        <dd class="col-sm-9">
          @forelse($portfolio->services as $srv)
            <span class="badge bg-secondary">{{ $srv->service_name }}</span>
          @empty
            -
          @endforelse
        </dd>
      </dl>
      <div class="mt-3">
        <a href="{{ route('portfolio.index') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('portfolio.edit', $portfolio) }}" class="btn btn-primary">Edit</a>
      </div>
    </div>
  </div>
</section>
@endsection