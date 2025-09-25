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
      <div class="row g-4 align-items-start">
        <div class="col-md-3 text-center">
          <img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : asset('NiceAdmin/assets/img/profile-img.jpg') }}" alt="Avatar" class="rounded-circle" style="width:120px;height:120px;object-fit:cover;">
          @if($user->is_public)
            <div class="small text-success mt-2"><i class="bi bi-eye"></i> Public</div>
          @else
            <div class="small text-muted mt-2"><i class="bi bi-eye-slash"></i> Private</div>
          @endif
        </div>
        <div class="col-md-9">
          <dl class="row mb-0">
            <dt class="col-sm-3">Full Name</dt>
            <dd class="col-sm-9">{{ $user->full_name }}</dd>
            <dt class="col-sm-3">Username</dt>
            <dd class="col-sm-9">{{ $user->username }}</dd>
            <dt class="col-sm-3">Email</dt>
            <dd class="col-sm-9">{{ $user->email }}</dd>
            <dt class="col-sm-3">Role</dt>
            <dd class="col-sm-9"><span class="badge bg-info">{{ $user->role ?? '-' }}</span></dd>
            <dt class="col-sm-3">Job Title</dt>
            <dd class="col-sm-9">{{ $user->job_title ?? '-' }}</dd>
            <dt class="col-sm-3">Short Bio</dt>
            <dd class="col-sm-9">{{ $user->short_bio ?? '-' }}</dd>
            <dt class="col-sm-3">Display Order</dt>
            <dd class="col-sm-9">{{ $user->display_order ?? 0 }}</dd>
            <dt class="col-sm-3">Slug</dt>
            <dd class="col-sm-9">{{ $user->slug ?? '-' }}</dd>
            <dt class="col-sm-3">Experience</dt>
            <dd class="col-sm-9">{{ (int)($user->years_of_experience ?? 0) }} years</dd>
            <dt class="col-sm-3">WhatsApp (Public)</dt>
            <dd class="col-sm-9">{{ $user->whatsapp_public ?? '-' }}</dd>
            <dt class="col-sm-3">LinkedIn</dt>
            <dd class="col-sm-9">{{ $user->linkedin_url ?? '-' }}</dd>
            <dt class="col-sm-3">GitHub</dt>
            <dd class="col-sm-9">{{ $user->github_url ?? '-' }}</dd>
            <dt class="col-sm-3">Instagram</dt>
            <dd class="col-sm-9">{{ $user->instagram_url ?? '-' }}</dd>
            <dt class="col-sm-3">Website</dt>
            <dd class="col-sm-9">{{ $user->website ?? '-' }}</dd>
            <dt class="col-sm-3">Expertise</dt>
            <dd class="col-sm-9">
              @if(!empty($user->expertise))
                @foreach((array)$user->expertise as $tag)
                  <span class="badge rounded-pill text-bg-primary-subtle text-primary border border-primary-subtle">{{ $tag }}</span>
                @endforeach
              @else - @endif
            </dd>
            <dt class="col-sm-3">Skills</dt>
            <dd class="col-sm-9">
              @if(!empty($user->skills))
                @foreach((array)$user->skills as $tag)
                  <span class="badge rounded-pill text-bg-light border">{{ $tag }}</span>
                @endforeach
              @else - @endif
            </dd>
            <dt class="col-sm-3">Created</dt>
            <dd class="col-sm-9">{{ optional($user->created_at)->format('Y-m-d H:i') }}</dd>
          </dl>
        </div>
      </div>
      <div class="mt-3">
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('users.edit', $user) }}" class="btn btn-primary">Edit</a>
      </div>
    </div>
  </div>
</section>
@endsection