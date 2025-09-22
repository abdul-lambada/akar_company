@extends('layouts.niceadmin')

@section('title', 'Edit Project')

@section('content')
<div class="pagetitle">
  <h1>Edit Project</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('portfolio.index') }}">Portfolio</a></li>
      <li class="breadcrumb-item active">Edit</li>
    </ol>
  </nav>
</div>

<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Edit Project</h5>

      <form action="{{ route('portfolio.update', $portfolio) }}" method="POST" class="row g-3">
        @csrf
        @method('PUT')
        @include('portfolio._form', ['portfolio' => $portfolio, 'services' => $services, 'selectedServices' => $selectedServices])
        <div class="col-12">
          <a href="{{ route('portfolio.index') }}" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection