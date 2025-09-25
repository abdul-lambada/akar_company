@extends('layouts.niceadmin')

@section('title', 'Invoice Detail')

@section('content')
<div class="pagetitle">
  <h1>Invoice Detail</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('invoices.index') }}">Invoices</a></li>
      <li class="breadcrumb-item active">Detail</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="row">
    <div class="col-lg-8">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Invoice #{{ $invoice->invoice_code }}</h5>
          <dl class="row mb-0">
            <dt class="col-sm-4">Client</dt>
            <dd class="col-sm-8">
              @if($invoice->client)
                <a href="{{ route('clients.show', $invoice->client) }}">{{ $invoice->client->client_name }}</a>
              @else
                -
              @endif
            </dd>
            <dt class="col-sm-4">Issue Date</dt>
            <dd class="col-sm-8">{{ optional($invoice->issue_date)->format('Y-m-d') }}</dd>
            <dt class="col-sm-4">Due Date</dt>
            <dd class="col-sm-8">{{ optional($invoice->due_date)->format('Y-m-d') }}</dd>
            <dt class="col-sm-4">Status</dt>
            <dd class="col-sm-8"><span class="badge bg-info">{{ $invoice->status }}</span></dd>
            <dt class="col-sm-4">Total</dt>
            <dd class="col-sm-8">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</dd>
          </dl>
          <div class="mt-3">
            <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Back</a>
            <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('invoices.pdf', $invoice) }}" class="btn btn-outline-success">Unduh PDF</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection