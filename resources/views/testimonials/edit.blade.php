@extends('layouts.niceadmin')

@section('title', 'Edit Testimonial')

@section('content')
<div class="pagetitle">
  <h1>Edit Testimonial</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('testimonials.index') }}">Testimonials</a></li>
      <li class="breadcrumb-item active">Edit</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Edit Testimonial</h5>
      <form method="POST" action="{{ route('testimonials.update', $testimonial) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('testimonials._form', ['projects' => $projects, 'testimonial' => $testimonial])
        <div class="mt-3">
          <a href="{{ route('testimonials.index') }}" class="btn btn-secondary">Cancel</a>
          <button class="btn btn-primary" type="submit">Update</button>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection