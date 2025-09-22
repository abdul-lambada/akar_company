@extends('layouts.niceadmin')

@section('title', 'Edit User')

@section('content')
<div class="pagetitle">
  <h1>Edit User</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
      <li class="breadcrumb-item active">Edit</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">User #{{ $user->user_id }}</h5>
      <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf
        @method('PUT')
        @include('users._form')
        <div class="mt-3">
          <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
          <button class="btn btn-primary" type="submit">Update</button>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection