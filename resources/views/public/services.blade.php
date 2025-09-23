@extends('layouts.strategy')

@section('title', 'Services - ' . config('app.name', 'Akar Company'))
@section('meta_description', config('app.services_description'))
@section('meta_keywords', 'layanan, jasa, agency')

@section('content')
  <section class="section" id="services">
    <div class="container section-title" data-aos="fade-up">
      <h2>{{ config('app.services_heading') }}</h2>
      <div><span>All</span> <span class="description-title">{{ config('app.services_description') }}</span></div>
    </div>
    <div class="container">
      <div class="row gy-4">
        @foreach($services as $service)
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <x-service-card :service="$service" />
        </div>
        @endforeach
      </div>
      <div class="mt-4">
        {{ $services->links() }}
      </div>
    </div>
  </section>
@endsection