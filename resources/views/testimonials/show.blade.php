@extends('layouts.niceadmin')

@section('title', 'Testimonial Detail')

@section('content')
<div class="pagetitle">
  <h1>Testimonial Detail</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('testimonials.index') }}">Testimonials</a></li>
      <li class="breadcrumb-item active">Detail</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="card">
    <div class="card-body">
      <h5 class="card-title">Testimonial #{{ $testimonial->testimonial_id }}</h5>
      <dl class="row mb-0">
        <dt class="col-sm-3">Client Name</dt>
        <dd class="col-sm-9">{{ $testimonial->client_name }}</dd>
        <dt class="col-sm-3">Project</dt>
        <dd class="col-sm-9">{{ optional($testimonial->project)->project_title ?? '-' }}</dd>
        <dt class="col-sm-3">Testimonial</dt>
        <dd class="col-sm-9">{!! nl2br(e($testimonial->testimonial_text)) !!}</dd>
      </dl>
      <div class="mt-3">
        <a href="{{ route('testimonials.index') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('testimonials.edit', $testimonial) }}" class="btn btn-primary">Edit</a>
      </div>
    </div>
  </div>
</section>
@endsection