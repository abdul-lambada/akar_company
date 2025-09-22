@extends('layouts.niceadmin')

@section('title', 'Orders')

@section('content')
<div class="pagetitle">
  <h1>Orders</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
      <li class="breadcrumb-item active">Orders</li>
    </ol>
  </nav>
</div>

<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Orders</h5>
      <p>Coming soon...</p>
    </div>
  </div>
</section>
@endsection