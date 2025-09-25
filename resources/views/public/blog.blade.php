@extends('layouts.bizland')
@section('title','Blog')
@section('content')
<section class="section">
  <div class="container section-title" data-aos="fade-up">
    <x-breadcrumbs :items="[[ 'label' => 'Home', 'url' => route('public.index') ], [ 'label' => 'Blog' ]]" title="Blog" />
    <p><span>Tulisan</span> <span class="description-title">Terbaru</span></p>
  </div>
  <div class="container">
    <div class="row gy-4">
      @forelse($posts as $post)
        <div class="col-lg-4 col-md-6">
          @include('components.post-card', ['post' => $post])
        </div>
      @empty
        <div class="col-12 text-center text-muted">Belum ada postingan.</div>
      @endforelse
    </div>
    <x-pagination :paginator="$posts" />
  </div>
</section>
@endsection
