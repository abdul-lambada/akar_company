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
              <th>Photo</th>
              <th>Title</th>
              <th>Slug</th>
              <th>Author</th>
              <th>Categories</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($posts as $post)
              <tr>
                <td>{{ $post->post_id }}</td>
                <td>
                  @php $thumb = optional($post->images->first())->image_path; @endphp
                  @if($thumb)
                    <img src="{{ asset('storage/'.$thumb) }}" alt="thumb" class="rounded" style="width:64px;height:64px;object-fit:cover;">
                  @else
                    <div class="bg-light border rounded d-inline-flex align-items-center justify-content-center" style="width:64px;height:64px;">-</div>
                  @endif
                </td>
                <td>{{ $post->title }}</td>
                <td>{{ $post->slug }}</td>
                <td>{{ $post->user->full_name ?? $post->user->username ?? '-' }}</td>
                <td>
                  @foreach($post->categories as $cat)
                    <span class="badge bg-secondary">{{ $cat->category_name }}</span>
                  @endforeach
                </td>
                <td class="text-end">
                  @include('components.action-buttons', [
                    'viewUrl' => route('posts.show', $post),
                    'editUrl' => route('posts.edit', $post),
                    'deleteUrl' => route('posts.destroy', $post),
                    'confirm' => 'Delete this post?'
                  ])
                </td>
              </tr>
            @empty
              <tr><td colspan="7" class="text-center">No data</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      {{ $posts->links() }}
    </div>
  </div>
</section>
@endsection