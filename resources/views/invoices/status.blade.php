@extends('layouts.bizland')

@section('title', 'Status Pembayaran Invoice')

@section('content')
<div class="pagetitle">
  <h1>Status Pembayaran</h1>
</div>
<section class="section">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Invoice #{{ $invoice->invoice_code }}</h5>

          <div class="row mb-3">
            <div class="col-md-6">
              <div class="fw-bold">Diterbitkan Untuk</div>
              <div>{{ $invoice->client->client_name ?? '-' }}</div>
              {{-- Email disembunyikan sesuai kebijakan tanpa email --}}
              {{-- <div class="text-muted small">{{ $invoice->client->email ?? '-' }}</div> --}}
              <div class="text-muted small">{{ $invoice->client->whatsapp ?? '-' }}</div>
            </div>
            <div class="col-md-6">
              <div class="fw-bold">Ringkasan</div>
              <div>Kode: <strong>{{ $invoice->invoice_code }}</strong></div>
              <div>Diterbitkan: <strong>{{ optional($invoice->issue_date)->format('d M Y') }}</strong></div>
              <div>Jatuh Tempo: <strong>{{ optional($invoice->due_date)->format('d M Y') }}</strong></div>
              <div>Status: <span class="badge bg-{{ $invoice->status === 'paid' ? 'success' : 'warning' }}">{{ strtoupper($invoice->status) }}</span></div>
              <div class="mt-2">Total: <strong>@currency((float)$invoice->total_amount)</strong></div>
            </div>
          </div>

          <div class="table-responsive mb-3">
            <table class="table">
              <thead>
                <tr>
                  <th>Deskripsi</th>
                  <th class="text-end">Qty</th>
                  <th class="text-end">Harga</th>
                  <th class="text-end">Jumlah</th>
                </tr>
              </thead>
              <tbody>
                @forelse($invoice->items as $it)
                <tr>
                  <td>{{ $it->description }}</td>
                  <td class="text-end">{{ number_format($it->quantity) }}</td>
                  <td class="text-end">@currency((float)$it->unit_price)</td>
                  <td class="text-end">@currency((float)$it->line_total)</td>
                </tr>
                @empty
                <tr>
                  <td colspan="4" class="text-center text-muted">Tidak ada item.</td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          @if($invoice->status !== 'paid')
          <div class="alert alert-info">
            Jika Anda sudah melakukan pembayaran, klik tombol di bawah untuk memberi tahu kami.
          </div>
          <form action="{{ URL::signedRoute('invoices.public.paid', ['invoice' => $invoice->getKey()]) }}" method="POST">
            @csrf
            <button class="btn btn-success"><i class="bi bi-check2-circle"></i> Saya sudah membayar</button>
          </form>
          @else
          <div class="alert alert-success"><i class="bi bi-check2-circle"></i> Terima kasih! Invoice telah ditandai sebagai Lunas.</div>
          @endif

          <div class="mt-3">
            <a class="btn btn-outline-secondary" href="{{ URL::signedRoute('invoices.public.pdf', ['invoice' => $invoice->getKey()]) }}">Unduh PDF</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
