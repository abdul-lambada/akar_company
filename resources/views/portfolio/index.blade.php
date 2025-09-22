@extends('layouts.niceadmin')

@section('title', 'Portfolio')

@section('content')
<div class="pagetitle">
  <h1>Portfolio</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item active">Portfolio</li>
    </ol>
  </nav>
</div>

<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Portfolio</h5>
      <p>Coming soon...</p>
    </div>
  </div>
</section>
@endsection