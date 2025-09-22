@extends('layouts.niceadmin')

@section('title', 'Profile')

@section('content')
<div class="pagetitle">
  <h1>Profile</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Profile</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Profile Information</h5>
          @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif
         <form action="{{ route('profile.update') }}" method="POST">
          <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3 d-flex align-items-center gap-3">
              <div>
                <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : asset('NiceAdmin/assets/img/profile-img.jpg') }}" alt="Avatar" class="rounded-circle" style="width:64px;height:64px;object-fit:cover;">
              </div>
              <div class="flex-grow-1">
                <label class="form-label" for="avatar">Avatar</label>
                <input type="file" id="avatar" name="avatar" class="form-control @error('avatar') is-invalid @enderror" accept="image/*">
                @error('avatar')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label" for="full_name">Full Name</label>
              <input type="text" id="full_name" name="full_name" class="form-control @error('full_name') is-invalid @enderror" value="{{ old('full_name', $user->full_name) }}">
              @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label" for="username">Username</label>
              <input type="text" id="username" name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $user->username) }}">
              @error('username')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label" for="email">Email</label>
              <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}">
              @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <button class="btn btn-primary" type="submit"><i class="bi bi-save"></i> Save</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Update Password</h5>
          <form action="{{ route('profile.password') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label class="form-label" for="current_password">Current Password</label>
              <input type="password" id="current_password" name="current_password" class="form-control @error('current_password') is-invalid @enderror">
              @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label" for="password">New Password</label>
              <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror">
              @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
              <label class="form-label" for="password_confirmation">Confirm New Password</label>
              <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
            </div>
            <button class="btn btn-warning" type="submit"><i class="bi bi-key"></i> Change Password</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection