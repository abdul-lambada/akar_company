@extends('layouts.bizland')
@section('title', $post->title)
@section('meta_description', Str::limit(strip_tags($post->content), 160))
@section('content')
@php
  $primaryCategory = $post->categories->first();
  $catName = $primaryCategory->name ?? 'Artikel';
  $catSlug = $primaryCategory->slug ?? 'artikel';
  $waRaw = preg_replace('/\D+/', '', (string) (config('app.company_whatsapp') ?: config('app.whatsapp_number')));
  $currentUrl = url()->current();
  $utm = 'utm_source=blog&utm_medium=whatsapp&utm_campaign=cta_article';
  $articleUrlWithUtm = $currentUrl . (Str::contains($currentUrl, '?') ? '&' : '?') . $utm;
  $topic = $catName;
  $waMessage = 'Halo, saya membaca artikel: "' . $post->title . '" (Topik: ' . $topic . ') di ' . $articleUrlWithUtm . '. Saya ingin konsultasi terkait ' . $topic . '.';
  $waLink = $waRaw ? ('https://wa.me/' . $waRaw . '?text=' . urlencode($waMessage)) : null;
@endphp

<section class="py-5 bg-light border-bottom">
  <div class="container">
    <div class="d-flex align-items-center justify-content-between">
      <div>
        <div class="text-uppercase small text-muted">Topik</div>
        <h1 class="h3 m-0">{{ $catName }}</h1>
      </div>
      <span class="badge bg-primary">{{ $catSlug }}</span>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">
        <article class="blog-article">
          @if($post->categories->count())
            <div class="mb-2">
              @foreach($post->categories as $cat)
                <a href="{{ route('public.blog', ['category' => $cat->slug]) }}" class="badge bg-secondary me-1 mb-1">{{ $cat->name }}</a>
              @endforeach
            </div>
          @endif
          <h2 class="mb-3">{{ $post->title }}</h2>
          <div class="text-muted mb-4">
            Dipublikasikan {{ $post->created_at->translatedFormat('d F Y') }}
            @if($post->read_time_minutes)
              • {{ $post->read_time_minutes }} menit baca
            @endif
          </div>
          <div class="content">
            {!! $post->content !!}
          </div>
          <hr class="my-4">
          <div class="text-center">
            @if($waLink)
              <a href="{{ $waLink }}" target="_blank" rel="noopener" class="btn btn-success btn-lg"><i class="bi bi-whatsapp me-2"></i>Konsultasi via WhatsApp</a>
              <div class="small text-muted mt-2">Topik: {{ $topic }} • Tautan menyertakan UTM untuk tracking.</div>
            @endif
          </div>
        </article>
      </div>
      <div class="col-lg-4">
        @if($post->categories->count())
          <div class="card mb-4">
            <div class="card-header">Kategori</div>
            <div class="card-body">
              @foreach($post->categories as $cat)
                <a href="{{ route('public.blog', ['category' => $cat->slug]) }}" class="badge bg-secondary me-1 mb-1">{{ $cat->name }}</a>
              @endforeach
            </div>
          </div>
        @endif
        @if(isset($related) && $related->count())
          <div class="card">
            <div class="card-header">Artikel Terkait</div>
            <ul class="list-group list-group-flush">
              @foreach($related as $rp)
                <li class="list-group-item"><a href="{{ route('public.blog-detail', $rp->slug) }}" class="text-decoration-none">{{ $rp->title }}</a></li>
              @endforeach
            </ul>
          </div>
        @endif
      </div>
    </div>
  </div>
</section>
@push('styles')
<style>
  .blog-article .content img { max-width: 100%; height: auto; border-radius: .5rem; }
</style>
@endpush
@endsection
