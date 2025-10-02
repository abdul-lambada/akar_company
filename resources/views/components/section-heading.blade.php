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
    <span class="badge rounded-pill badge-brand-soft">{{ $badge }}</span>
  @endif
  @if($title)
    <h2 class="mt-2">{{ $title }}</h2>
  @endif
  @if($subtitle)
    <p class="mb-0"><span>{{ $first }}</span> <span class="description-title">{{ $rest }}</span></p>
  @endif
</div>
