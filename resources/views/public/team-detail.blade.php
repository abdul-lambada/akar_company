@extends('layouts.bizland')
@section('title', $member->full_name ?? 'Anggota Tim')
@section('content')
<section class="section py-5">
  <div class="container" data-aos="fade-up">
    <x-breadcrumbs :items="[[ 'label' => 'Home', 'url' => route('public.index') ], [ 'label' => 'Tim', 'url' => route('public.team') ], [ 'label' => ($member->full_name ?? $member->name) ]]" title="Tim" />
  </div>
  <x-section-heading :title="($member->full_name ?? $member->name)" :subtitle="($member->job_title ?? ($member->role ?? 'Anggota Tim'))" align="start" />
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-4">
        @php
          $email = strtolower(trim((string)($member->email ?? '')));
          $hash = md5($email);
          $avatar = 'https://www.gravatar.com/avatar/' . $hash . '?s=400&d=identicon';
          if (!empty($member->avatar)) {
            $avatar = \Illuminate\Support\Str::startsWith($member->avatar, ['http://','https://','/'])
              ? $member->avatar
              : asset('storage/'.$member->avatar);
          }
          $wa = preg_replace('/\D+/', '', (string)($member->whatsapp_public ?? ''));
          if ($wa && str_starts_with($wa, '0')) { $wa = '62'.substr($wa, 1); }
          if ($wa && str_starts_with($wa, '620')) { $wa = '62'.substr($wa, 2); }
          if ($wa && !str_starts_with($wa, '62') && str_starts_with($wa, '8')) { $wa = '62'.$wa; }
          $waLink = $wa ? 'https://wa.me/'.$wa : null;
        @endphp
        <div class="card border-0 shadow-sm p-3 text-center">
          <img src="{{ $avatar }}" alt="{{ $member->full_name ?? $member->name }}" class="img-fluid rounded" style="border-radius:1rem;">
          <h3 class="mt-3 mb-0">{{ $member->full_name ?? $member->name }}</h3>
          <div class="text-muted">{{ $member->job_title ?? ($member->role ?? 'Anggota Tim') }}</div>
          <div class="d-flex justify-content-center gap-2 mt-3">
            @if(!empty($member->linkedin_url)) <a href="{{ $member->linkedin_url }}" class="btn btn-outline-primary btn-sm" target="_blank" rel="noopener"><i class="bi bi-linkedin me-1"></i>LinkedIn</a> @endif
            @if(!empty($member->github_url)) <a href="{{ $member->github_url }}" class="btn btn-outline-dark btn-sm" target="_blank" rel="noopener"><i class="bi bi-github me-1"></i>GitHub</a> @endif
            @if(!empty($member->instagram_url)) <a href="{{ $member->instagram_url }}" class="btn btn-outline-danger btn-sm" target="_blank" rel="noopener"><i class="bi bi-instagram me-1"></i>Instagram</a> @endif
            @if(!empty($member->website)) <a href="{{ $member->website }}" class="btn btn-outline-secondary btn-sm" target="_blank" rel="noopener"><i class="bi bi-globe me-1"></i>Website</a> @endif
            @if($waLink) <a href="{{ $waLink }}" class="btn btn-success btn-sm" target="_blank" rel="noopener"><i class="bi bi-whatsapp me-1"></i>WhatsApp</a> @endif
          </div>
          @if(($member->years_of_experience ?? 0) > 0)
            <div class="small text-muted mt-2">Pengalaman: {{ (int)$member->years_of_experience }} tahun</div>
          @endif
        </div>
      </div>
      <div class="col-lg-8">
        <div class="card border-0 shadow-sm p-4">
          <h4 class="mb-3">Tentang</h4>
          <p class="mb-0">{{ $member->short_bio ?? 'Belum ada deskripsi.' }}</p>
          @php
            $expertise = (array) ($member->expertise ?? []);
            $skills = (array) ($member->skills ?? []);
          @endphp
          @if(!empty($expertise))
            <h6 class="mt-4">Expertise</h6>
            <div class="d-flex flex-wrap gap-2">
              @foreach($expertise as $tag)
                <span class="badge rounded-pill text-bg-primary-subtle text-primary border border-primary-subtle">{{ $tag }}</span>
              @endforeach
            </div>
          @endif
          @if(!empty($skills))
            <h6 class="mt-4">Skills</h6>
            <div class="d-flex flex-wrap gap-2">
              @foreach($skills as $tag)
                <span class="badge rounded-pill text-bg-light border">{{ $tag }}</span>
              @endforeach
            </div>
          @endif
        </div>

        <div class="card border-0 shadow-sm p-4 mt-4">
          <h4 class="mb-3">Tulisan Terbaru</h4>
          @if($posts->count())
            <div class="row g-3">
              @foreach($posts as $post)
                <div class="col-md-6">
                  <a href="{{ route('public.blog-detail', $post->slug) }}" class="text-decoration-none">
                    <div class="p-3 border rounded-3 h-100">
                      <div class="fw-semibold">{{ $post->title }}</div>
                      <div class="small text-muted">{{ optional($post->created_at)->format('d M Y') }}</div>
                    </div>
                  </a>
                </div>
              @endforeach
            </div>
          @else
            <div class="text-muted small">Belum ada tulisan.</div>
          @endif
        </div>

        <div class="card border-0 shadow-sm p-4 mt-4">
          <h4 class="mb-3">Proyek Terkait</h4>
          @if($projects->count())
            <div class="row g-3">
              @foreach($projects as $project)
                <div class="col-md-6">
                  <a href="{{ route('public.portfolio-details', $project) }}" class="text-decoration-none">
                    <div class="p-3 border rounded-3 h-100">
                      <div class="fw-semibold">{{ $project->project_title ?? ('Project #'.$project->id) }}</div>
                      <div class="small text-muted">{{ optional($project->created_at)->format('d M Y') }}</div>
                    </div>
                  </a>
                </div>
              @endforeach
            </div>
          @else
            <div class="text-muted small">Belum ada proyek terkait.</div>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
