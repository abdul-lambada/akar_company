@extends('layouts.niceadmin')

@section('title', 'Posts')

@section('content')
<div class="pagetitle">
  <h1>Posts</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item active">Posts</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="card">
    <div class="card-body">
      <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
        <h5 class="card-title mb-0">List</h5>
        <a href="{{ route('posts.create') }}" class="btn btn-primary"><i class="bi bi-plus"></i> Add Post</a>
      </div>
      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>#</th>
              <th>Title</th>
              <th>Slug</th>
              <th>Author</th>
              <th>Categories</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($posts as $post)
              <tr>
                <td>{{ $post->post_id }}</td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->slug }}</td>
                <td>{{ $post->user->full_name ?? $post->user->username ?? '-' }}</td>
                <td>
                  @foreach($post->categories as $cat)
                    <span class="badge bg-secondary">{{ $cat->category_name }}</span>
                  @endforeach
                </td>
                <td>
                  <a class="btn btn-sm btn-info" href="{{ route('posts.show', $post) }}"><i class="bi bi-eye"></i></a>
                  <a class="btn btn-sm btn-warning" href="{{ route('posts.edit', $post) }}"><i class="bi bi-pencil"></i></a>
                  <form action="{{ route('posts.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this post?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i></button>
                  </form>
                </td>
              </tr>
            @empty
              <tr><td colspan="6" class="text-center">No data</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      {{ $posts->links() }}
    </div>
  </div>
</section>
@endsection