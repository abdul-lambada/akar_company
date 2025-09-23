@extends('layouts.public')

@section('title', 'Service: ' . $service->service_name)

@section('content')
<section class="section-gap" id="service-details">
  <div class="container">
    <div class="row mb-4">
      <div class="col-12">
        <h2 class="mb-2">{{ $service->service_name }}</h2>
        @if(!is_null($service->price))
          <div class="h5 text-primary">{{ config('app.currency', 'Rp') }} {{ number_format($service->price, 0, ',', '.') }}</div>
        @endif
        <p class="text-muted">Berikut adalah proyek yang berkaitan dengan layanan ini.</p>
      </div>
    </div>

    <div class="row">
      @forelse($projects as $project)
        @php $thumb = optional($project->images->first())->image_path; @endphp
        <div class="col-lg-4 col-md-6 mb-4">
          <div class="single-portfolio d-flex flex-column p-2 border rounded h-100">
            <a href="{{ route('public.portfolio-details', $project) }}" class="d-block mb-2">
              @if($thumb)
                <img src="{{ asset('storage/'.$thumb) }}" alt="{{ $project->project_title }}" class="img-fluid rounded">
              @else
                <img src="{{ asset('public_template/img/p4.jpg') }}" alt="{{ $project->project_title }}" class="img-fluid rounded">
              @endif
            </a>
            <div class="content mt-auto">
              <h4 class="mb-1">{{ $project->project_title }}</h4>
              <p class="text-muted mb-2">Client: {{ $project->client_name }}</p>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12"><p class="text-center">Belum ada proyek untuk layanan ini.</p></div>
      @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
      {{ $projects->links() }}
    </div>
  </div>
</section>
@endsection