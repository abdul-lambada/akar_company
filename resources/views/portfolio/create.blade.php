@extends('layouts.niceadmin')

@section('title', 'Add Project')

@section('content')
<div class="pagetitle">
  <h1>Add Project</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('portfolio.index') }}">Portfolio</a></li>
      <li class="breadcrumb-item active">Add</li>
    </ol>
  </nav>
</div>

<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">New Project</h5>

      <form action="{{ route('portfolio.store') }}" method="POST" class="row g-3" enctype="multipart/form-data">
        @include('portfolio._form', ['portfolio' => null, 'services' => $services, 'selectedServices' => []])
        <div class="col-12">
          <a href="{{ route('portfolio.index') }}" class="btn btn-secondary">Cancel</a>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection