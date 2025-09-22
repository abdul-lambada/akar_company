@extends('layouts.niceadmin')

@section('title', 'Client Detail')

@section('content')
<div class="pagetitle">
  <h1>Client Detail</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('clients.index') }}">Clients</a></li>
      <li class="breadcrumb-item active">Detail</li>
    </ol>
  </nav>
</div>
<section class="section">
  <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Client #{{ $client->client_id }}</h5>
          <dl class="row mb-0">
            <dt class="col-sm-4">Name</dt>
            <dd class="col-sm-8">{{ $client->client_name }}</dd>
            <dt class="col-sm-4">Email</dt>
            <dd class="col-sm-8">{{ $client->email ?? '-' }}</dd>
            <dt class="col-sm-4">WhatsApp</dt>
            <dd class="col-sm-8">{{ $client->whatsapp ?? '-' }}</dd>
            <dt class="col-sm-4">Address</dt>
            <dd class="col-sm-8">{!! nl2br(e($client->address ?? '-')) !!}</dd>
          </dl>
          <div class="mt-3">
            <a href="{{ route('clients.index') }}" class="btn btn-secondary">Back</a>
            <a href="{{ route('clients.edit', $client) }}" class="btn btn-primary">Edit</a>
          </div>
        </div>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title">Invoices</h5>
            <a href="{{ route('invoices.create') }}" class="btn btn-sm btn-outline-primary"><i class="bi bi-plus-lg"></i> New Invoice</a>
          </div>
          @if(($client->invoices ?? collect())->isEmpty())
            <p class="text-muted">No invoices.</p>
          @else
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Code</th>
                    <th>Issue Date</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($client->invoices->take(10) as $inv)
                  <tr>
                    <td>{{ $inv->invoice_id }}</td>
                    <td>{{ $inv->invoice_code }}</td>
                    <td>{{ optional($inv->issue_date)->format('Y-m-d') }}</td>
                    <td><span class="badge bg-info">{{ $inv->status }}</span></td>
                    <td>Rp {{ number_format($inv->total_amount, 0, ',', '.') }}</td>
                    <td><a href="{{ route('invoices.show', $inv) }}" class="btn btn-sm btn-outline-secondary">View</a></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</section>
@endsection