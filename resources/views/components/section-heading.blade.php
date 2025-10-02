@props([
  'badge' => null,
  'title' => null,
  'subtitle' => null,
  'align' => 'center', // center|start
])
@php
  $subtitle = (string) ($subtitle ?? '');
  $parts = explode(' ', trim($subtitle), 2);
  $first = $parts[0] ?? '';
  $rest  = $parts[1] ?? '';
  $alignClass = $align === 'start' ? 'text-start' : 'text-center';
@endphp
<div class="container section-title {{ $alignClass }}" data-aos="fade-up">
  @if($badge)
    <span class="badge rounded-pill text-bg-primary-soft" style="--bs-bg-opacity:.12; color: var(--brand-primary); border:1px solid color-mix(in srgb, var(--brand-primary) 30%, #fff);">{{ $badge }}</span>
  @endif
  @if($title)
    <h2 class="mt-2">{{ $title }}</h2>
  @endif
  @if($subtitle)
    <p class="mb-0"><span>{{ $first }}</span> <span class="description-title">{{ $rest }}</span></p>
  @endif
</div>
