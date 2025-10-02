@extends('layouts.bizland')
@section('title','Tim Kami')
@section('content')
<section id="team" class="team section light-background">
  <div class="container" data-aos="fade-up">
    <x-breadcrumbs :items="[[ 'label' => 'Home', 'url' => route('public.index') ], [ 'label' => 'Tim' ]]" title="Tim" />
  </div>
  <x-section-heading title="Tim" subtitle="Kenalan Dengan Tim" />
  <style>
    /* Scoped styles for team cards */
    .team-card{border:0; border-radius:1rem; transition:transform .18s ease, box-shadow .18s ease; box-shadow:0 6px 18px rgba(0,0,0,.06)}
    .team-card:hover{transform:translateY(-3px); box-shadow:0 12px 28px rgba(0,0,0,.10)}
    .team-avatar{width:96px; height:96px; object-fit:cover; border-radius:999px; box-shadow:0 0 0 6px #fff, 0 8px 22px rgba(0,0,0,.10)}
    .team-title{font-weight:700}
    .team-role{color:#64748b}
    .icon-btn{display:inline-flex; align-items:center; justify-content:center; width:36px; height:36px; border-radius:999px; background:#eff3ff; color:#2563eb; transition:.18s}
    .icon-btn:hover{background:#2563eb; color:#fff}
    .bio{min-height: 42px}
  </style>
  <div class="container">
    <div class="row gy-4">
      @forelse($team as $member)
        <div class="col-md-6 col-lg-4 col-xl-3">
          <div class="team-card h-100 text-center p-4 bg-white">
            @php
              $email = strtolower(trim((string)($member->email ?? '')));
              $hash = md5($email);
              $avatar = 'https://www.gravatar.com/avatar/' . $hash . '?s=200&d=identicon';
              if (!empty($member->avatar)) {
                $avatar = \Illuminate\Support\Str::startsWith($member->avatar, ['http://','https://','/'])
                  ? $member->avatar
                  : asset('storage/'.$member->avatar);
              }
            @endphp
            <img src="{{ $avatar }}" alt="{{ $member->full_name ?? $member->name }}" class="team-avatar mx-auto mb-3">
            <h5 class="team-title mb-1">{{ $member->full_name ?? $member->name }}</h5>
            <div class="team-role small">{{ $member->job_title ?? ($member->role ?? 'Anggota Tim') }}</div>
            @if(!empty($member->short_bio))
              <p class="text-muted small mb-0 mt-3 bio">{{ $member->short_bio }}</p>
            @endif
            <div class="mt-3">
              @if(!empty($member->email))
                <div class="small"><i class="bi bi-envelope me-1"></i> {{ $member->email }}</div>
              @endif
            </div>
            @php
              // Normalize WhatsApp to 62xxxxxxxxxx
              $wa = preg_replace('/\D+/', '', (string)($member->whatsapp_public ?? ''));
              if ($wa && str_starts_with($wa, '0')) {
                $wa = '62'.substr($wa, 1);
              }
              if ($wa && str_starts_with($wa, '620')) { // handle double 0 case like 6208..
                $wa = '62'.substr($wa, 2);
              }
              if ($wa && !str_starts_with($wa, '62')) {
                // If starts with 8xxx, prefix 62
                if (str_starts_with($wa, '8')) {
                  $wa = '62'.$wa;
                }
              }
              $waLink = $wa ? 'https://wa.me/'.$wa : null;
              $years = (int) ($member->years_of_experience ?? 0);
              $expertise = (array) ($member->expertise ?? []);
              $skills = (array) ($member->skills ?? []);
              $detailUrl = !empty($member->slug) ? url('team/'.$member->slug) : null;
            @endphp
            <div class="d-flex justify-content-center gap-2 mt-3">
              @if(!empty($member->linkedin_url)) <a href="{{ $member->linkedin_url }}" class="icon-btn" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a> @endif
              @if(!empty($member->github_url)) <a href="{{ $member->github_url }}" class="icon-btn" target="_blank" rel="noopener" aria-label="GitHub"><i class="bi bi-github"></i></a> @endif
              @if(!empty($member->instagram_url)) <a href="{{ $member->instagram_url }}" class="icon-btn" target="_blank" rel="noopener" aria-label="Instagram"><i class="bi bi-instagram"></i></a> @endif
              @if(!empty($member->website)) <a href="{{ $member->website }}" class="icon-btn" target="_blank" rel="noopener" aria-label="Website"><i class="bi bi-globe"></i></a> @endif
              @if($waLink) <a href="{{ $waLink }}" class="icon-btn" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a> @endif
            </div>
            @if($years > 0)
              <div class="small text-muted mt-2">Pengalaman: {{ $years }} tahun</div>
            @endif
            @if(!empty($expertise))
              <div class="mt-2">
                @foreach($expertise as $tag)
                  <span class="badge rounded-pill text-bg-primary-subtle text-primary border border-primary-subtle">{{ $tag }}</span>
                @endforeach
              </div>
            @endif
            @if(!empty($skills))
              <div class="mt-2">
                @foreach($skills as $tag)
                  <span class="badge rounded-pill text-bg-light border">{{ $tag }}</span>
                @endforeach
              </div>
            @endif
            <div class="mt-3">
              @if($detailUrl)
                <a href="{{ $detailUrl }}" class="btn btn-outline-primary btn-sm">Detail</a>
              @else
                <button class="btn btn-outline-secondary btn-sm" type="button" disabled>Detail</button>
              @endif
            </div>
          </div>
        </div>
      @empty
        <div class="col-12 text-muted">Belum ada anggota tim.</div>
      @endforelse
    </div>
    <x-pagination :paginator="$team" />
  </div>
</section>
@endsection
