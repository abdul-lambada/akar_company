@extends('layouts.niceadmin')

@section('title', 'User Detail')

@section('content')
<div class="pagetitle">
  <h1>User Detail</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
      <li class="breadcrumb-item active">Detail</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">User #{{ $user->user_id }}</h5>
      <dl class="row mb-0">
        <dt class="col-sm-3">Full Name</dt>
        <dd class="col-sm-9">{{ $user->full_name }}</dd>
        <dt class="col-sm-3">Username</dt>
        <dd class="col-sm-9">{{ $user->username }}</dd>
        <dt class="col-sm-3">Email</dt>
        <dd class="col-sm-9">{{ $user->email }}</dd>
        <dt class="col-sm-3">Role</dt>
        <dd class="col-sm-9"><span class="badge bg-info">{{ $user->role ?? '-' }}</span></dd>
        <dt class="col-sm-3">Created</dt>
        <dd class="col-sm-9">{{ optional($user->created_at)->format('Y-m-d H:i') }}</dd>
      </dl>
      <div class="mt-3">
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">Edit</a>
      </div>
    </div>
  </div>
</section>
@endsection