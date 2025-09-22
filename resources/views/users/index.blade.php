@extends('layouts.niceadmin')

@section('title', 'Users')

@section('content')
<div class="pagetitle">
  <h1>Users</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Users</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mt-3">
        <h5 class="card-title m-0">List Users</h5>
        <a href="{{ route('users.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> New User</a>
      </div>
      @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Full Name</th>
              <th>Username</th>
              <th>Email</th>
              <th>Role</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($users as $usr)
            <tr>
              <td>{{ $usr->user_id }}</td>
              <td>{{ $usr->full_name }}</td>
              <td>{{ $usr->username }}</td>
              <td>{{ $usr->email }}</td>
              <td><span class="badge bg-info">{{ $usr->role ?? '-' }}</span></td>
              <td>
                <a href="{{ route('users.show', $usr) }}" class="btn btn-sm btn-outline-secondary"><i class="bi bi-eye"></i></a>
                <a href="{{ route('users.edit', $usr) }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-pencil"></i></a>
                <form action="{{ route('users.destroy', $usr) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this user?')">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash"></i></button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="6" class="text-center">No users found.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      <div>
        {{ $users->links() }}
      </div>
    </div>
  </div>
</section>
@endsection