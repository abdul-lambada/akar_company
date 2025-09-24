@props([
  'title' => null,
  'items' => [] // [['label' => 'Home', 'url' => route('public.index')], ['label' => 'Current']]
])

<nav aria-label="breadcrumb" class="py-2">
  <ol class="breadcrumb justify-content-center mb-0">
    @foreach($items as $i => $item)
      @php
        $isLast = $i === count($items) - 1;
        $label = $item['label'] ?? '';
        $url = $item['url'] ?? null;
      @endphp
      @if(!$isLast && $url)
        <li class="breadcrumb-item"><a href="{{ $url }}">{{ $label }}</a></li>
      @else
        <li class="breadcrumb-item active" aria-current="page">{{ $label }}</li>
      @endif
    @endforeach
  </ol>
</nav>

@if($title)
  <div class="text-center mb-3">
    <h1 class="h3 m-0">{{ $title }}</h1>
  </div>
@endif
