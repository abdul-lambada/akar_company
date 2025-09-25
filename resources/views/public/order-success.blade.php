@extends('layouts.bizland')
@section('title','Order Berhasil')
@section('meta_description','Order berhasil dikirim')
@section('content')
<section class="section">
  <div class="container section-title" data-aos="fade-up">
    <x-breadcrumbs :items="[[ 'label' => 'Home', 'url' => route('public.index') ], [ 'label' => 'Order' ]]" title="Order Berhasil" />
    <p><span>Terima</span> <span class="description-title">Kasih</span></p>
  </div>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
          <div class="card-body p-4">
            <h5 class="mb-3">Ringkasan Order</h5>
            <dl class="row mb-4">
              <dt class="col-sm-4">Order Code</dt>
              <dd class="col-sm-8">{{ $orderCodeResolved ?? ($order->order_code ?? ($order->code ?? '')) }}</dd>
              <dt class="col-sm-4">Nama</dt>
              <dd class="col-sm-8">{{ $customerNameResolved ?? ($order->customer_name ?? ($order->name ?? '')) }}</dd>
              <dt class="col-sm-4">Email</dt>
              <dd class="col-sm-8">{{ $customerEmailResolved ?? ($order->customer_email ?? ($order->email ?? '')) }}</dd>
              <dt class="col-sm-4">WhatsApp</dt>
              <dd class="col-sm-8">{{ $customerWaResolved ?? ($order->whatsapp_number ?? ($order->customer_whatsapp ?? ($order->phone ?? ($order->phone_number ?? '')))) }}</dd>
              @if($serviceName)
              <dt class="col-sm-4">Layanan</dt><dd class="col-sm-8">{{ $serviceName }}</dd>
              @endif
              @if(!empty($order->package_name))
              <dt class="col-sm-4">Paket</dt><dd class="col-sm-8">{{ $order->package_name }}</dd>
              @endif
              @if(!empty($order->budget))
              <dt class="col-sm-4">Budget</dt><dd class="col-sm-8">Rp {{ number_format((float)$order->budget,0,',','.') }}</dd>
              @endif
              @if(!empty($order->notes))
              <dt class="col-sm-4">Catatan</dt><dd class="col-sm-8">{{ $order->notes }}</dd>
              @endif
            </dl>

            <div class="alert alert-info d-flex align-items-center" role="alert">
              <i class="bi bi-info-circle me-2"></i>
              Tim kami akan menghubungi Anda. Anda bisa mempercepat proses dengan chat langsung via WhatsApp di bawah.
            </div>

            <div class="d-flex gap-3">
              <a href="{{ $waLink }}" target="_blank" rel="noopener" class="btn btn-success"><i class="bi bi-whatsapp me-2"></i>Chat Admin via WhatsApp</a>
              <a href="{{ route('public.index') }}" class="btn btn-outline-secondary">Kembali ke Beranda</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
