@extends('layouts.bizland')
@section('title','Portfolio')
@section('content')
<section class="portfolio section">
  <div class="container section-title" data-aos="fade-up">
    <x-breadcrumbs :items="[[ 'label' => 'Home', 'url' => route('public.index') ], [ 'label' => 'Portfolio' ]]" title="Portfolio" />
    <p><span>Proyek</span> <span class="description-title">Kita</span></p>
  </div>

  <div class="container">
    <form method="get" class="row g-2 align-items-end mb-4">
      <div class="col-md-6">
        <label class="form-label">Filter Layanan</label>
        <select class="form-select" name="service[]" multiple>
          @foreach($filters as $f)
            <option value="{{ $f->service_id }}" {{ in_array($f->service_id, $activeServiceIds ?? []) ? 'selected' : '' }}>{{ $f->service_name }}</option>
          @endforeach
        </select>
        <div class="form-text">Tahan CTRL untuk memilih lebih dari satu.</div>
      </div>
      <div class="col-md-4">
        <label class="form-label">Nama Klien</label>
        <select class="form-select" name="client">
          <option value="">Semua</option>
          @foreach($clients as $client)
            <option value="{{ $client }}" {{ ($activeClientName ?? '') === $client ? 'selected' : '' }}>{{ $client }}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-2">
        <button class="btn btn-primary w-100" type="submit">Terapkan</button>
      </div>
    </form>

    <div class="row gy-4">
      @forelse($projects as $project)
        @php $cover = $project->images->first(); @endphp
        <div class="col-lg-4 col-md-6 portfolio-item">
          <div class="card h-100 border-0 shadow-sm">
            @if($cover)
              <img src="{{ $cover->url }}" class="card-img-top" alt="{{ $project->project_title }}">
            @endif
            <div class="card-body">
              <h5 class="card-title mb-1">{{ $project->project_title }}</h5>
              <p class="card-text text-muted small mb-2">{{ $project->client_name }}</p>
              <div class="small mb-2">
                @foreach(($project->services ?? []) as $sv)
                  <span class="badge bg-secondary">{{ $sv->service_name }}</span>
                @endforeach
              </div>
              <a href="{{ route('public.portfolio-details', $project) }}" class="stretched-link">Detail</a>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12 text-center text-muted">Tidak ada data.</div>
      @endforelse
    </div>

    <x-pagination :paginator="$projects" />
  </div>
</section>
@endsection
