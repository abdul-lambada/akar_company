@extends('layouts.bizland')
@section('title','Portfolio')
@section('content')
<section class="portfolio section">
  <div class="container section-title" data-aos="fade-up">
    <x-breadcrumbs :items="[[ 'label' => 'Home', 'url' => route('public.index') ], [ 'label' => 'Portfolio' ]]" title="Portfolio" />
    <p><span>Proyek</span> <span class="description-title">Kita</span></p>
  </div>

  <div class="container">
    <div class="card border-0 shadow-sm mb-4">
      <div class="card-body">
        <form method="get" class="row g-3 align-items-end">
          <div class="col-12 col-lg-8">
            <label class="form-label mb-2">Filter Layanan</label>
            <div class="row row-cols-2 row-cols-md-3 g-2">
              @foreach($filters as $f)
                @php $checked = in_array($f->service_id, $activeServiceIds ?? []); @endphp
                <div class="col">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="service[]" id="svc-{{ $f->service_id }}" value="{{ $f->service_id }}" {{ $checked ? 'checked' : '' }}>
                    <label class="form-check-label" for="svc-{{ $f->service_id }}">{{ $f->service_name }}</label>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
          <div class="col-12 col-lg-3">
            <label class="form-label" for="client">Nama Klien</label>
            <select class="form-select" id="client" name="client">
              <option value="">Semua</option>
              @foreach($clients as $client)
                <option value="{{ $client }}" {{ ($activeClientName ?? '') === $client ? 'selected' : '' }}>{{ $client }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-12 col-lg-1 d-grid">
            <button class="btn btn-primary" type="submit">Terapkan</button>
          </div>
          <div class="col-12 col-lg-12">
            <a href="{{ route('public.portfolio') }}" class="btn btn-link p-0">Reset filter</a>
          </div>
        </form>
        
        @if(!empty($activeServiceIds) || !empty($activeClientName))
          <div class="mt-3">
            <div class="small text-muted mb-1">Filter aktif:</div>
            <div class="d-flex flex-wrap gap-2">
              @foreach($filters as $f)
                @if(in_array($f->service_id, $activeServiceIds ?? []))
                  <span class="badge bg-primary">{{ $f->service_name }}</span>
                @endif
              @endforeach
              @if(!empty($activeClientName))
                <span class="badge bg-info text-dark">Klien: {{ $activeClientName }}</span>
              @endif
              <a href="{{ route('public.portfolio') }}" class="btn btn-sm btn-outline-secondary">Bersihkan</a>
            </div>
          </div>
        @endif
      </div>
    </div>

    <!-- Isotope Filters (client-side) -->
    <div class="isotope-layout" data-layout="masonry" data-default-filter="*" data-sort="original-order">
      <ul class="isotope-filters list-unstyled d-flex flex-wrap gap-2 justify-content-center mb-4">
        <li data-filter="*" class="btn btn-outline-secondary btn-sm filter-active">Semua</li>
        @foreach($filters as $f)
          <li data-filter=".filter-svc-{{ $f->service_id }}" class="btn btn-outline-secondary btn-sm">{{ $f->service_name }}</li>
        @endforeach
      </ul>

      <div class="isotope-container row gy-4">
        @forelse($projects as $project)
          @php
            $svcClasses = collect($project->services ?? [])->map(fn($sv) => 'filter-svc-' . $sv->service_id)->implode(' ');
          @endphp
          <div class="col-lg-4 col-md-6 portfolio-item isotope-item {{ $svcClasses }}">
            @include('components.portfolio-card', ['project' => $project])
          </div>
        @empty
          <div class="col-12 text-center text-muted">Tidak ada data.</div>
        @endforelse
      </div>
    </div>

    <x-pagination :paginator="$projects" />
  </div>
</section>
@endsection
