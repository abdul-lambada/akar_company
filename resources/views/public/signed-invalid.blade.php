@extends('layouts.bizland')
@section('title', $title ?? 'Tautan Tidak Valid')
@section('content')
<section class="section">
  <x-section-heading :title="($title ?? 'Tautan Tidak Valid')" :subtitle="($message ?? 'Maaf, tautan ini tidak valid atau sudah kedaluwarsa.')" />
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
          <div class="card-body p-4">
            <div class="alert alert-warning d-flex align-items-center" role="alert">
              <i class="bi bi-exclamation-triangle me-2"></i>
              <div>
                {{ $message ?? 'Maaf, tautan ini tidak valid atau sudah kedaluwarsa. Silakan minta tautan baru atau hubungi kami.' }}
              </div>
            </div>
            <div class="d-flex gap-3">
              <a href="{{ route('public.index') }}" class="btn btn-primary">Kembali ke Beranda</a>
              <a href="{{ route('public.contact') }}" class="btn btn-outline-secondary">Hubungi Kami</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
