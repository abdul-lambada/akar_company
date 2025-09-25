@props([
  'animation' => 'fade-up',
  'duration' => 700,    // ms
  'offset' => 100,      // px
  'easing' => 'ease-out-cubic',
  'once' => true,
])

@push('styles')
<style>
  /* Respect user reduced motion preference */
  @media (prefers-reduced-motion: reduce) {
    [data-aos] { transition: none !important; }
  }
</style>
@endpush

@push('scripts')
<script>
  (function(){
    function initSectionAnimator(){
      try {
        var sections = document.querySelectorAll('section');
        sections.forEach(function(sec, idx){
          if (sec.id === 'hero' || sec.classList.contains('hero')) return; // skip hero
          if (!sec.hasAttribute('data-aos')) {
            sec.setAttribute('data-aos', @json($animation));
            // optional stagger by index but small
            var delay = Math.min(idx * 60, 240);
            sec.setAttribute('data-aos-delay', String(delay));
          }
        });
        if (typeof AOS !== 'undefined' && AOS && typeof AOS.init === 'function'){
          AOS.init({
            duration: {{ (int) $duration }},
            offset: {{ (int) $offset }},
            easing: @json($easing),
            once: {{ $once ? 'true' : 'false' }},
          });
        }
      } catch (e) { /* noop */ }
    }
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', initSectionAnimator);
    } else {
      initSectionAnimator();
    }
  })();
</script>
@endpush
