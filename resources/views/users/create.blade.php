@extends('layouts.niceadmin')

@section('title', 'Create User')

@section('content')
<div class="pagetitle">
  <h1>Create User</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
      <li class="breadcrumb-item active">Create</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">New User</h5>
      <form method="POST" action="{{ route('users.store') }}">
        @include('users._form')
        <div class="mt-3">
          <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
          <button class="btn btn-primary" type="submit">Save</button>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection