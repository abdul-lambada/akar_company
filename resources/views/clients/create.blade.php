@extends('layouts.niceadmin')

@section('title', 'Create Client')

@section('content')
<div class="pagetitle">
  <h1>Create Client</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">Clients</a></li>
      <li class="breadcrumb-item active">Create</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">New Client</h5>
      <form method="POST" action="{{ route('clients.store') }}">
        @include('clients._form')
        <div class="mt-3">
          <a href="{{ route('clients.index') }}" class="btn btn-secondary">Cancel</a>
          <button class="btn btn-primary" type="submit">Save</button>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection