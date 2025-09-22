@extends('layouts.niceadmin')

@section('title', 'Add Testimonial')

@section('content')
<div class="pagetitle">
  <h1>Add Testimonial</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('testimonials.index') }}">Testimonials</a></li>
      <li class="breadcrumb-item active">Create</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Create Testimonial</h5>
      <form method="POST" action="{{ route('testimonials.store') }}">
        @csrf
        @include('testimonials._form', ['projects' => $projects])
        <div class="mt-3">
          <a href="{{ route('testimonials.index') }}" class="btn btn-secondary">Cancel</a>
          <button class="btn btn-primary" type="submit">Save</button>
        </div>
      </form>
    </div>
  </div>
</section>
@endsection