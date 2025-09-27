<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>@yield('title', 'Dashboard') - {{ config('app.name', 'Akar Company') }}</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  <link href="{{ asset('images/favicon.png') }}" rel="icon">
  @php($logoUrl = config('app.logo') ? asset(\Illuminate\Support\Str::startsWith(config('app.logo'), ['http://','https://','storage/','/']) ? config('app.logo') : 'storage/'.config('app.logo')) : asset('NiceAdmin/assets/img/logo.png'))
  <link href="{{ $logoUrl }}" rel="apple-touch-icon">
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
  <link href="{{ asset('NiceAdmin/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
  <link href="{{ asset('NiceAdmin/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
  <link href="{{ asset('NiceAdmin/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
  <link href="{{ asset('NiceAdmin/assets/vendor/quill/quill.snow.css') }}" rel="stylesheet">
  <link href="{{ asset('NiceAdmin/assets/vendor/quill/quill.bubble.css') }}" rel="stylesheet">
  <link href="{{ asset('NiceAdmin/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
  <link href="{{ asset('NiceAdmin/assets/vendor/simple-datatables/style.css') }}" rel="stylesheet">
  <link href="{{ asset('NiceAdmin/assets/css/style.css') }}" rel="stylesheet">
  @stack('styles')
  <style>
    /* subtle blink near the end */
    #idleIndicator.blink .badge { animation: idleBlink 1s linear infinite; }
    @keyframes idleBlink { 0%, 60% { opacity: 1 } 80% { opacity: .35 } 100% { opacity: 1 } }
    /* ring bell animation */
    .bell-ring { animation: bellRing 1s ease-in-out 2; transform-origin: 50% 0; display:inline-block; }
    @keyframes bellRing { 0% { transform: rotate(0deg) } 20% { transform: rotate(15deg) } 40% { transform: rotate(-12deg) } 60% { transform: rotate(8deg) } 80% { transform: rotate(-5deg) } 100% { transform: rotate(0deg) } }
  </style>
</head>
<body>
@include('partials.header')

@if(auth()->check())
  @include('partials.sidebar')
@endif

<main id="main" class="main">
  @yield('content')
</main>

@includeWhen(auth()->check(), 'partials.footer')

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<script src="{{ asset('NiceAdmin/assets/vendor/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('NiceAdmin/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('NiceAdmin/assets/vendor/chart.js/chart.umd.js') }}"></script>
<script src="{{ asset('NiceAdmin/assets/vendor/echarts/echarts.min.js') }}"></script>
<script src="{{ asset('NiceAdmin/assets/vendor/quill/quill.js') }}"></script>
<script src="{{ asset('NiceAdmin/assets/vendor/simple-datatables/simple-datatables.js') }}"></script>
<script src="{{ asset('NiceAdmin/assets/vendor/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('NiceAdmin/assets/vendor/php-email-form/validate.js') }}"></script>
<script src="{{ asset('NiceAdmin/assets/js/main.js') }}"></script>

<script>
(function(){
  // Hanya aktif di backend untuk user login
  const isAuthed = {{ auth()->check() ? 'true' : 'false' }};
  if(!isAuthed) return;

  const IDLE_THRESHOLD_MS = 60 * 1000; // 1 menit tanpa aktivitas
  const COUNTDOWN_START = 30; // detik
  let idleTimer = null;
  let countdownTimer = null;
  let countdown = COUNTDOWN_START;
  const indicator = document.getElementById('idleIndicator');
  const secsEl = document.getElementById('idleSecs');
  const extendBtn = document.getElementById('idleExtendBtn');

  // audio ringan untuk notifikasi (data URI beep pendek)
  const notifAudio = new Audio('data:audio/mp3;base64,//uQZAAAAAAAAAAAAAAAAAAAAAAAWGluZwAAAA8AAAACAAACcQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA');

  function showIndicator() {
    if(indicator) {
      indicator.classList.remove('d-none');
      indicator.classList.toggle('blink', countdown <= 10);
      if(secsEl) secsEl.textContent = String(countdown);
    }
  }
  function hideIndicator() {
    if(indicator) {
      indicator.classList.add('d-none');
      indicator.classList.remove('blink');
    }
  }

  function startCountdown() {
    countdown = COUNTDOWN_START;
    showIndicator();
    // bunyikan notifikasi ringan dan ring icon
    try { notifAudio.currentTime = 0; notifAudio.play().catch(()=>{}); } catch(e) {}
    const icon = indicator?.querySelector('.bi-hourglass-split');
    if(icon) { icon.classList.add('bell-ring'); setTimeout(()=> icon.classList.remove('bell-ring'), 2000); }

    if(countdownTimer) clearInterval(countdownTimer);
    countdownTimer = setInterval(() => {
      countdown--;
      showIndicator();
      if(countdown <= 0) {
        clearInterval(countdownTimer);
        // Auto logout aman: kirim form POST ke route('logout')
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route('logout') }}';
        const token = document.createElement('input');
        token.type = 'hidden';
        token.name = '_token';
        token.value = '{{ csrf_token() }}';
        form.appendChild(token);
        document.body.appendChild(form);
        form.submit();
      }
    }, 1000);
  }

  function resetIdle() {
    // Reset timer dan sembunyikan indikator
    if(idleTimer) clearTimeout(idleTimer);
    if(countdownTimer) { clearInterval(countdownTimer); countdownTimer = null; }
    hideIndicator();
    idleTimer = setTimeout(startCountdown, IDLE_THRESHOLD_MS);
  }

  // Event yang dianggap aktivitas
  const activityEvents = ['mousemove','mousedown','keydown','scroll','touchstart','click'];
  activityEvents.forEach(ev => window.addEventListener(ev, resetIdle, {passive:true}));

  // tombol perpanjang sesi
  if(extendBtn) {
    extendBtn.addEventListener('click', function(e){
      e.preventDefault();
      resetIdle();
    });
  }

  // Inisialisasi pertama kali
  resetIdle();
})();
</script>

@stack('scripts')
</body>
</html>