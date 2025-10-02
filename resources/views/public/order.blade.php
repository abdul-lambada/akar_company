@extends('layouts.bizland')
@section('title','Order')
@section('meta_description','Form order layanan')
@section('content')
<section class="section">
  <div class="container" data-aos="fade-up">
    <x-breadcrumbs :items="[[ 'label' => 'Home', 'url' => route('public.index') ], [ 'label' => 'Order' ]]" title="Order" />
  </div>
  <x-section-heading title="Order" subtitle="Mulai Order Anda" />
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
          <div class="card-body p-4">
            @if($errors->has('recaptcha'))
              <div class="alert alert-danger" role="alert">
                {{ $errors->first('recaptcha') }}
              </div>
            @endif
            @if($errors->has('form'))
              <div class="alert alert-danger" role="alert">
                {{ $errors->first('form') }}
              </div>
            @endif
            <form method="post" action="{{ route('public.order.store') }}" class="needs-validation" novalidate>
              @csrf
              @php $recaptchaSiteKey = config('services.recaptcha.site_key'); @endphp
              
              <!-- Honeypot: should remain empty -->
              <div style="position:absolute;left:-9999px;top:auto;width:1px;height:1px;overflow:hidden;">
                <label>Website</label>
                <input type="text" name="website" tabindex="-1" autocomplete="off">
              </div>
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label">Nama Lengkap</label>
                  <input type="text" name="customer_name" value="{{ old('customer_name') }}" class="form-control @error('customer_name') is-invalid @enderror" required>
                  <div class="invalid-feedback">Nama wajib diisi.</div>
                  @error('customer_name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label">Email</label>
                  <input type="email" name="customer_email" value="{{ old('customer_email') }}" class="form-control @error('customer_email') is-invalid @enderror" required>
                  <div class="invalid-feedback">Email valid wajib diisi.</div>
                  @error('customer_email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label">Nomor WhatsApp</label>
                  <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number') }}" class="form-control @error('whatsapp_number') is-invalid @enderror" placeholder="08xxxxxxxxxx" required>
                  <div class="invalid-feedback">Nomor WhatsApp wajib diisi.</div>
                  @error('whatsapp_number')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label">Produk/Layanan</label>
                  <select name="service_id" class="form-select @error('service_id') is-invalid @enderror" required>
                    <option value="">Pilih (opsional)</option>
                    @foreach($services as $s)
                      <option value="{{ $s->getKey() }}" {{ (old('service_id', $prefill['service_id'] ?? null) == $s->getKey()) ? 'selected' : '' }}>{{ $s->service_name }}</option>
                    @endforeach
                  </select>
                  @error('service_id')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label">Paket</label>
                  <input type="text" name="package_name" value="{{ old('package_name', $prefill['package_name'] ?? '') }}" class="form-control @error('package_name') is-invalid @enderror" placeholder="Nama paket (opsional)">
                  @error('package_name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label">Budget (Rp)</label>
                  <input type="number" name="budget" value="{{ old('budget', $prefill['budget'] ?? '') }}" class="form-control @error('budget') is-invalid @enderror" min="0" step="10000" placeholder="Contoh: 5000000">
                  @error('budget')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
                <div class="col-12">
                  <label class="form-label">Catatan/Brief</label>
                  <textarea name="notes" rows="4" class="form-control @error('notes') is-invalid @enderror" placeholder="Ceritakan kebutuhan Anda...">{{ old('notes') }}</textarea>
                  @error('notes')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                </div>
              </div>

              @if(!empty($recaptchaSiteKey))
              <div class="mt-4">
                <label class="form-label">Verifikasi Keamanan</label>
                <div class="g-recaptcha" data-sitekey="{{ $recaptchaSiteKey }}"></div>
                @if($errors->has('recaptcha'))
                  <div class="invalid-feedback d-block">{{ $errors->first('recaptcha') }}</div>
                @endif
              </div>
              @endif

              <div class="d-flex align-items-center gap-3 mt-4">
                <button class="btn btn-primary" type="submit">Kirim Order</button>
                <a href="{{ route('public.index') }}" class="btn btn-outline-secondary">Batal</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@push('scripts')
<script>
  (function(){
    var forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function(form){
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  })();
</script>
@if(!empty($recaptchaSiteKey))
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endif
@endpush
@endsection
